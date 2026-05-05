<header class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 md:hidden">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-blue-500">DocuCloud</a>
        </div>

        <div class="hidden md:block">
            @isset($header)
                <div class="text-base font-semibold text-gray-800">
                    {{ $header }}
                </div>
            @else
                <div class="text-base font-semibold text-gray-800">Dashboard</div>
            @endisset
        </div>

        <div class="flex items-center gap-4">
            <span class="hidden text-sm text-gray-600 sm:inline">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-lg border border-gray-200 px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="border-t border-gray-100 bg-white px-4 py-2 md:hidden">
        <nav class="flex gap-2 overflow-x-auto text-sm">
            <a href="{{ route('dashboard') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">Dashboard</a>
            <a href="{{ route('documents.index', ['tab' => 'my']) }}" class="whitespace-nowrap rounded-md px-3 py-1.5 {{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">My Documents</a>
            <a href="{{ route('documents.index', ['tab' => 'shared']) }}" class="whitespace-nowrap rounded-md px-3 py-1.5 {{ request()->routeIs('documents.*') && request('tab') === 'shared' ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">Shared with Me</a>
            <a href="{{ route('documents.create') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 {{ request()->routeIs('documents.create') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">Upload</a>
            <a href="{{ route('profile.edit') }}" class="whitespace-nowrap rounded-md px-3 py-1.5 {{ request()->routeIs('profile.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600' }}">Settings</a>
        </nav>
    </div>
</header>

