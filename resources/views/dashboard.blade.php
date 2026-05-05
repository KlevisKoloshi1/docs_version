<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-xl bg-white p-5 shadow-md">
                <p class="text-sm text-gray-500">Total Documents</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($totalDocuments) }}</p>
            </div>
            <div class="rounded-xl bg-white p-5 shadow-md">
                <p class="text-sm text-gray-500">Storage Used</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($storageUsedBytes / 1024 / 1024, 2) }} MB</p>
            </div>
            <div class="rounded-xl bg-white p-5 shadow-md">
                <p class="text-sm text-gray-500">Shared Files</p>
                <p class="mt-2 text-3xl font-semibold text-gray-900">{{ number_format($sharedFiles) }}</p>
            </div>
        </div>

        <div class="rounded-xl bg-white shadow-md">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-semibold text-gray-900">Recent Documents</h3>
                <a href="{{ route('documents.index') }}" class="rounded-lg bg-blue-500 px-3 py-2 text-sm font-medium text-white hover:bg-blue-600">
                    View all
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Owner</th>
                            <th class="px-6 py-3">Last updated</th>
                            <th class="px-6 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($recentDocuments as $doc)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $doc->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $doc->owner?->name ?? auth()->user()->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $doc->updated_at?->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('documents.show', $doc) }}" class="rounded-md border border-gray-200 px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50">
                                            View
                                        </a>
                                        <a href="{{ route('documents.download', $doc) }}" class="rounded-md bg-blue-500 px-3 py-1.5 text-sm text-white hover:bg-blue-600">
                                            Download
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">No documents uploaded yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
