<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('todos')
            ->where('user_id', auth()->id()) // Hanya kategori milik pengguna yang login
            ->get();
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create'); // Hapus where user_id jika ingin semua kategori
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Menyimpan kategori dengan user_id yang terasosiasi
        Category::create([
            'title' => $validated['title'],
            'user_id' => auth()->id(), // Menyimpan kategori untuk pengguna yang sedang login
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Update kategori
        $category->update([
            'title' => $validated['title'],
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Menghapus kategori hanya jika tidak ada todo terkait
        if ($category->todos->count() == 0) {
            $category->delete();
            return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus.');
        } else {
            return redirect()->route('category.index')->with('danger', 'Kategori tidak dapat dihapus karena ada tugas yang terkait.');
        }
    }
}
