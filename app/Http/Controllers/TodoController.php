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
        $filter = $request->query('filter', 'all');
        $search = $request->query('search');

        $query = Todo::query();

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

        $todos = $query->latest()->get();

        $totalCount = Todo::count();
        $activeCount = Todo::where('is_completed', false)->count();
        $completedCount = Todo::where('is_completed', true)->count();
        $progressPercentage = $totalCount > 0 ? (int) round(($completedCount / $totalCount) * 100) : 0;

        return view('todos.index', compact(
            'todos',
            'filter',
            'search',
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
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'] ?? 'medium',
            'due_date' => $validated['due_date'] ?? null,
            'is_completed' => false,
        ]);

        return redirect()->back()->with('success', 'Todo berhasil ditambahkan.');
    }

    /**
     * Update the specified todo in database (title, description, priority, due_date, or toggle completed status).
     */
    public function update(Request $request, Todo $todo)
    {
        if ($request->has('toggle_status')) {
            $todo->update([
                'is_completed' => !$todo->is_completed,
            ]);
            $statusText = $todo->is_completed ? 'selesai' : 'belum selesai';
            return redirect()->back()->with('success', "Status todo \"{$todo->title}\" diubah menjadi {$statusText}.");
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

        return redirect()->back()->with('success', 'Todo berhasil diperbarui.');
    }

    /**
     * Remove the specified todo from database.
     */
    public function destroy(Todo $todo)
    {
        $title = $todo->title;
        $todo->delete();

        return redirect()->back()->with('success', "Todo \"{$title}\" berhasil dihapus.");
    }
}
