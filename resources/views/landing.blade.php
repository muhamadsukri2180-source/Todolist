<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TaskFlow — Solusi Produktivitas & Manajemen Tugas Pribadi</title>
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
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Navigasi Utama -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-slate-200/80">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-purple-600 flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-bolt-lightning text-xl text-amber-300"></i>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-700 to-purple-700 bg-clip-text text-transparent">TaskFlow</span>
                    <span class="block text-[10px] font-semibold text-slate-400 uppercase tracking-widest -mt-1">Produktivitas</span>
                </div>
            </a>

            <div class="flex items-center space-x-3">
                @auth
                    <a href="{{ route('todos.index') }}" class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl text-sm shadow transition">
                        <i class="fa-solid fa-list-check"></i>
                        <span>Buka Dasbor Tugas</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-700 hover:text-indigo-600 font-semibold px-3 py-2 text-sm transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center space-x-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded-xl text-sm shadow-md hover:shadow-lg transition">
                        <span>Daftar Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Bagian Hero -->
    <header class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-28 bg-gradient-to-b from-indigo-50/70 via-slate-50 to-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Lencana Informasi -->
            <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-indigo-100/80 border border-indigo-200 text-indigo-700 text-xs font-bold mb-6">
                <i class="fa-solid fa-sparkles text-amber-500"></i>
                <span>Sistem Produktivitas & Manajemen Tugas Terpadu</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-tight mb-6">
                Kelola Semua Tugas Harian Anda <br class="hidden sm:inline">
                dengan <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Cepat, Rapi & Terarah</span>
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-600 leading-relaxed mb-8">
                Tingkatkan efisiensi kerja dan rutinitas harian Anda dengan TaskFlow. Dilengkapi indikator prioritas visual, peringatan tenggat waktu cerdas, dan pelacakan kemajuan secara waktu nyata.
            </p>

            <!-- Tombol Aksi Hero -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 mb-14">
                @auth
                    <a href="{{ route('todos.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-7 py-3.5 rounded-2xl shadow-lg hover:shadow-indigo-500/30 transition text-base">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Menuju Halaman Tugas Saya</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-7 py-3.5 rounded-2xl shadow-lg hover:shadow-indigo-500/30 transition text-base">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Mulai Gratis Sekarang</span>
                    </a>
                    <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 font-bold px-7 py-3.5 rounded-2xl shadow-sm transition text-base">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span>Masuk ke Akun</span>
                    </a>
                @endauth
            </div>

            <!-- Preview Card Sederhana -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border border-slate-200/80 max-w-3xl mx-auto text-left relative overflow-hidden">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        <span class="text-xs font-bold text-slate-500 ml-2">Pratinjau Antarmuka TaskFlow</span>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-5 h-5 rounded-md bg-emerald-500 text-white flex items-center justify-center text-xs">
                                <i class="fa-solid fa-check"></i>
                            </span>
                            <span class="text-sm font-semibold text-slate-500 line-through">Menyelesaikan materi presentasi laporan akhir</span>
                        </div>
                        <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800">Selesai</span>
                    </div>

                    <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <span class="w-5 h-5 rounded-md border-2 border-slate-300"></span>
                            <span class="text-sm font-bold text-slate-800">Mempersiapkan evaluasi mingguan produktivitas</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full bg-rose-100 text-rose-700">Tinggi</span>
                            <span class="text-xs font-bold px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-900">Tenggat Hari Ini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Fitur Unggulan -->
    <section class="py-16 bg-white border-t border-slate-200">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-3">Fitur Cerdas untuk Menjaga Fokus Anda</h2>
                <p class="text-slate-600 text-sm sm:text-base">Dirancang khusus agar Anda selalu mengetahui tugas mana yang harus diselesaikan terlebih dahulu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Fitur 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-2">Tingkat Prioritas Visual</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Tentukan prioritas tugas (Rendah, Sedang, Tinggi) dengan tombol bundaran visual yang mudah dibedakan.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-2">Pengurutan Tenggat Waktu</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Urutkan tugas berdasarkan waktu terdekat atau terjauh sehingga tidak ada tugas penting yang terlewat.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-2">Bilah Kemajuan Otomatis</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">Pantau pencapaian penyelesaian tugas secara real-time dengan persentase kemajuan yang selalu diperbarui.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Kaki Halaman / Footer -->
    <footer class="bg-slate-900 text-slate-400 py-8 border-t border-slate-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-bolt-lightning text-amber-400"></i>
                <span class="font-bold text-white">TaskFlow</span>
                <span>— Sistem Produktivitas Pribadi</span>
            </div>
            <p>&copy; {{ date('Y') }} TaskFlow.</p>
        </div>
    </footer>

</body>
</html>
