<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <!-- Stats row -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Total Documents</p>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50">
                        <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-zinc-900">{{ number_format($totalDocuments) }}</p>
            </div>

            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Storage Used</p>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-50">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-zinc-900">{{ number_format($storageUsedBytes / 1024 / 1024, 2) }} <span class="text-lg font-semibold text-zinc-400">MB</span></p>
            </div>

            <div class="card p-5">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold uppercase tracking-wider text-zinc-400">Shared Files</p>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </div>
                </div>
                <p class="mt-3 text-3xl font-bold text-zinc-900">{{ number_format($sharedFiles) }}</p>
            </div>
        </div>

        <!-- Recent documents -->
        <div class="card">
            <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-4">
                <div>
                    <h3 class="text-sm font-semibold text-zinc-900">Recent Documents</h3>
                    <p class="mt-0.5 text-xs text-zinc-400">Your latest activity</p>
                </div>
                <a href="{{ route('documents.index') }}"
                   class="inline-flex items-center gap-1 rounded-lg bg-brand-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50/70">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Owner</th>
                            <th class="px-6 py-3">Last updated</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse ($recentDocuments as $doc)
                            <tr class="hover:bg-zinc-50/60 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900">{{ $doc->title }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-500">{{ $doc->owner?->name ?? auth()->user()->name }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-400">{{ $doc->updated_at?->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('documents.show', $doc) }}"
                                           class="rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('documents.download', $doc) }}"
                                           class="rounded-md bg-brand-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-brand-700 transition-colors">
                                            Download
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <svg class="w-8 h-8 text-zinc-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                                        </svg>
                                        <p class="text-sm text-zinc-400">No documents uploaded yet.</p>
                                        <a href="{{ route('documents.create') }}" class="mt-1 text-sm font-medium text-brand-600 hover:text-brand-700">Upload your first document →</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
