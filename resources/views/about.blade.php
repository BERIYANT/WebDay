@extends('layouts.app')

@section('title', 'Tentang Kami & FAQ')
@section('header_title', 'Tentang Kami')

@section('styles')
<style>
    /* FAQ Accordion Transitions */
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
        opacity: 0;
    }
    .faq-active .faq-answer {
        max-height: 250px;
        opacity: 1;
        padding-top: 12px;
    }
    .faq-chevron {
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .faq-active .faq-chevron {
        transform: rotate(180deg);
    }
</style>
@endsection

@section('content')
<div class="space-y-8">
    <!-- Hero Header / Slogan Banner -->
    <div class="bg-gradient-to-r from-primary-600 via-indigo-600 to-orange-500 p-8 md:p-12 rounded-3xl text-white shadow-lg relative overflow-hidden">
        <!-- Abstract glowing light elements -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-20 -top-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="bg-white/20 text-white text-[11px] px-3 py-1 rounded-full font-black uppercase tracking-widest backdrop-blur-sm">
                About Us / Tentang Kami
            </span>
            <h2 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                Transform your habits into challenges
            </h2>
            <p class="text-white/90 text-sm md:text-base font-medium leading-relaxed">
                Kami percaya setiap perubahan besar dimulai dari kebiasaan kecil harian yang konsisten. Dengan menggabungkan teknologi AI dan gamifikasi, WebDay Challenge hadir untuk menuntun langkah pengembangan diri Anda dengan cara yang seru, terukur, dan bermakna.
            </p>
        </div>
    </div>

    <!-- Main Balanced Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- Left Side: Perusahaan & Kirim Pesan (5 Cols - Stacks beautifully!) -->
        <div class="lg:col-span-5 space-y-8">
            
            <!-- Company Info & WhatsApp Card -->
            <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-primary-500/10 to-orange-500/10 rounded-bl-full group-hover:scale-110 transition-transform"></div>
                
                <h3 class="text-lg font-extrabold text-slate-800 dark:text-white flex items-center gap-2 mb-4">
                    <i data-lucide="building-2" class="w-5 h-5 text-primary-500"></i>
                    <span>Perusahaan</span>
                </h3>
                
                <p class="text-sm font-semibold text-slate-500 dark:text-slate-400 mb-6 leading-relaxed">
                    Kami selalu terbuka terhadap kolaborasi, masukan, dan konsultasi teknis terkait pengembangan diri berbasis platform. Hubungi tim kami dengan mudah via WhatsApp!
                </p>

                <!-- WhatsApp CTA Button -->
                <div class="space-y-4">
                    <a href="https://api.whatsapp.com/send?phone=62895363339772&text=Halo%20WebDay%2C%20saya%20ingin%20bertanya%20mengenai%20platform%20ini." 
                       target="_blank" 
                       class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3.5 px-5 rounded-2xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-emerald-500/20 hover:scale-[1.02] active:scale-98">
                        <i data-lucide="phone-call" class="w-4 h-4"></i>
                        <span>Hubungi Kami (+62 895-3633-39772)</span>
                    </a>
                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-bold block text-center uppercase tracking-wider">
                        ⚡ Respon cepat via WhatsApp Chat resmi
                    </span>
                </div>
            </div>

            <!-- Kirim Pesan Card (Sesuai Tema WebDay, Terintegrasi & Rapi!) -->
            <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 md:p-8 shadow-sm">
                
                <!-- Card Header -->
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-darkBorder/60 mb-6">
                    <h3 class="text-lg font-extrabold text-slate-800 dark:text-white flex items-center gap-2">
                        <i data-lucide="message-square" class="w-5 h-5 text-primary-500"></i>
                        <span>A. Kirim Saran & Masukan</span>
                    </h3>
                    <span class="text-[10px] bg-primary-50 text-primary-600 dark:bg-primary-950/40 dark:text-primary-400 px-2 py-0.5 rounded font-black uppercase">Dukungan</span>
                </div>

                <!-- Form Body -->
                <form action="{{ route('about.saran') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama & No Telepon Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Nama Lengkap input -->
                        <div class="space-y-1.5">
                            <label for="name" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Nama Lengkap *</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                value="{{ old('name', Auth::user() ? Auth::user()->name : '') }}" 
                                placeholder="Nama lengkap Anda" 
                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('name') border-rose-500 focus:ring-rose-500 @enderror"
                                required
                            >
                            @error('name')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No Telepon input -->
                        <div class="space-y-1.5">
                            <label for="phone" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">No. Telepon *</label>
                            <input 
                                type="text" 
                                name="phone" 
                                id="phone" 
                                value="{{ old('phone') }}" 
                                placeholder="Contoh: 0895..." 
                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('phone') border-rose-500 focus:ring-rose-500 @enderror"
                                required
                            >
                            @error('phone')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email & Subjek Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Email Input -->
                        <div class="space-y-1.5">
                            <label for="email" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Email *</label>
                            <input 
                                type="email" 
                                name="email" 
                                id="email" 
                                value="{{ old('email', Auth::user() ? Auth::user()->email : '') }}" 
                                placeholder="email@example.com" 
                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('email') border-rose-500 focus:ring-rose-500 @enderror"
                                required
                            >
                            @error('email')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subjek Input -->
                        <div class="space-y-1.5">
                            <label for="subject" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Subjek *</label>
                            <input 
                                type="text" 
                                name="subject" 
                                id="subject" 
                                value="{{ old('subject') }}" 
                                placeholder="Subjek masukan Anda" 
                                class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl px-4 py-3 text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all @error('subject') border-rose-500 focus:ring-rose-500 @enderror"
                                required
                            >
                            @error('subject')
                                <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Pesan / Message Input -->
                    <div class="space-y-1.5">
                        <label for="content" class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Pesan *</label>
                        <textarea 
                            name="content" 
                            id="content" 
                            rows="3" 
                            placeholder="Tulis pesan, saran perbaikan, atau laporan kendala Anda di sini..." 
                            class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700/80 rounded-2xl p-4 text-sm font-semibold text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all resize-none @error('content') border-rose-500 focus:ring-rose-500 @enderror"
                            required
                        >{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-orange-500 hover:from-primary-700 hover:to-orange-600 text-white font-bold py-3.5 px-6 rounded-2xl text-xs transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary-500/10 hover:scale-[1.01] active:scale-98 cursor-pointer mt-4">
                        <span>Kirim Masukan Anda</span>
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>

        </div>

        <!-- Right Side: FAQ Accordion (7 Cols) -->
        <div class="lg:col-span-7 h-full">
            <div class="bg-white dark:bg-darkCard border border-slate-200 dark:border-darkBorder rounded-3xl p-6 shadow-sm h-full flex flex-col">
                
                <!-- FAQ Header -->
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-darkBorder/60 mb-6">
                    <div class="space-y-0.5">
                        <h3 class="text-lg font-extrabold text-slate-800 dark:text-white flex items-center gap-2">
                            <i data-lucide="help-circle" class="w-5 h-5 text-indigo-500"></i>
                            <span>B. FAQ (Tanya Jawab)</span>
                        </h3>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold">Jawaban cepat atas kendala dan pertanyaan umum Anda.</p>
                    </div>
                    <span class="text-[10px] bg-indigo-50 text-indigo-600 dark:bg-indigo-950/40 dark:text-indigo-400 px-2 py-0.5 rounded font-black uppercase">Bantuan</span>
                </div>

                <!-- FAQ Accordion List -->
                <div class="space-y-4">
                    
                    <!-- FAQ 1 (Active by Default) -->
                    <div class="faq-item faq-active border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Bagaimana cara mengikuti challenge?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Anda dapat membuka fitur <strong class="text-indigo-600 dark:text-indigo-400">Daily Challenge</strong> di menu utama dan langsung mulai mengerjakan berbagai kegiatan positif harian Anda untuk mengumpulkan poin.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 2 -->
                    <div class="faq-item border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Bagaimana cara klaim reward?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Anda dapat mengklaim poin yang sudah dikumpulkan di fitur <strong class="text-orange-500">Premium Access</strong> untuk ditukarkan dengan berbagai tema khusus, lencana (badge) keren, atau akses langganan premium.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 3 -->
                    <div class="faq-item border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Apakah progress akan tersimpan meskipun sudah log out?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Tetap bisa ya! Seluruh data perkembangan, streak, dan poin Anda akan aman tersimpan di sistem komputasi awan (database) kami, sehingga Anda tidak perlu khawatir kehilangan progres.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 4 -->
                    <div class="faq-item border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Apakah akun jika sudah membayar premium langsung terbuka aksesnya?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Iya benar sekali! Akun Anda akan langsung otomatis beralih ke premium dan Anda dapat langsung mengakses berbagai fitur eksklusif, seperti forum komunitas, tantangan berlabel khusus, serta kustomisasi tema premium.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 5 -->
                    <div class="faq-item border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Bagaimana jika ingin melaporkan masalah akun atau saran fitur?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Anda dapat menghubungi nomor resmi perusahaan lewat WhatsApp di panel sebelah kiri, atau secara instan mengirimkannya langsung melalui <strong class="text-primary-600 dark:text-primary-400">Kotak Saran</strong> yang sudah disediakan.
                            </div>
                        </div>
                    </div>

                    <!-- FAQ 6 -->
                    <div class="faq-item border border-slate-100 dark:border-darkBorder/50 rounded-2xl overflow-hidden transition-all bg-slate-50/20 dark:bg-slate-800/10 hover:bg-slate-50/50 dark:hover:bg-slate-800/30">
                        <button class="faq-trigger w-full flex items-center justify-between p-5 text-left focus:outline-none cursor-pointer">
                            <span class="text-sm font-extrabold text-slate-800 dark:text-slate-100 flex items-start gap-3">
                                <span class="w-5 h-5 rounded-full bg-indigo-50 dark:bg-indigo-950/60 flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></span>
                                </span>
                                <span>Apakah platform WebDay Challenge dapat diakses secara gratis?</span>
                            </span>
                            <i data-lucide="chevron-down" class="faq-chevron w-4 h-4 text-slate-400 flex-shrink-0 ml-3"></i>
                        </button>
                        <div class="faq-answer px-5 pb-5">
                            <div class="pl-8 text-xs md:text-sm font-semibold text-slate-500 dark:text-slate-400 leading-relaxed border-t border-slate-100 dark:border-darkBorder/30 pt-3">
                                Iya benar sekali! Anda dapat mengakses berbagai tantangan harian (daily challenges) dasar secara gratis. Untuk membuka analisis progress kebiasaan berbasis AI dan kustomisasi tema premium, Anda dapat beralih ke Premium Access kapan saja.
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqTriggers = document.querySelectorAll('.faq-trigger');

        faqTriggers.forEach(trigger => {
            trigger.addEventListener('click', () => {
                const parent = trigger.parentElement;
                
                // Toggle active class
                parent.classList.toggle('faq-active');

                // Optional: Close other FAQs (Accordion behavior)
                const allItems = document.querySelectorAll('.faq-item');
                allItems.forEach(item => {
                    if (item !== parent) {
                        item.classList.remove('faq-active');
                    }
                });
            });
        });
    });
</script>
@endsection
