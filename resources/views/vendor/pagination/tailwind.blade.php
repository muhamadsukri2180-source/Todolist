@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi Paginasi" class="flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Tampilan Ponsel (Mobile) -->
        <div class="flex justify-between w-full sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-white border border-slate-200 rounded-xl shadow-xs cursor-not-allowed">
                    <i class="fa-solid fa-chevron-left mr-1.5 text-[10px]"></i> Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/40 rounded-xl shadow-xs transition">
                    <i class="fa-solid fa-chevron-left mr-1.5 text-[10px]"></i> Sebelumnya
                </a>
            @endif

            <!-- Kotak Ringkasan Mobile -->
            <div class="inline-flex items-center px-3 py-1.5 rounded-xl bg-white border border-slate-200 shadow-xs text-xs font-medium text-slate-600">
                <span class="text-indigo-600 font-bold mr-1">{{ $paginator->currentPage() }}</span> / {{ $paginator->lastPage() }}
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-700 bg-white border border-slate-200 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50/40 rounded-xl shadow-xs transition">
                    Berikutnya <i class="fa-solid fa-chevron-right ml-1.5 text-[10px]"></i>
                </a>
            @else
                <span class="inline-flex items-center px-4 py-2 text-xs font-semibold text-slate-400 bg-white border border-slate-200 rounded-xl shadow-xs cursor-not-allowed">
                    Berikutnya <i class="fa-solid fa-chevron-right ml-1.5 text-[10px]"></i>
                </span>
            @endif
        </div>

        <!-- Tampilan Desktop & Tablet -->
        <div class="hidden sm:flex sm:items-center sm:justify-between w-full">
            
            <!-- Kotak Putih Informasi Jumlah Tugas: Menampilkan X sampai Y dari Z tugas -->
            <div>
                <div class="inline-flex items-center space-x-1.5 px-4 py-2 rounded-xl bg-white border border-slate-200/90 shadow-sm text-xs font-medium text-slate-700">
                    <i class="fa-solid fa-layer-group text-indigo-500 mr-1 text-[11px]"></i>
                    <span>Menampilkan</span>
                    @if ($paginator->firstItem())
                        <span class="font-bold text-indigo-600 bg-indigo-50/80 px-1.5 py-0.5 rounded border border-indigo-100">{{ $paginator->firstItem() }}</span>
                        <span>sampai</span>
                        <span class="font-bold text-indigo-600 bg-indigo-50/80 px-1.5 py-0.5 rounded border border-indigo-100">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-bold text-indigo-600 bg-indigo-50/80 px-1.5 py-0.5 rounded border border-indigo-100">{{ $paginator->count() }}</span>
                    @endif
                    <span>dari</span>
                    <span class="font-bold text-slate-900 bg-slate-100 px-1.5 py-0.5 rounded border border-slate-200">{{ $paginator->total() }}</span>
                    <span>tugas</span>
                </div>
            </div>

            <!-- Tombol Navigasi Halaman Kotak Putih -->
            <div>
                <nav class="inline-flex items-center space-x-1.5 p-1 rounded-2xl bg-white border border-slate-200/90 shadow-sm" aria-label="Halaman">
                    
                    {{-- Tombol Sebelumnya --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-slate-300 bg-white border border-transparent rounded-xl cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i>
                            <span class="hidden md:inline">Sebelumnya</span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition shadow-xs border border-slate-100" title="Halaman Sebelumnya">
                            <i class="fa-solid fa-chevron-left text-[10px] mr-1"></i>
                            <span class="hidden md:inline">Sebelumnya</span>
                        </a>
                    @endif

                    {{-- Tombol Angka Halaman --}}
                    @foreach ($elements as $element)
                        {{-- Pemisah Titik Tiga (...) --}}
                        @if (is_string($element))
                            <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-slate-400 bg-white">
                                {{ $element }}
                            </span>
                        @endif

                        {{-- Daftar Halaman --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span class="inline-flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-indigo-600 rounded-xl shadow-md shadow-indigo-600/20 border border-indigo-600" aria-current="page">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex items-center justify-center w-8 h-8 text-xs font-semibold text-slate-700 bg-white hover:bg-indigo-50 hover:text-indigo-600 border border-slate-200/80 rounded-xl transition shadow-xs" title="Menuju ke Halaman {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Berikutnya --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center px-2.5 py-1.5 text-xs font-semibold text-slate-700 bg-white hover:bg-slate-50 hover:text-indigo-600 rounded-xl transition shadow-xs border border-slate-100" title="Halaman Berikutnya">
                            <span class="hidden md:inline">Berikutnya</span>
                            <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center px-2.5 py-1.5 text-xs font-medium text-slate-300 bg-white border border-transparent rounded-xl cursor-not-allowed">
                            <span class="hidden md:inline">Berikutnya</span>
                            <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i>
                        </span>
                    @endif
                </nav>
            </div>
        </div>
    </nav>
@endif
