<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-zinc-900 leading-tight">{{ __('Documents') }}</h2>
                <p class="mt-1 text-sm text-zinc-500">Search, filter, and manage your files in one place.</p>
            </div>
            <a href="{{ route('documents.create') }}" class="inline-flex items-center rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition-colors">
                Upload Document
            </a>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="mb-4 rounded-lg border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-800">
            {{ session('status') }}
        </div>
    @endif

    <div class="space-y-6">
        <div class="rounded-xl bg-white border border-zinc-200 p-4">
            <div class="flex flex-wrap items-center gap-1">
                <a href="{{ route('documents.index', array_merge(request()->except('page', 'shared_page', 'tab'), ['tab' => 'all'])) }}"
                   class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors {{ $tab === 'all' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    All
                </a>
                <a href="{{ route('documents.index', array_merge(request()->except('page', 'shared_page', 'tab'), ['tab' => 'my'])) }}"
                   class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors {{ $tab === 'my' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    My Documents
                </a>
                <a href="{{ route('documents.index', array_merge(request()->except('page', 'shared_page', 'tab'), ['tab' => 'shared'])) }}"
                   class="rounded-lg px-3 py-1.5 text-sm font-medium transition-colors {{ $tab === 'shared' ? 'bg-brand-50 text-brand-700' : 'text-zinc-600 hover:bg-zinc-100' }}">
                    Shared with Me
                </a>
            </div>
            <form method="GET" action="{{ route('documents.index') }}" class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-5">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <x-text-input name="q" value="{{ $q }}" placeholder="Search by document name..." class="md:col-span-2 block w-full" />
                <select name="type" class="rounded-lg border-zinc-300 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500">
                    <option value="">All file types</option>
                    <option value="image" @selected($type === 'image')>Images</option>
                    <option value="application/pdf" @selected($type === 'application/pdf')>PDF</option>
                    <option value="application/vnd.openxmlformats-officedocument.wordprocessingml.document" @selected($type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document')>DOCX</option>
                </select>
                <input type="date" name="from" value="{{ $from }}" class="rounded-lg border-zinc-300 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                <input type="date" name="to" value="{{ $to }}" class="rounded-lg border-zinc-300 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                <div class="md:col-span-5 flex flex-wrap gap-2">
                    <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition-colors">Apply filters</button>
                    <a href="{{ route('documents.index', ['tab' => $tab]) }}" class="rounded-lg border border-zinc-200 px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">Reset</a>
                </div>
            </form>
        </div>

        @if ($tab !== 'shared')
            <div class="rounded-xl bg-white border border-zinc-200">
                <div class="border-b border-zinc-100 px-6 py-4">
                    <div class="text-sm font-semibold text-zinc-900">My Documents</div>
                </div>
                <div class="p-6">
                    @include('documents.partials.table', ['items' => $documents, 'emptyText' => 'No personal documents found.'])
                </div>
            </div>
        @endif

        @if ($tab !== 'my')
            <div class="rounded-xl bg-white border border-zinc-200">
                <div class="border-b border-zinc-100 px-6 py-4">
                    <div class="text-sm font-semibold text-zinc-900">Shared with Me</div>
                </div>
                <div class="p-6">
                    @include('documents.partials.table', ['items' => $sharedDocuments, 'emptyText' => 'No shared documents found.'])
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
