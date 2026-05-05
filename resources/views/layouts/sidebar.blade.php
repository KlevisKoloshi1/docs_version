<aside class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col md:border-r md:border-gray-200 md:bg-white">
    <div class="flex h-16 items-center border-b border-gray-100 px-6">
        <a href="{{ route('dashboard') }}" class="text-xl font-semibold tracking-tight text-blue-500">DocuCloud</a>
    </div>

    <nav class="flex-1 space-y-1 px-4 py-6">
        @php
            $activeClass = 'bg-blue-50 text-blue-600 border-blue-100';
            $baseClass = 'border border-transparent text-gray-600 hover:bg-gray-50 hover:text-gray-900';
        @endphp

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium">
            Dashboard
        </a>
        <a href="{{ route('documents.index', ['tab' => 'my']) }}" class="{{ request()->routeIs('documents.index') && request('tab', 'all') !== 'shared' ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium">
            My Documents
        </a>
        <a href="{{ route('documents.index', ['tab' => 'shared']) }}" class="{{ request()->routeIs('documents.*') && request('tab') === 'shared' ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium">
            Shared with Me
        </a>
        <a href="{{ route('documents.create') }}" class="{{ request()->routeIs('documents.create') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium">
            Upload
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? $activeClass : $baseClass }} flex items-center rounded-lg px-3 py-2 text-sm font-medium">
            Settings
        </a>
    </nav>
</aside>

