<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    /**
     * Daftar artikel knowledge base.
     */
    public function index(Request $request)
    {
        $query = KnowledgeBase::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $data['title']      = 'Knowledge Base';
        $data['articles']   = $query->latest()->get();
        $data['categories'] = Category::all();

        return view('backend.knowledge_base.index', $data);
    }

    /**
     * Tampilkan form tambah artikel baru.
     */
    public function create()
    {
        $data['title']      = 'Tambah Artikel FAQ';
        $data['categories'] = Category::all();

        return view('backend.knowledge_base.create', $data);
    }

    /**
     * Simpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question'    => ['required', 'string', 'max:255'],
            'answer'      => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'question.required' => 'Pertanyaan FAQ wajib diisi.',
            'answer.required'   => 'Jawaban FAQ wajib diisi.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        KnowledgeBase::create($validated);

        return redirect()->route('knowledge-base.index')
            ->with('success', 'Artikel FAQ berhasil ditambahkan ke knowledge base.');
    }

    /**
     * Tampilkan form edit artikel.
     */
    public function edit(string $id)
    {
        $data['title']      = 'Edit Artikel FAQ';
        $data['article']    = KnowledgeBase::findOrFail($id);
        $data['categories'] = Category::all();

        return view('backend.knowledge_base.edit', $data);
    }

    /**
     * Update artikel yang sudah ada.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'question'    => ['required', 'string', 'max:255'],
            'answer'      => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active'   => ['nullable', 'boolean'],
        ], [
            'question.required' => 'Pertanyaan FAQ wajib diisi.',
            'answer.required'   => 'Jawaban FAQ wajib diisi.',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $article = KnowledgeBase::findOrFail($id);
        $article->update($validated);

        return redirect()->route('knowledge-base.index')
            ->with('success', 'Artikel FAQ berhasil diperbarui.');
    }

    /**
     * Hapus artikel dari knowledge base.
     */
    public function destroy(string $id)
    {
        $article = KnowledgeBase::findOrFail($id);
        $article->delete();

        return redirect()->route('knowledge-base.index')
            ->with('success', 'Artikel FAQ berhasil dihapus dari knowledge base.');
    }
}
