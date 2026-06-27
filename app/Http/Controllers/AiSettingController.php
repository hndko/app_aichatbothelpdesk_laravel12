<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class AiSettingController extends Controller
{
    /**
     * Tampilkan halaman kelola konfigurasi provider & model AI.
     */
    public function index()
    {
        $data['title'] = 'Konfigurasi AI Provider & Model';
        $data['ai_provider'] = WebsiteSetting::get('ai_provider', config('services.llm.provider', 'openrouter'));
        $data['ai_model']    = WebsiteSetting::get('ai_model', config('services.llm.model', 'openai/gpt-3.5-turbo'));
        $data['ai_api_key']  = WebsiteSetting::get('ai_api_key', config('services.llm.api_key', ''));
        $data['ai_base_url'] = WebsiteSetting::get('ai_base_url', config('services.llm.base_url', 'https://openrouter.ai/api/v1'));
        $data['ai_timeout']  = WebsiteSetting::get('ai_timeout', config('services.llm.timeout', 30));

        return view('backend.ai_setting.index', $data);
    }

    /**
     * Simpan pembaruan konfigurasi AI.
     */
    public function update(Request $request)
    {
        $request->validate([
            'ai_provider' => 'required|string|in:openrouter,openai,gemini,custom',
            'ai_model'    => 'required|string|max:255',
            'ai_api_key'  => 'nullable|string|max:500',
            'ai_base_url' => 'required|url|max:255',
            'ai_timeout'  => 'required|integer|min:5|max:120',
        ]);

        WebsiteSetting::set('ai_provider', $request->ai_provider);
        WebsiteSetting::set('ai_model', $request->ai_model);
        WebsiteSetting::set('ai_base_url', $request->ai_base_url);
        WebsiteSetting::set('ai_timeout', $request->ai_timeout);

        if ($request->filled('ai_api_key')) {
            WebsiteSetting::set('ai_api_key', $request->ai_api_key);
        }

        return redirect()->route('ai-setting.index')->with('success', 'Konfigurasi Provider & Model AI berhasil diperbarui!');
    }
}
