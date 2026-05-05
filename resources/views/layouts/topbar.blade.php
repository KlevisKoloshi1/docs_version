<header class="sticky top-0 z-20 border-b border-zinc-200 bg-white">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 md:hidden">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold text-brand-600">DocuCloud</a>
        </div>

        <div class="hidden md:block">
            @isset($header)
                <div class="text-base font-semibold text-zinc-800">
                    {{ $header }}
                </div>
            @else
                <div class="text-base font-semibold text-zinc-800">Dashboard</div>
            @endisset
        </div>

        <div class="flex items-center gap-4">
            <span class="hidden text-sm text-zinc-500 sm:inline">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-lg border border-zinc-200 px-3 py-1.5 text-sm font-medium text-zinc-700 transition hover:bg-zinc-50">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="border-t border-zinc-100 bg-white px-4 py-2 md:hidden">
        <nav class="flex gap-1 overflow-x-auto text-sm">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">Dashboard</a>
            <a href="{{ route('documents.index', ['tab' => 'my']) }}" class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">My Documents</a>
            <a href="{{ route('documents.index', ['tab' => 'shared']) }}" class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.*') && request('tab') === 'shared' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">Shared with Me</a>
            <a href="{{ route('documents.create') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('documents.create') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">Upload</a>
            <a href="{{ route('profile.edit') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 font-medium {{ request()->routeIs('profile.*') ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">Settings</a>
        </nav>
    </div>
</header>
