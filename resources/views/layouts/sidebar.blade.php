<aside class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col md:border-r md:border-zinc-200 md:bg-white">
    <div class="flex h-16 items-center border-b border-zinc-100 px-6">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight text-brand-600">DocuCloud</a>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-5">
        @php
            $activeClass = 'bg-brand-50 text-brand-700 font-semibold';
            $baseClass = 'text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900';
        @endphp

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors">
            Dashboard
        </a>
        <a href="{{ route('documents.index', ['tab' => 'my']) }}" class="{{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors">
            My Documents
        </a>
        <a href="{{ route('documents.index', ['tab' => 'shared']) }}" class="{{ request()->routeIs('documents.*') && request('tab') === 'shared' ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors">
            Shared with Me
        </a>
        <a href="{{ route('documents.create') }}" class="{{ request()->routeIs('documents.create') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors">
            Upload
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium transition-colors">
            Settings
        </a>
    </nav>
</aside>
