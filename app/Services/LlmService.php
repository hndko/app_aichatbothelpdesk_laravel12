<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LlmService
{
    protected string $provider;
    protected string $apiKey;
    protected string $baseUrl;
    protected string $model;
    protected int $timeout;

    public function __construct()
    {
        $this->provider = config('services.llm.provider', 'openrouter');
        $this->apiKey   = config('services.llm.api_key', '');
        $this->baseUrl  = config('services.llm.base_url', 'https://openrouter.ai/api/v1');
        $this->model    = config('services.llm.model', 'openai/gpt-3.5-turbo');
        $this->timeout  = config('services.llm.timeout', 30);
    }

    /**
     * Kirim pesan ke LLM API dan kembalikan respons teks.
     *
     * @param string $userMessage Pesan dari user
     * @param string $systemPrompt Instruksi/system prompt untuk AI
     * @param array  $chatHistory Riwayat percakapan sebelumnya [['role'=>'user/assistant','content'=>'...']]
     * @return string Respons teks dari AI
     */
    public function chat(string $userMessage, string $systemPrompt = '', array $chatHistory = []): string
    {
        try {
            $messages = [];

            // System prompt
            if (!empty($systemPrompt)) {
                $messages[] = [
                    'role'    => 'system',
                    'content' => $systemPrompt,
                ];
            }

            // Riwayat percakapan sebelumnya (maks 10 pesan terakhir)
            $recentHistory = array_slice($chatHistory, -10);
            foreach ($recentHistory as $msg) {
                $messages[] = [
                    'role'    => $msg['role'],
                    'content' => $msg['content'],
                ];
            }

            // Pesan user terbaru
            $messages[] = [
                'role'    => 'user',
                'content' => $userMessage,
            ];

            $response = $this->sendRequest($messages);

            return $response;
        } catch (\Exception $e) {
            Log::error('LLM Service Error: ' . $e->getMessage(), [
                'provider' => $this->provider,
                'model'    => $this->model,
            ]);

            return $this->fallbackResponse($e);
        }
    }

    /**
     * Kirim HTTP request ke LLM API (OpenAI-compatible format).
     */
    protected function sendRequest(array $messages): string
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ];

        // Header tambahan khusus OpenRouter
        if ($this->provider === 'openrouter') {
            $headers['HTTP-Referer'] = config('app.url', 'http://localhost');
            $headers['X-Title']      = config('app.name', 'MariDesk AI');
        }

        $payload = [
            'model'       => $this->model,
            'messages'    => $messages,
            'max_tokens'  => 1024,
            'temperature' => 0.7,
        ];

        $response = Http::withHeaders($headers)
            ->timeout($this->timeout)
            ->post(rtrim($this->baseUrl, '/') . '/chat/completions', $payload);

        if ($response->failed()) {
            $errorBody = $response->json('error.message', $response->body());
            throw new \RuntimeException('LLM API returned error: ' . $errorBody);
        }

        $content = $response->json('choices.0.message.content', '');

        if (empty($content)) {
            throw new \RuntimeException('LLM API returned empty response.');
        }

        return trim($content);
    }

    /**
     * Pesan fallback ramah saat API gagal.
     */
    protected function fallbackResponse(\Exception $e): string
    {
        $isTimeout = str_contains($e->getMessage(), 'timed out') || str_contains($e->getMessage(), 'cURL error 28');

        if ($isTimeout) {
            return "⏳ Maaf, server AI sedang sibuk dan memerlukan waktu lebih lama dari biasanya. Silakan coba lagi dalam beberapa saat, atau hubungi teknisi IT secara langsung.";
        }

        return "🤖 Maaf, asisten AI kami sedang tidak tersedia saat ini. Tim IT Helpdesk akan segera membantu Anda secara manual. Terima kasih atas kesabarannya!";
    }

    /**
     * Bangun system prompt untuk helpdesk berdasarkan knowledge base.
     */
    public static function buildHelpdeskPrompt(array $knowledgeItems = []): string
    {
        $prompt = <<<PROMPT
Kamu adalah MariDesk AI, asisten virtual IT Helpdesk yang cerdas dan ramah.
Tugasmu adalah membantu karyawan perusahaan menyelesaikan kendala teknis IT.

ATURAN:
1. Jawab dalam Bahasa Indonesia dengan gaya profesional namun ramah.
2. Jika pertanyaan terkait kendala IT, berikan solusi step-by-step yang mudah diikuti.
3. Jika pertanyaan di luar domain IT/teknis, arahkan user untuk menghubungi bagian terkait.
4. Jangan pernah memberikan informasi sensitif seperti password atau API key.
5. Jika tidak yakin dengan jawabannya, sarankan user untuk menunggu balasan dari teknisi IT manusia.
6. Gunakan emoji secukupnya agar terasa friendly (tidak berlebihan).
PROMPT;

        if (!empty($knowledgeItems)) {
            $prompt .= "\n\nBERIKUT ADALAH KNOWLEDGE BASE FAQ PERUSAHAAN (Gunakan sebagai referensi utama jawaban):";
            foreach ($knowledgeItems as $idx => $item) {
                $num = $idx + 1;
                $prompt .= "\n\n--- FAQ #{$num} ---";
                $prompt .= "\nQ: {$item['question']}";
                $prompt .= "\nA: {$item['answer']}";
            }
            $prompt .= "\n\n---\nJika pertanyaan user cocok dengan FAQ di atas, prioritaskan jawaban dari knowledge base tersebut.";
        }

        return $prompt;
    }

    /**
     * Deteksi sentimen dari teks masukan (positive, neutral, negative).
     */
    public function analyzeSentiment(string $text): string
    {
        try {
            $prompt = "Analisis sentimen dari teks keluhan/pesan IT helpdesk berikut. Balas HANYA dengan KATA TUNGGAL dalam bahasa inggris: 'positive' (jika ramah/puas/mengucapkan terima kasih), 'neutral' (jika biasa/netral/melaporkan masalah secara normal), atau 'negative' (jika marah/frustrasi/kecewa/urgent sekali). Jangan tambahkan tanda baca atau kata lain.";
            
            $messages = [
                ['role' => 'system', 'content' => $prompt],
                ['role' => 'user', 'content' => substr($text, 0, 500)],
            ];

            $response = $this->sendRequest($messages);
            $clean = strtolower(trim(preg_replace('/[^a-zA-Z]/', '', $response)));

            if (in_array($clean, ['positive', 'neutral', 'negative'])) {
                return $clean;
            }

            if (str_contains($clean, 'positi')) return 'positive';
            if (str_contains($clean, 'negati')) return 'negative';

            return 'neutral';
        } catch (\Exception $e) {
            Log::warning('Sentiment Analysis Fallback: ' . $e->getMessage());
            return 'neutral';
        }
    }

    /**
     * Static helper untuk analisis sentimen.
     */
    public static function detectSentiment(string $text): string
    {
        $instance = new self();
        return $instance->analyzeSentiment($text);
    }
}
