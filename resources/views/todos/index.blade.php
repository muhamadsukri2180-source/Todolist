<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODO List - Mini Application</title>
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

    <!-- Header / Navbar -->
    <header class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-800 text-white shadow-lg">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="p-3 bg-white/10 backdrop-blur-md rounded-xl">
                        <i class="fa-solid fa-list-check text-3xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">TODO List App</h1>
                        <p class="text-indigo-200 text-sm">Kelola tugas harian Anda dengan mudah & efisien</p>
                    </div>
                </div>
                <div class="hidden sm:block text-right">
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 -mt-6">

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

        @if ($errors->any())
            <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-4 rounded-r-xl shadow-md">
                <div class="flex items-center space-x-3 mb-1">
                    <i class="fa-solid fa-triangle-exclamation text-rose-500 text-xl"></i>
                    <p class="font-bold text-sm">Terjadi Kesalahan Form:</p>
                </div>
                <ul class="list-disc list-inside text-sm pl-5 text-rose-700">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-plus-circle text-indigo-600"></i>
                <span>Tambah Todo Baru</span>
            </h2>

            <form action="{{ route('todos.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="title" class="block text-sm font-semibold text-slate-700 mb-1">Judul Todo <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="title" required placeholder="Contoh: Menyelesaikan laporan mingguan"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none">
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi <span class="text-slate-400 font-normal">(Opsional)</span></label>
                    <textarea name="description" id="description" rows="2" placeholder="Tambahkan rincian atau catatan..."
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none"></textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl shadow-md hover:shadow-lg transition duration-200 text-sm">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Simpan Todo</span>
                    </button>
                </div>
            </form>
        </div>


        <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <h3 class="font-bold text-slate-800 text-base">Daftar Tugas</h3>

                <div class="flex items-center space-x-1 bg-slate-200/70 p-1 rounded-xl text-xs font-semibold">
                    <a href="{{ route('todos.index', ['filter' => 'all']) }}"
                    class="px-3 py-1.5 rounded-lg transition {{ $filter === 'all' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Semua ({{ $totalCount }})
                    </a>
                    <a href="{{ route('todos.index', ['filter' => 'active']) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $filter === 'active' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Belum Selesai ({{ $activeCount }})
                    </a>
                    <a href="{{ route('todos.index', ['filter' => 'completed']) }}"
                       class="px-3 py-1.5 rounded-lg transition {{ $filter === 'completed' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                        Selesai ({{ $completedCount }})
                    </a>
                </div>
            </div>

            <!-- List Items -->
            <div class="divide-y divide-slate-100">
                @forelse($todos as $todo)
                    <div class="p-5 hover:bg-slate-50/80 transition flex items-start justify-between gap-4 group {{ $todo->is_completed ? 'bg-slate-50/50' : '' }}">
                        <!-- Checkbox Toggle & Title/Description -->
                        <div class="flex items-start space-x-3.5 flex-1 min-w-0">
                            <!-- Toggle Completed Form -->
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
                                <div class="flex items-center space-x-2">
                                    <h4 class="text-base font-semibold text-slate-800 {{ $todo->is_completed ? 'line-through text-slate-400' : '' }}">
                                        {{ $todo->title }}
                                    </h4>

                                    @if($todo->is_completed)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                            <i class="fa-solid fa-check text-[10px] mr-1"></i> Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                            <i class="fa-regular fa-clock text-[10px] mr-1"></i> Pending
                                        </span>
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

                        <!-- Action Buttons (Update & Delete) -->
                        <div class="flex items-center space-x-2 shrink-0">
                            <!-- Toggle Button (Express Action) -->
                            <form action="{{ route('todos.update', $todo->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="toggle_status" value="1">
                                <button type="submit"
                                        class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition flex items-center space-x-1 {{ $todo->is_completed ? 'border-amber-300 bg-amber-50 text-amber-700 hover:bg-amber-100' : 'border-emerald-300 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                                    <i class="{{ $todo->is_completed ? 'fa-solid fa-rotate-left' : 'fa-solid fa-check-double' }}"></i>
                                    <span>{{ $todo->is_completed ? 'Batal Selesai' : 'Update Selesai' }}</span>
                                </button>
                            </form>

                            <!-- Edit Trigger Button -->
                            <button onclick="toggleEditModal({{ $todo->id }}, '{{ addslashes($todo->title) }}', '{{ addslashes($todo->description) }}', {{ $todo->is_completed ? 'true' : 'false' }})"
                                    class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition"
                                    title="Edit Todo">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus todo ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                        title="Hapus Todo">
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
                        <h4 class="font-bold text-slate-700 text-base">Belum Ada Todo</h4>
                        <p class="text-slate-500 text-sm mt-1">Tambahkan tugas baru menggunakan form di atas.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </main>

    <!-- Modal Edit Todo -->
    <div id="editModal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-md p-6 relative animate-in fade-in zoom-in duration-150">
            <button onclick="closeEditModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>

            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center space-x-2">
                <i class="fa-solid fa-pen-to-square text-indigo-600"></i>
                <span>Edit Todo</span>
            </h3>

            <form id="editForm" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="edit_title" class="block text-sm font-semibold text-slate-700 mb-1">Judul Todo <span class="text-rose-500">*</span></label>
                    <input type="text" name="title" id="edit_title" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition outline-none">
                </div>

                <div>
                    <label for="edit_description" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi</label>
                    <textarea name="description" id="edit_description" rows="3"
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
        function toggleEditModal(id, title, description, isCompleted) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');
            const titleInput = document.getElementById('edit_title');
            const descInput = document.getElementById('edit_description');
            const completedCheckbox = document.getElementById('edit_is_completed');

            form.action = `/todos/${id}`;
            titleInput.value = title;
            descInput.value = description || '';
            completedCheckbox.checked = isCompleted;

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>
