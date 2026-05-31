@forelse($availablePartners as $candidate)
    <div class="bg-slate-50/50 dark:bg-slate-800/30 border border-slate-100 dark:border-darkBorder/40 p-4 rounded-2xl flex items-center justify-between gap-4 hover:scale-[1.01] transition-transform duration-200">
        <div class="flex items-center gap-3">
            @if($candidate->profile_image && file_exists(public_path('uploads/profiles/' . $candidate->profile_image)))
                <img src="{{ asset('uploads/profiles/' . $candidate->profile_image) }}" class="w-10 h-10 rounded-full object-cover flex-shrink-0 shadow-sm" alt="Avatar">
            @else
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-orange-500 text-white font-bold flex items-center justify-center text-xs uppercase shadow-sm flex-shrink-0">
                    {{ substr($candidate->name, 0, 2) }}
                </div>
            @endif
            <div>
                <h4 class="text-xs font-black text-slate-800 dark:text-white capitalize">{{ $candidate->name }}</h4>
                <span class="text-[9px] text-slate-400 font-bold block">{{ $candidate->points }} Poin • {{ $candidate->streak }} Streak</span>
            </div>
        </div>
        <form action="{{ route('partner.toggle-follow', $candidate->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold text-[10px] px-3.5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-1">
                <i data-lucide="user-plus" class="w-3.5 h-3.5"></i>
                <span>Follow</span>
            </button>
        </form>
    </div>
@empty
    <div class="col-span-full text-center py-8 bg-slate-50 dark:bg-slate-800/10 rounded-2xl border border-dashed border-slate-200/50 dark:border-darkBorder/40">
        <i data-lucide="users" class="w-8 h-8 text-slate-300 dark:text-slate-600 mx-auto mb-2"></i>
        <p class="text-xs text-slate-400 dark:text-slate-500 font-semibold leading-relaxed">Tidak ada rekomendasi partner yang cocok.</p>
    </div>
@endforelse
