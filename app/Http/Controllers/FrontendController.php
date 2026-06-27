<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\KnowledgeBase;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * Tampilkan portal publik pencarian FAQ tanpa perlu login.
     */
    public function index(Request $request)
    {
        $query = KnowledgeBase::active()->with('category');

        // Pencarian keyword
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('question', 'like', "%{$search}%")
                  ->orWhere('answer', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $data['title']      = 'Pusat Bantuan & FAQ IT';
        $data['articles']   = $query->latest()->paginate(9)->withQueryString();
        $data['categories'] = Category::all();

        return view('frontend.index', $data);
    }
}
