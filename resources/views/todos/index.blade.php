<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow — Produktivitas Pribadi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen pb-16">

    <!-- Bilah Atas / Header -->
    <header class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-800 text-white shadow-lg">
        <div class="max-w-4xl mx-auto px-4 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('landing') }}" class="p-3 bg-white/10 backdrop-blur-md rounded-xl hover:bg-white/20 transition-all flex items-center justify-center">
                        <i class="fa-solid fa-bolt-lightning text-3xl text-amber-300"></i>
                    </a>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h1 class="text-2xl font-bold tracking-tight">TaskFlow</h1>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-indigo-100">
                                {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}
                            </span>
                        </div>
                        <p class="text-indigo-200 text-xs sm:text-sm">Produktivitas & Manajemen Tugas Pribadi</p>
                    </div>
                </div>

                <div class="flex items-center flex-wrap gap-2 sm:gap-3">
                    <a href="{{ route('landing') }}" class="px-3 py-1.5 text-xs font-medium rounded-lg bg-white/10 hover:bg-white/20 text-white transition-all flex items-center gap-1.5">
                        <i class="fa-solid fa-house"></i>
                        <span>Beranda</span>
                    </a>

                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users') }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-400 hover:bg-amber-300 text-slate-900 transition-all shadow-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>Panel Admin</span>
                        </a>
                    @endif

                    <div class="flex items-center gap-2 pl-2 border-l border-white/20">
                        <span class="text-xs text-indigo-100 hidden md:inline font-medium">
                            <i class="fa-solid fa-user text-indigo-300 mr-1"></i> {{ Auth::user()->name }}
                        </span>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-rose-500/80 hover:bg-rose-600 text-white transition-all flex items-center gap-1.5">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 -mt-6">

        <!-- Notifikasi Berhasil -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-r-xl shadow-md flex items-center justify-between transition-all" id="toast-success">
                <div class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl"></i>
                    <p class="font-medium text-sm">{{ session('success') }}</p>
                </div>
                <button onclick="document.getElementById('toast-success').remove()" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <!-- Kesalahan Validasi Formulir -->
        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-r-xl shadow-md">
                <div class="flex items-center space-x-3 mb-1">
                    <i class="fa-solid fa-circle-info text-rose-500 text-xl"></i>
                    <p class="font-bold text-sm">Terjadi Kesalahan Pengisian Formulir:</p>
                </div>
                <ul class="list-disc list-inside text-sm pl-5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Kartu Kemajuan Penyelesaian Tugas -->
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-200/80 mb-6">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-chart-line text-indigo-600 text-lg"></i>
                    <h3 class="font-bold text-slate-800 text-sm sm:text-base">Kemajuan Penyelesaian Tugas</h3>
                </div>
                <span class="text-sm font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100">
                    {{ $progressPercentage }}% Selesai
                </span>
            </div>

            <!-- Bilah Kemajuan Luar -->
            <div class="w-full bg-slate-100 rounded-full h-3.5 p-0.5 overflow-hidden border border-slate-200">
                <div class="bg-gradient-to-r from-indigo-500 via-indigo-600 to-emerald-500 h-full rounded-full transition-all duration-500 ease-out shadow-sm"
                    style="width: {{ $progressPercentage }}%"></div>
            </div>

            <div class="flex justify-between items-center text-xs text-slate-500 mt-2">
                <span>{{ $completedCount }} dari {{ $totalCount }} tugas telah diselesaikan</span>
                @if($progressPercentage === 100 && $totalCount > 0)
                    <span class="text-emerald-600 font-semibold flex items-center gap-1">
                        <i class="fa-solid fa-trophy text-amber-500"></i> Semua Tugas Selesai
                    </span>
                @endif
            </div>
        </div>

        <!-- Kartu Ringkasan Statistik -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Tugas</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalCount }}</p>
                </div>
                <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-cubes"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Belum Selesai</p>
                    <p class="text-2xl font-bold text-amber-600 mt-1">{{ $activeCount }}</p>
                </div>
                <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-regular fa-clock"></i>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200/80 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $completedCount }}</p>
                </div>
                <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>

        <!-- Formulir Tambah Tugas Baru -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-plus-circle text-indigo-600"></i>
                <span>Tambah Tugas Baru</span>
            </h2>

            <form action="{{ route('todos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Judul Tugas <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="title" required placeholder="Contoh: Menyelesaikan laporan mingguan"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none">
                    </div>

                    <div>
                        <label for="due_date" class="block text-sm font-semibold text-slate-700 mb-1">Tenggat Waktu <span class="text-slate-400 font-normal">(Opsional)</span></label>
                        <input type="date" name="due_date" id="due_date"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none bg-white">
                    </div>
                </div>

                <!-- Pilihan Bundaran Tingkat Prioritas -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tingkat Prioritas</label>
                    <div class="grid grid-cols-3 gap-3">
                        <!-- Rendah -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-sky-300 hover:bg-sky-50/50 transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50 has-[:checked]:ring-2 has-[:checked]:ring-sky-400">
                            <input type="radio" name="priority" value="low" class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-sky-500 ring-2 ring-sky-200"></span>
                                <span class="text-xs font-bold text-slate-700">Rendah</span>
                            </div>
                        </label>

                        <!-- Sedang (Bawaan) -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-amber-300 hover:bg-amber-50/50 transition-all has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 has-[:checked]:ring-2 has-[:checked]:ring-amber-400">
                            <input type="radio" name="priority" value="medium" checked class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-amber-500 ring-2 ring-amber-200"></span>
                                <span class="text-xs font-bold text-slate-700">Sedang</span>
                            </div>
                        </label>

                        <!-- Tinggi -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-rose-300 hover:bg-rose-50/50 transition-all has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 has-[:checked]:ring-2 has-[:checked]:ring-rose-400">
                            <input type="radio" name="priority" value="high" class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-rose-500 ring-2 ring-rose-200"></span>
                                <span class="text-xs font-bold text-slate-700">Tinggi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="description" id="description" rows="2" placeholder="Tambahkan rincian atau catatan tugas..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-200 text-sm">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Simpan Tugas</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Wadah Pencarian, Filter & Daftar Tugas -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <!-- Header Pencarian & Filter -->
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <!-- Formulir Pencarian -->
                <form action="{{ route('todos.index') }}" method="GET" class="flex items-center flex-1 max-w-md">
                    @if($filter !== 'all')
                        <input type="hidden" name="filter" value="{{ $filter }}">
                    @endif
                    @if($sort !== 'latest')
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    @endif
                    <div class="relative w-full">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </span>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari tugas berdasarkan judul atau deskripsi..."
                            class="w-full pl-10 pr-10 py-2 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-xs sm:text-sm transition outline-none">
                        @if(!empty($search))
                            <a href="{{ route('todos.index', ['filter' => $filter, 'sort' => $sort]) }}"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600"
                            title="Bersihkan Pencarian">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Tab Filter Status -->
                <div class="flex items-center space-x-1 bg-slate-200/70 p-1 rounded-xl text-xs font-semibold self-start md:self-auto">
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['filter' => 'all'])) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $filter === 'all' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua ({{ $totalCount }})
                    </a>
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['filter' => 'active'])) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $filter === 'active' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Belum Selesai ({{ $activeCount }})
                    </a>
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['filter' => 'completed'])) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $filter === 'completed' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Selesai ({{ $completedCount }})
                    </a>
                </div>
            </div>

            <!-- Subheader Pengurutan Tenggat Waktu -->
            <div class="px-6 py-2.5 bg-slate-100/60 border-b border-slate-100 flex flex-wrap items-center justify-between gap-2 text-xs">
                <div class="flex items-center space-x-2 text-slate-600 font-medium">
                    <i class="fa-solid fa-arrow-down-short-wide text-indigo-600"></i>
                    <span>Urutkan Tenggat Waktu:</span>
                </div>
                <div class="flex items-center space-x-2 font-semibold">
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['sort' => 'latest'])) }}"
                       class="px-2.5 py-1 rounded-lg border transition flex items-center space-x-1.5 {{ $sort === 'latest' ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300' }}">
                        <i class="fa-solid fa-clock text-xs"></i>
                        <span>Terbaru</span>
                    </a>
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['sort' => 'deadline_asc'])) }}"
                       class="px-2.5 py-1 rounded-lg border transition flex items-center space-x-1.5 {{ $sort === 'deadline_asc' ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300' }}">
                        <i class="fa-solid fa-hourglass-half text-xs"></i>
                        <span>Waktu Terdekat</span>
                    </a>
                    <a href="{{ route('todos.index', array_merge(request()->query(), ['sort' => 'deadline_desc'])) }}"
                       class="px-2.5 py-1 rounded-lg border transition flex items-center space-x-1.5 {{ $sort === 'deadline_desc' ? 'bg-indigo-600 text-white border-indigo-600 shadow-sm' : 'bg-white text-slate-600 border-slate-200 hover:border-indigo-300' }}">
                        <i class="fa-solid fa-calendar-days text-xs"></i>
                        <span>Waktu Terjauh</span>
                    </a>
                </div>
            </div>

            <!-- Banner Indikator Pencarian -->
            @if(!empty($search))
                <div class="bg-indigo-50/70 border-b border-indigo-100 px-6 py-2.5 flex items-center justify-between text-xs text-indigo-800">
                    <span>Hasil pencarian untuk: <strong>"{{ $search }}"</strong> ({{ $todos->total() }} ditemukan)</span>
                    <a href="{{ route('todos.index', ['filter' => $filter, 'sort' => $sort]) }}" class="font-semibold underline hover:text-indigo-950">Hapus filter pencarian</a>
                </div>
            @endif

            <!-- Daftar Item Tugas -->
            <div class="divide-y divide-slate-100">
                @forelse($todos as $todo)
                    <div class="p-5 hover:bg-slate-50/80 transition flex items-start justify-between gap-4 group {{ $todo->is_completed ? 'bg-slate-50/50' : '' }}">
                        <!-- Kotak Centang & Judul/Deskripsi -->
                        <div class="flex items-start space-x-3.5 flex-1 min-w-0">
                            <!-- Formulir Ubah Status Selesai -->
                            <form action="{{ route('todos.update', $todo->id) }}" method="POST" class="mt-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="toggle_status" value="1">
                                <button type="submit"
                                        title="{{ $todo->is_completed ? 'Tandai Belum Selesai' : 'Tandai Selesai' }}"
                                        class="w-6 h-6 rounded-lg border-2 flex items-center justify-center transition-all duration-200 focus:outline-none {{ $todo->is_completed ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-slate-300 hover:border-indigo-500 text-transparent' }}">
                                    <i class="fa-solid fa-check text-xs"></i>
                                </button>
                            </form>

                            <div class="flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h4 class="text-base font-semibold text-slate-800 {{ $todo->is_completed ? 'line-through text-slate-400' : '' }}">
                                        {{ $todo->title }}
                                    </h4>

                                    <!-- Lencana Tingkat Prioritas -->
                                    @if($todo->priority === 'high')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200">
                                            <span class="w-2 h-2 rounded-full bg-rose-500 mr-1.5"></span> Tinggi
                                        </span>
                                    @elseif($todo->priority === 'medium')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                            <span class="w-2 h-2 rounded-full bg-amber-500 mr-1.5"></span> Sedang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200">
                                            <span class="w-2 h-2 rounded-full bg-sky-500 mr-1.5"></span> Rendah
                                        </span>
                                    @endif

                                    <!-- Lencana Status -->
                                    @if($todo->is_completed)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-check text-[10px] mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 border border-slate-200">
                                            <i class="fa-regular fa-clock text-[10px] mr-1"></i> Menunggu
                                        </span>
                                    @endif

                                    <!-- Lencana Tenggat Waktu -->
                                    @if($todo->due_date)
                                        @php
                                            $isOverdue = !$todo->is_completed && $todo->due_date->isPast() && !$todo->due_date->isToday();
                                            $isToday = $todo->due_date->isToday();
                                        @endphp
                                        @if($isOverdue)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 shadow-sm">
                                                <i class="fa-solid fa-clock text-[10px] mr-1 text-rose-600"></i> Terlewat: {{ $todo->due_date->translatedFormat('d M Y') }}
                                            </span>
                                        @elseif($isToday)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                                <i class="fa-solid fa-hourglass-half text-[10px] mr-1 text-amber-600"></i> Tenggat Hari Ini
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-200">
                                                <i class="fa-regular fa-calendar-check text-[10px] mr-1"></i> Tenggat: {{ $todo->due_date->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    @endif
                                </div>

                                @if($todo->description)
                                    <p class="text-sm mt-1 {{ $todo->is_completed ? 'text-slate-400 line-through' : 'text-slate-600' }}">
                                        {{ $todo->description }}
                                    </p>
                                @endif

                                <p class="text-xs text-slate-400 mt-2 flex items-center space-x-1">
                                    <i class="fa-regular fa-calendar text-[10px]"></i>
                                    <span>Dibuat: {{ $todo->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Aksi (Tandai Selesai, Ubah, & Hapus) -->
                        <div class="flex items-center space-x-2 shrink-0">
                            <!-- Tombol Ubah Status Cepat -->
                            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="toggle_status" value="1">
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition flex items-center space-x-1 {{ $todo->is_completed ? 'border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-300 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                    <i class="{{ $todo->is_completed ? 'fa-solid fa-rotate-left' : 'fa-solid fa-check-double' }}"></i>
                                    <span>{{ $todo->is_completed ? 'Batal Selesai' : 'Tandai Selesai' }}</span>
                                </button>
                            </form>

                            <!-- Tombol Pemicu Modal Ubah -->
                            <button onclick="toggleEditModal({{ $todo->id }}, '{{ addslashes($todo->title) }}', '{{ addslashes($todo->description) }}', '{{ $todo->priority ?? 'medium' }}', '{{ $todo->due_date ? $todo->due_date->format('Y-m-d') : '' }}', {{ $todo->is_completed ? 'true' : 'false' }})"
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                    title="Ubah Tugas">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- Formulir Hapus -->
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                        title="Hapus Tugas">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3 text-2xl">
                            <i class="fa-solid fa-clipboard-list"></i>
                        </div>
                        <h4 class="font-bold text-slate-700 text-base">Belum Ada Tugas</h4>
                        <p class="text-slate-500 text-sm mt-1">
                            @if(!empty($search))
                                Tidak ada tugas yang cocok dengan kata kunci "{{ $search }}".
                            @else
                                Tambahkan tugas baru menggunakan formulir di atas.
                            @endif
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Wadah Navigasi Paginasi -->
            @if($todos->hasPages())
                <div class="px-6 py-4 border-t border-slate-200/80 bg-white">
                    {{ $todos->links() }}
                </div>
            @endif
        </div>

    </main>

    <!-- Modal Dialog Ubah Tugas -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6 relative animate-in fade-in zoom-in duration-150">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
                <span>Ubah Tugas</span>
            </h3>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="edit_title" class="block text-sm font-semibold text-slate-700 mb-1">Judul Tugas <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none">
                </div>

                <div>
                    <label for="edit_due_date" class="block text-sm font-semibold text-slate-700 mb-1">Tenggat Waktu</label>
                    <input type="date" name="due_date" id="edit_due_date"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none bg-white">
                </div>

                <!-- Pilihan Bundaran Tingkat Prioritas pada Modal Ubah -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tingkat Prioritas</label>
                    <div class="grid grid-cols-3 gap-3">
                        <!-- Rendah -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-sky-300 hover:bg-sky-50/50 transition-all has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50 has-[:checked]:ring-2 has-[:checked]:ring-sky-400">
                            <input type="radio" name="priority" id="edit_priority_low" value="low" class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-sky-500 ring-2 ring-sky-200"></span>
                                <span class="text-xs font-bold text-slate-700">Rendah</span>
                            </div>
                        </label>

                        <!-- Sedang -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-amber-300 hover:bg-amber-50/50 transition-all has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50 has-[:checked]:ring-2 has-[:checked]:ring-amber-400">
                            <input type="radio" name="priority" id="edit_priority_medium" value="medium" class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-amber-500 ring-2 ring-amber-200"></span>
                                <span class="text-xs font-bold text-slate-700">Sedang</span>
                            </div>
                        </label>

                        <!-- Tinggi -->
                        <label class="relative flex items-center justify-center p-3 rounded-xl border border-slate-200 cursor-pointer hover:border-rose-300 hover:bg-rose-50/50 transition-all has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50 has-[:checked]:ring-2 has-[:checked]:ring-rose-400">
                            <input type="radio" name="priority" id="edit_priority_high" value="high" class="sr-only">
                            <div class="flex items-center space-x-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-rose-500 ring-2 ring-rose-200"></span>
                                <span class="text-xs font-bold text-slate-700">Tinggi</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3" placeholder="Tambahkan rincian atau catatan tugas..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none"></textarea>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="is_completed" id="edit_is_completed" value="1" class="w-4 h-4 text-indigo-600 rounded border-slate-300 focus:ring-indigo-500">
                    <label for="edit_is_completed" class="text-sm font-medium text-slate-700">Tandai telah selesai</label>
                </div>

                <div class="flex justify-end space-x-3 pt-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm shadow-md transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEditModal(id, title, description, priority, dueDate, isCompleted) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const titleInput = document.getElementById('edit_title');
            const dueDateInput = document.getElementById('edit_due_date');
            const descInput = document.getElementById('edit_description');
            const completedCheckbox = document.getElementById('edit_is_completed');

            form.action = `/todos/${id}`;
            titleInput.value = title;
            dueDateInput.value = dueDate || '';
            descInput.value = description || '';
            completedCheckbox.checked = isCompleted;

            // Pilih tombol bundaran prioritas yang sesuai
            const selectedRadio = document.querySelector(`#editForm input[name="priority"][value="${priority || 'medium'}"]`);
            if (selectedRadio) {
                selectedRadio.checked = true;
            }

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>
