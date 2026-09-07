<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru — TaskFlow</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome Icons CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Pola Bintik-Bintik Halus & Berjarak Renggang (Minimalist Sparse Dots) */
        .bg-bintik {
            background-color: #ffffff;
            background-image: radial-gradient(#cbd5e1 1.3px, transparent 1.3px);
            background-size: 42px 42px;
        }
    </style>
</head>
<body class="relative min-h-screen bg-bintik text-slate-800 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 selection:bg-indigo-500 selection:text-white">

    <!-- Efek Pendar Cahaya Lembut Sudut (Pastel Ambient Glow) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-32 -right-32 w-96 h-96 bg-purple-200/40 rounded-full blur-[100px]"></div>
        <div class="absolute top-1/2 -left-32 w-[28rem] h-[28rem] bg-indigo-200/35 rounded-full blur-[110px]"></div>
        <div class="absolute -bottom-32 right-1/4 w-96 h-96 bg-pink-200/40 rounded-full blur-[100px]"></div>
    </div>

    <!-- Header & Logo Brand -->
    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex flex-col items-center justify-center">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 group transition transform hover:-translate-y-0.5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 via-indigo-700 to-purple-700 flex items-center justify-center text-white shadow-xl shadow-indigo-600/20 ring-4 ring-white group-hover:ring-indigo-100 transition duration-300">
                    <i class="fa-solid fa-bolt-lightning text-2xl text-amber-300"></i>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-800 to-purple-800 bg-clip-text text-transparent flex items-center gap-1.5">
                        TaskFlow
                        <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block animate-pulse"></span>
                    </span>
                    <span class="block text-[11px] font-bold text-indigo-600 tracking-wider uppercase">Produktivitas Pribadi</span>
                </div>
            </a>

            <h2 class="mt-6 text-center text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-xs sm:text-sm text-slate-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 underline underline-offset-4 decoration-indigo-300 hover:decoration-indigo-600 transition">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>

    <!-- Wadah Kartu Formulir -->
    <div class="relative z-10 mt-7 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white/95 backdrop-blur-xl py-8 px-6 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)] rounded-3xl sm:px-10 border border-slate-200/90 relative overflow-hidden">
            
            <!-- Aksen Garis Gradien Atas -->
            <div class="absolute top-0 inset-x-0 h-1.5 bg-gradient-to-r from-purple-600 via-indigo-600 to-pink-500"></div>

            <!-- Pesan Kesalahan Validasi -->
            @if ($errors->any())
                <div class="mb-5 bg-rose-50 border-l-4 border-rose-500 text-rose-800 p-3.5 rounded-r-xl text-xs space-y-1 shadow-xs">
                    <div class="font-bold flex items-center space-x-1.5">
                        <i class="fa-solid fa-circle-info text-rose-500 flex-shrink-0"></i>
                        <span>Mohon periksa data yang Anda masukkan:</span>
                    </div>
                    <ul class="list-disc list-inside pl-3 text-rose-700 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-600 pointer-events-none transition">
                            <i class="fa-regular fa-user text-sm"></i>
                        </span>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                               placeholder="Nama lengkap Anda"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50/60 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm outline-none transition shadow-xs">
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Username <span class="text-slate-400 font-normal text-[11px]">(Untuk masuk akun - opsional)</span>
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-600 pointer-events-none transition">
                            <i class="fa-solid fa-at text-sm"></i>
                        </span>
                        <input id="username" name="username" type="text" value="{{ old('username') }}"
                               placeholder="Contoh: sukri123"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50/60 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm outline-none transition shadow-xs">
                    </div>
                </div>

                <!-- Alamat Email -->
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-600 pointer-events-none transition">
                            <i class="fa-regular fa-envelope text-sm"></i>
                        </span>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               placeholder="email@contoh.com"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-300 bg-slate-50/60 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm outline-none transition shadow-xs">
                    </div>
                </div>

                <!-- Kata Sandi -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-600 pointer-events-none transition">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input id="password" name="password" type="password" required
                               placeholder="Minimal 6 karakter"
                               class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-300 bg-slate-50/60 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm outline-none transition shadow-xs">
                        <button type="button" onclick="togglePasswordVisibility('password', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition outline-none"
                                title="Lihat/Sembunyikan Kata Sandi">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Konfirmasi Kata Sandi <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 group-focus-within:text-indigo-600 pointer-events-none transition">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </span>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               placeholder="Ulangi kata sandi"
                               class="w-full pl-10 pr-11 py-2.5 rounded-xl border border-slate-300 bg-slate-50/60 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 text-sm outline-none transition shadow-xs">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition outline-none"
                                title="Lihat/Sembunyikan Kata Sandi">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full flex justify-center items-center space-x-2 py-3 px-4 rounded-xl shadow-lg shadow-indigo-600/25 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 hover:from-indigo-500 hover:via-indigo-600 hover:to-purple-600 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <i class="fa-solid fa-user-plus"></i>
                        <span>Daftar Sekarang</span>
                    </button>
                </div>
            </form>

            <!-- Keterangan Akun Bawaan Administrator -->
            <div class="mt-6 p-3.5 rounded-2xl bg-amber-50/90 border border-amber-200 text-xs text-amber-950 flex items-start space-x-2.5 shadow-xs">
                <i class="fa-solid fa-shield-halved text-amber-600 text-sm mt-0.5 shrink-0"></i>
                <div class="space-y-0.5">
                    <p class="font-bold text-amber-900">Akun Administrator Bawaan Sistem:</p>
                    <p class="text-amber-800 text-[11px] leading-relaxed">
                        Akun Administrator sudah tersedia secara otomatis dari sistem (username: <code class="font-bold text-amber-950 bg-white px-1 py-0.5 rounded border border-amber-200">admin</code>) dan tidak perlu mendaftar. Halaman ini khusus pendaftaran akun pengguna baru.
                    </p>
                </div>
            </div>

            <div class="mt-6 border-t border-slate-100 pt-4 text-center">
                <a href="{{ route('landing') }}" class="text-xs font-semibold text-slate-500 hover:text-indigo-600 transition flex items-center justify-center space-x-1.5 group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    <span>Kembali ke Halaman Beranda</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Skrip Pengalih Keterlihatan Sandi -->
    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
