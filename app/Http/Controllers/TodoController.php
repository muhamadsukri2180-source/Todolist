<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of todos with counters and optional filtering.
     */
    public function index(Request $request)
    {
        $userId = auth()->id();
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');
        $sort = $request->query('sort', 'latest');

        $query = Todo::where('user_id', $userId);

        if ($filter === 'active') {
            $query->where('is_completed', false);
        } elseif ($filter === 'completed') {
            $query->where('is_completed', true);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($sort === 'deadline_asc') {
            $query->orderByRaw('due_date IS NULL, due_date ASC')->latest();
        } elseif ($sort === 'deadline_desc') {
            $query->orderByRaw('due_date IS NULL, due_date DESC')->latest();
        } else {
            $query->latest();
        }

        $todos = $query->paginate(10)->withQueryString();

        $totalCount = Todo::where('user_id', $userId)->count();
        $activeCount = Todo::where('user_id', $userId)->where('is_completed', false)->count();
        $completedCount = Todo::where('user_id', $userId)->where('is_completed', true)->count();
        $progressPercentage = $totalCount > 0 ? (int) round(($completedCount / $totalCount) * 100) : 0;

        return view('todos.index', compact(
            'todos',
            'filter',
            'search',
            'sort',
            'totalCount',
            'activeCount',
            'completedCount',
            'progressPercentage'
        ));
    }

    /**
     * Store a newly created todo in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        Todo::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 'medium',
            'due_date' => $validated['due_date'] ?? null,
            'is_completed' => false,
        ]);

        return redirect()->route('todos.index')->with('success', 'Tugas berhasil ditambahkan.');
    }

    /**
     * Update the specified todo in database (title, description, priority, due_date, or toggle completed status).
     */
    public function update(Request $request, Todo $todo)
    {
        if ($todo->user_id && $todo->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk mengubah tugas ini.');
        }

        if ($request->has('toggle_status')) {
            $todo->update([
                'is_completed' => !$todo->is_completed,
            ]);
            $statusText = $todo->is_completed ? 'selesai' : 'belum selesai';
            return redirect()->route('todos.index')->with('success', "Status tugas \"{$todo->title}\" diubah menjadi {$statusText}.");
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|string|in:low,medium,high',
            'due_date' => 'nullable|date',
            'is_completed' => 'nullable|boolean',
        ]);

        $todo->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? $todo->priority,
            'due_date' => array_key_exists('due_date', $validated) ? $validated['due_date'] : $todo->due_date,
            'is_completed' => $request->has('is_completed') ? (bool) $request->is_completed : $todo->is_completed,
        ]);

        return redirect()->route('todos.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Remove the specified todo from database.
     */
    public function destroy(Todo $todo)
    {
        if ($todo->user_id && $todo->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus tugas ini.');
        }

        $title = $todo->title;
        $todo->delete();

        return redirect()->route('todos.index')->with('success', "Tugas \"{$title}\" berhasil dihapus.");
    }
}
