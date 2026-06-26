<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\KnowledgeBase;
use App\Models\Ticket;
use App\Services\LlmService;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    /**
     * Kirim pesan chat dan dapatkan respons AI via AJAX.
     */
    public function sendMessage(Request $request, string $ticketId)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $ticket = Ticket::with('chatHistories')->findOrFail($ticketId);

        // Cek hak akses: user hanya bisa chat di tiket miliknya, admin bebas
        $user = auth()->user();
        if ($user->isUser() && $ticket->user_id !== $user->id) {
            return response()->json(['error' => 'Akses ditolak.'], 403);
        }

        $senderType = $user->isAdmin() ? 'admin' : 'user';

        // Simpan pesan user/admin
        $userChat = ChatHistory::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => $user->id,
            'sender_type' => $senderType,
            'message'     => $validated['message'],
        ]);

        $responseData = [
            'user_chat' => [
                'id'          => $userChat->id,
                'sender_type' => $userChat->sender_type,
                'sender_name' => $user->name,
                'message'     => $userChat->message,
                'time'        => $userChat->created_at->format('H:i'),
            ],
            'bot_chat' => null,
        ];

        // Hanya trigger AI jika pengirim adalah user (bukan admin)
        if ($senderType === 'user' && $ticket->status !== 'closed') {
            $botReply = $this->getAiResponse($ticket, $validated['message']);

            $botChat = ChatHistory::create([
                'ticket_id'   => $ticket->id,
                'user_id'     => null,
                'sender_type' => 'bot',
                'message'     => $botReply,
            ]);

            $responseData['bot_chat'] = [
                'id'          => $botChat->id,
                'sender_type' => 'bot',
                'sender_name' => 'NexusDesk AI Bot',
                'message'     => $botReply,
                'time'        => $botChat->created_at->format('H:i'),
            ];
        }

        return response()->json($responseData);
    }

    /**
     * Dapatkan respons dari AI LLM berdasarkan knowledge base dan riwayat chat.
     */
    protected function getAiResponse(Ticket $ticket, string $userMessage): string
    {
        // Ambil knowledge base aktif sesuai kategori tiket
        $knowledgeItems = KnowledgeBase::active()
            ->where(function ($q) use ($ticket) {
                $q->where('category_id', $ticket->category_id)
                  ->orWhereNull('category_id');
            })
            ->get(['question', 'answer'])
            ->toArray();

        // Bangun system prompt
        $systemPrompt = LlmService::buildHelpdeskPrompt($knowledgeItems);

        // Siapkan riwayat chat untuk konteks AI
        $chatHistory = $ticket->chatHistories()
            ->latest()
            ->limit(10)
            ->get()
            ->reverse()
            ->map(function ($chat) {
                return [
                    'role'    => $chat->sender_type === 'user' ? 'user' : 'assistant',
                    'content' => $chat->message,
                ];
            })
            ->values()
            ->toArray();

        // Panggil LLM Service
        $llm = new LlmService();

        return $llm->chat($userMessage, $systemPrompt, $chatHistory);
    }
}
