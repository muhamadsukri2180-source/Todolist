<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrator — Daftar Pengguna Terdaftar</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen pb-16">

    <!-- Header / Navbar Admin -->
    <header class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-4 py-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl text-amber-400">
                        <i class="fa-solid fa-shield-halved text-2xl"></i>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h1 class="text-xl font-bold tracking-tight">Panel Administrator</h1>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-900 uppercase">Khusus Baca</span>
                        </div>
                        <p class="text-slate-300 text-xs">Melihat daftar seluruh pengguna yang telah terdaftar di TaskFlow</p>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <a href="{{ route('todos.index') }}" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold backdrop-blur-sm transition">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Ke Halaman Tugas</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center space-x-1.5 px-3.5 py-2 rounded-xl bg-rose-500/20 hover:bg-rose-500/30 text-rose-200 text-xs font-semibold transition">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 -mt-4">

        <!-- Informasi Batasan Hak Akses (Read-Only) -->
        <div class="mb-6 bg-amber-50 border-l-4 border-amber-500 text-amber-900 p-4 rounded-r-2xl shadow-sm flex items-start space-x-3">
            <i class="fa-solid fa-circle-info text-amber-500 text-lg mt-0.5"></i>
            <div class="text-xs space-y-0.5">
                <p class="font-bold">Mode Hanya Baca (Read-Only Aktif):</p>
                <p class="text-amber-800">Halaman ini dirancang khusus untuk memantau data akun pengguna yang terdaftar. Administrator hanya memiliki hak akses membaca (read) tanpa opsi manipulasi, pengubahan, atau penghapusan data pengguna.</p>
            </div>
        </div>

        <!-- Kartu Ringkasan Statistik Pengguna -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                    <p class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalUsers }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Administrator</p>
                    <p class="text-2xl font-extrabold text-purple-600 mt-1">{{ $totalAdmins }}</p>
                </div>
                <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengguna Biasa</p>
                    <p class="text-2xl font-extrabold text-emerald-600 mt-1">{{ $totalRegularUsers }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200 flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Tugas Sistem</p>
                    <p class="text-2xl font-extrabold text-amber-600 mt-1">{{ $totalSystemTodos }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-list-check"></i>
                </div>
            </div>
        </div>

        <!-- Wadah Tabel Data Pengguna -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header Tabel & Pencarian -->
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/70 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="font-bold text-slate-800 text-base">Daftar Pengguna Terdaftar</h2>
                    <p class="text-slate-500 text-xs mt-0.5">Seluruh akun yang tersimpan di dalam basis data sistem</p>
                </div>

                <!-- Formulir Pencarian Pengguna -->
                <form action="{{ route('admin.users') }}" method="GET" class="flex items-center max-w-xs w-full">
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama, username, email..."
                               class="w-full pl-9 pr-8 py-1.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs transition outline-none">
                        @if(!empty($search))
                            <a href="{{ route('admin.users') }}" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600" title="Bersihkan">
                                <i class="fa-solid fa-circle-xmark text-xs"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Pengguna -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-700">
                    <thead class="bg-slate-100/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th scope="col" class="py-3.5 px-6">Pengguna</th>
                            <th scope="col" class="py-3.5 px-6">Username</th>
                            <th scope="col" class="py-3.5 px-6">Alamat Email</th>
                            <th scope="col" class="py-3.5 px-6 text-center">Peran</th>
                            <th scope="col" class="py-3.5 px-6 text-center">Total Tugas</th>
                            <th scope="col" class="py-3.5 px-6">Tanggal Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50/80 transition">
                                <!-- Kolom Nama & Avatar -->
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-600 text-white font-bold flex items-center justify-center text-xs shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 text-sm">{{ $user->name }}</p>
                                            @if($user->id === auth()->id())
                                                <span class="text-[10px] text-indigo-600 font-semibold">(Akun Anda)</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Kolom Username -->
                                <td class="py-4 px-6 font-mono font-semibold text-slate-600">
                                    {{ '@' . ($user->username ?? '-') }}
                                </td>

                                <!-- Kolom Email -->
                                <td class="py-4 px-6 text-slate-600">
                                    {{ $user->email }}
                                </td>

                                <!-- Kolom Peran -->
                                <td class="py-4 px-6 text-center">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-purple-100 text-purple-800 border border-purple-200">
                                            <i class="fa-solid fa-shield-halved text-[9px] mr-1"></i> Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                            <i class="fa-solid fa-user text-[9px] mr-1"></i> Pengguna
                                        </span>
                                    @endif
                                </td>

                                <!-- Kolom Total Tugas -->
                                <td class="py-4 px-6 text-center">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-50 font-bold text-indigo-700 border border-indigo-100">
                                        {{ $user->todos_count }}
                                    </span>
                                </td>

                                <!-- Kolom Tanggal Terdaftar -->
                                <td class="py-4 px-6 text-slate-500">
                                    <p class="font-medium text-slate-700">{{ $user->created_at->translatedFormat('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $user->created_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-500">
                                    <i class="fa-solid fa-user-slash text-3xl text-slate-300 mb-2"></i>
                                    <p class="font-bold text-slate-700">Tidak ada data pengguna yang ditemukan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Wadah Paginasi -->
            @if($users->hasPages())
                <div class="px-6 py-4 border-t border-slate-200/80 bg-white">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </main>

</body>
</html>
