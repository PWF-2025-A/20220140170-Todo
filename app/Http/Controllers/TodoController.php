<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class TodoController extends Controller
{
    public function index()
    {
        // Menampilkan todo berdasarkan user yang sedang login
        $todos = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        // Menghitung jumlah todo yang telah selesai
        $todosCompleted = Todo::where('user_id', Auth::id())->where('is_complete', true)->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id', // Validasi kategori
        ]);

        // Menyimpan data Todo baru
        Todo::create([
            'title' => ucfirst($request->title),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id, // Menyimpan kategori
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    public function create()
    {
        // Menampilkan halaman untuk membuat Todo, dan membawa data kategori
        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }

    public function edit(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            return view('todo.edit', compact('todo'));
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    public function update(Request $request, Todo $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function complete(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update(['is_complete' => true]);
            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
    }

    public function uncomplete(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update(['is_complete' => false]);
            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
    }

    public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    public function destroyCompleted()
    {
        // Menghapus semua todo yang sudah selesai milik user
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}
