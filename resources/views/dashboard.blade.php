<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl bg-white border border-zinc-200 p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-400">Total Documents</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($totalDocuments) }}</p>
            </div>
            <div class="rounded-xl bg-white border border-zinc-200 p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-400">Storage Used</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($storageUsedBytes / 1024 / 1024, 2) }} MB</p>
            </div>
            <div class="rounded-xl bg-white border border-zinc-200 p-5">
                <p class="text-xs font-medium uppercase tracking-wider text-zinc-400">Shared Files</p>
                <p class="mt-2 text-3xl font-bold text-zinc-900">{{ number_format($sharedFiles) }}</p>
            </div>
        </div>

        <div class="rounded-xl bg-white border border-zinc-200">
            <div class="flex items-center justify-between border-b border-zinc-100 px-6 py-4">
                <h3 class="text-sm font-semibold text-zinc-900">Recent Documents</h3>
                <a href="{{ route('documents.index') }}" class="rounded-lg bg-brand-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-brand-700 transition-colors">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100">
                    <thead class="bg-zinc-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-zinc-400">
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Owner</th>
                            <th class="px-6 py-3">Last updated</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse ($recentDocuments as $doc)
                            <tr class="hover:bg-zinc-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900">{{ $doc->title }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-500">{{ $doc->owner?->name ?? auth()->user()->name }}</td>
                                <td class="px-6 py-4 text-sm text-zinc-500">{{ $doc->updated_at?->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('documents.show', $doc) }}" class="rounded-md border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('documents.download', $doc) }}" class="rounded-md bg-brand-600 px-3 py-1.5 text-xs font-medium text-white hover:bg-brand-700 transition-colors">
                                            Download
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-zinc-400">No documents uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
