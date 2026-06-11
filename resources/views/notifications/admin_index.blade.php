@extends('layouts.dashboard')

@section('title', 'Notifikasi Admin - RODOKAN')

@section('content')
<div class="p-6 md:p-8 max-w-[1400px] mx-auto w-full">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900 mb-1">Notifikasi Admin</h1>
            <p class="text-slate-500 text-sm">Pantau pemberitahuan penting terkait laporan masyarakat Kota Bandung</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            @if(($stats['unread'] ?? 0) > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
            @if($unreadNotifications->isNotEmpty() || $readNotifications->isNotEmpty())
            <form action="{{ route('notifications.delete-all') }}" method="POST" onsubmit="return confirm('Hapus semua notifikasi?')">
                @csrf
                <button type="submit" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl transition-colors shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Semua
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-blue-500 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">{{ $stats['unread'] ?? 0 }}</h3>
                <p class="text-xs font-medium text-white/80">Notifikasi Baru</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="bg-red-600 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">{{ $stats['darurat'] ?? 0 }}</h3>
                <p class="text-xs font-medium text-white/80">Laporan Darurat</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="bg-amber-500 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">{{ $stats['verifikasi'] ?? 0 }}</h3>
                <p class="text-xs font-medium text-white/80">Menunggu Verifikasi</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>

        <div class="bg-orange-600 text-white rounded-2xl p-5 shadow-sm relative overflow-hidden">
            <div class="relative z-10">
                <svg class="w-6 h-6 mb-3 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                <h3 class="text-3xl font-extrabold mb-1">{{ $stats['instansi'] ?? 0 }}</h3>
                <p class="text-xs font-medium text-white/80">Update Instansi</p>
            </div>
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-6 flex overflow-x-auto scrollbar-hide">
        <button type="button" onclick="switchNotifTab('semua')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-blue-600 border-blue-600" data-target="semua">Semua</button>
        <button type="button" onclick="switchNotifTab('belum-dibaca')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="belum-dibaca">Belum Dibaca</button>
        <button type="button" onclick="switchNotifTab('sudah-dibaca')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="sudah-dibaca">Sudah Dibaca</button>
        <button type="button" onclick="switchNotifTab('darurat')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="darurat">Darurat</button>
        <button type="button" onclick="switchNotifTab('verifikasi')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="verifikasi">Verifikasi</button>
        <button type="button" onclick="switchNotifTab('komentar')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="komentar">Komentar Warga</button>
        <button type="button" onclick="switchNotifTab('instansi')" class="notif-tab-btn whitespace-nowrap px-6 py-4 text-sm font-semibold transition-colors border-b-2 text-slate-500 border-transparent hover:text-slate-700" data-target="instansi">Update Instansi</button>
    </div>

  @if($unreadNotifications->isEmpty() && $readNotifications->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-16 text-center text-slate-400">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        <p class="text-sm font-medium">Belum ada notifikasi</p>
        <p class="text-xs mt-1">Notifikasi akan muncul saat ada laporan baru, komentar, atau update status.</p>
    </div>
  @else
    <div class="space-y-6">
        @if($unreadNotifications->isNotEmpty())
        <div id="panel-belum-dibaca" class="notif-panel-group bg-white rounded-2xl border border-slate-200 shadow-sm p-6" data-groups="semua,belum-dibaca,darurat,verifikasi,komentar,instansi,biasa">
            <h2 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Belum Dibaca ({{ $unreadNotifications->count() }})
            </h2>
            <div class="space-y-4">
                @foreach($unreadNotifications as $notification)
                    @include('notifications.partials.admin_item', ['notification' => $notification])
                @endforeach
            </div>
        </div>
        @endif

        @if($readNotifications->isNotEmpty())
        <div id="panel-sudah-dibaca" class="notif-panel-group bg-white rounded-2xl border border-slate-200 shadow-sm p-6 block" data-groups="semua,sudah-dibaca">
            <h2 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Sudah Dibaca ({{ $readNotifications->count() }})
            </h2>
            <div class="space-y-4">
                @foreach($readNotifications as $notification)
                    @include('notifications.partials.admin_item', ['notification' => $notification])
                @endforeach
            </div>
        </div>
        @endif
    </div>
  @endif
</div>

@push('scripts')
<script>
    function switchNotifTab(tabId) {
        document.querySelectorAll('.notif-panel-group').forEach(group => {
            const groups = group.getAttribute('data-groups').split(',');
            group.style.display = groups.includes(tabId) ? 'block' : 'none';
        });

        document.querySelectorAll('.notif-item').forEach(item => {
            const itemType = item.getAttribute('data-type');
            if (tabId === 'semua' || tabId === 'belum-dibaca' || tabId === 'sudah-dibaca') {
                item.style.display = 'block';
            } else {
                item.style.display = itemType === tabId ? 'block' : 'none';
            }
        });

        document.querySelectorAll('.notif-tab-btn').forEach(btn => {
            btn.classList.remove('text-blue-600', 'border-blue-600');
            btn.classList.add('text-slate-500', 'border-transparent', 'hover:text-slate-700');
        });

        const activeBtn = document.querySelector(`.notif-tab-btn[data-target="${tabId}"]`);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-500', 'border-transparent', 'hover:text-slate-700');
            activeBtn.classList.add('text-blue-600', 'border-blue-600');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        document.querySelectorAll('.delete-notif').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (!confirm('Hapus notifikasi ini?')) return;

                fetch(`/notifications/${btn.dataset.id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                }).then(() => location.reload());
            });
        });
    });
</script>
@endpush
@endsection
