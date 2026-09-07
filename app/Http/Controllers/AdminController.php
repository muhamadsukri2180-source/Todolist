<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar pengguna terdaftar (Khusus Read-Only).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::withCount('todos')->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('username', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $users = $query->paginate(10)->withQueryString();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalRegularUsers = User::where('role', 'user')->count();
        $totalSystemTodos = Todo::count();

        return view('admin.users', compact(
            'users',
            'search',
            'totalUsers',
            'totalAdmins',
            'totalRegularUsers',
            'totalSystemTodos'
        ));
    }
}
