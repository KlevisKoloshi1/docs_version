<header class="sticky top-0 z-20 border-b border-zinc-200 bg-white/95 backdrop-blur-sm">
    <div class="mx-auto flex h-14 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        <!-- Mobile: logo -->
        <div class="flex items-center gap-2 md:hidden">
            <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-6 h-6 rounded-md" />
            <a href="{{ route('dashboard') }}" class="text-base font-bold text-slate-900">DocuCloud</a>
        </div>

        <!-- Desktop: page title / header slot -->
        <div class="hidden md:block">
            @isset($header)
                <div class="text-sm font-semibold text-zinc-800">{{ $header }}</div>
            @else
                <div class="text-sm font-semibold text-zinc-800">Dashboard</div>
            @endisset
        </div>

        <!-- Right side -->
        <div class="flex items-center gap-3">
            <a href="{{ route('documents.create') }}"
               class="hidden sm:inline-flex items-center gap-1.5 rounded-lg bg-brand-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Upload
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-600 transition hover:bg-zinc-50 hover:text-zinc-900">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile nav strip -->
    <div class="border-t border-zinc-100 bg-white px-4 py-2 md:hidden">
        <nav class="flex gap-1 overflow-x-auto text-sm">
            <a href="{{ route('dashboard') }}"
               class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                Dashboard
            </a>
            <a href="{{ route('documents.index', ['tab' => 'my']) }}"
               class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                My Docs
            </a>
            <a href="{{ route('documents.index', ['tab' => 'shared']) }}"
               class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.*') && request('tab') === 'shared' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                Shared
            </a>
            <a href="{{ route('documents.create') }}"
               class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.create') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                Upload
            </a>
            <a href="{{ route('profile.edit') }}"
               class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                Settings
            </a>
        </nav>
    </div>
</header>
