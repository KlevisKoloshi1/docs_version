<aside class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col bg-slate-900">
    <!-- Logo -->
    <div class="flex h-16 items-center gap-3 px-5 border-b border-white/10">
        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-7 h-7 rounded-lg" />
        <a href="{{ route('dashboard') }}" class="text-base font-bold tracking-tight text-white">
            DocuCloud
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-5 space-y-0.5 overflow-y-auto">
        @php
            $active   = 'sidebar-link sidebar-link-active';
            $inactive = 'sidebar-link sidebar-link-inactive';
        @endphp

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? $active : $inactive }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <!-- My Documents -->
        <a href="{{ route('documents.index', ['tab' => 'my']) }}"
           class="{{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? $active : $inactive }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            My Documents
        </a>

        <!-- Shared with Me -->
        <a href="{{ route('documents.index', ['tab' => 'shared']) }}"
           class="{{ request()->routeIs('documents.*') && request('tab') === 'shared' ? $active : $inactive }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
            </svg>
            Shared with Me
        </a>

        <!-- Upload -->
        <a href="{{ route('documents.create') }}"
           class="{{ request()->routeIs('documents.create') ? $active : $inactive }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            Upload
        </a>

        <div class="my-3 border-t border-white/10"></div>

        <!-- Settings -->
        <a href="{{ route('profile.edit') }}"
           class="{{ request()->routeIs('profile.*') ? $active : $inactive }}">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Settings
        </a>
    </nav>

    <!-- User footer -->
    <div class="border-t border-white/10 px-4 py-4">
        <div class="flex items-center gap-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-600 text-xs font-bold text-white uppercase">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>
</aside>
