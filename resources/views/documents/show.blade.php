<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs font-medium uppercase tracking-wider text-zinc-400">Document</div>
                <h2 class="font-semibold text-xl text-zinc-900 leading-tight">
                    {{ $document->title }}
                </h2>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('documents.index') }}" class="text-sm text-zinc-500 hover:text-zinc-900 transition-colors">Back</a>
                <a href="{{ route('documents.download', $document) }}" class="rounded-lg bg-brand-600 px-3 py-2 text-sm font-medium text-white hover:bg-brand-700 transition-colors">
                    Download current
                </a>
                @can('delete', $document)
                    <form method="POST" action="{{ route('documents.destroy', $document) }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button onclick="return confirm('Delete this document and all versions?')">
                            Delete
                        </x-danger-button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-brand-200 bg-brand-50 px-4 py-3 text-sm text-brand-800">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <div class="lg:col-span-2 space-y-6">
                    <div class="rounded-xl bg-white border border-zinc-200">
                        <div class="border-b border-zinc-100 px-6 py-4">
                            <div class="text-sm font-semibold text-zinc-900">Current version</div>
                            <div class="mt-1 text-xs text-zinc-400">
                                Owner: {{ $document->owner->email }}
                            </div>
                        </div>
                        <div class="p-6">
                            @if ($document->currentVersion)
                                <div class="flex flex-wrap items-center gap-x-8 gap-y-2 text-sm text-zinc-700">
                                    <div><span class="text-zinc-400">Version</span> <span class="font-semibold">v{{ $document->currentVersion->version_number }}</span></div>
                                    <div><span class="text-zinc-400">Size</span> <span class="font-semibold">{{ number_format(($document->currentVersion->size_bytes ?? 0) / 1024, 1) }} KB</span></div>
                                    <div><span class="text-zinc-400">Uploaded</span> <span class="font-semibold">{{ $document->currentVersion->created_at->toDayDateTimeString() }}</span></div>
                                    <div><span class="text-zinc-400">By</span> <span class="font-semibold">{{ $document->currentVersion->uploader?->email ?? '—' }}</span></div>
                                </div>
                                @if ($document->currentVersion->change_summary)
                                    <div class="mt-4 rounded-lg bg-zinc-50 border border-zinc-100 p-4 text-sm text-zinc-600">
                                        {{ $document->currentVersion->change_summary }}
                                    </div>
                                @endif
                            @else
                                <div class="text-sm text-zinc-500">No current version.</div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-xl bg-white border border-zinc-200">
                        <div class="border-b border-zinc-100 px-6 py-4">
                            <div class="text-sm font-semibold text-zinc-900">Version history</div>
                            <div class="mt-1 text-xs text-zinc-400">Upload, review, and restore versions</div>
                        </div>
                        <div class="p-6">
                            @if ($canEdit)
                                <form method="POST" action="{{ route('documents.versions.store', $document) }}" enctype="multipart/form-data" class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    @csrf
                                    <div class="sm:col-span-1">
                                        <x-input-label for="file" value="New version file" />
                                        <input id="file" name="file" type="file" class="mt-1 block w-full text-sm text-zinc-700" required />
                                        <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                    </div>
                                    <div class="sm:col-span-2">
                                        <x-input-label for="change_summary" value="Change summary (optional)" />
                                        <x-text-input id="change_summary" name="change_summary" type="text" class="mt-1 block w-full" placeholder="What changed in this version?" />
                                        <x-input-error :messages="$errors->get('change_summary')" class="mt-2" />
                                    </div>
                                    <div class="sm:col-span-3 flex justify-end">
                                        <x-primary-button>Upload new version</x-primary-button>
                                    </div>
                                </form>
                                <div class="my-6 border-t border-zinc-100"></div>
                            @endif

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-zinc-100">
                                    <thead>
                                        <tr class="text-left text-xs font-semibold uppercase tracking-wider text-zinc-400">
                                            <th class="py-3 pr-4">Version</th>
                                            <th class="py-3 pr-4">Uploaded</th>
                                            <th class="py-3 pr-4">By</th>
                                            <th class="py-3 pr-4">Size</th>
                                            <th class="py-3 pr-4">Notes</th>
                                            <th class="py-3 pr-4"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-100">
                                        @foreach ($document->versions as $v)
                                            <tr class="hover:bg-zinc-50 transition-colors">
                                                <td class="py-3 pr-4 text-sm text-zinc-900">
                                                    <span class="font-semibold">v{{ $v->version_number }}</span>
                                                    @if ($v->is_current)
                                                        <span class="ml-2 inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-700 ring-1 ring-inset ring-brand-200">Current</span>
                                                    @endif
                                                </td>
                                                <td class="py-3 pr-4 text-sm text-zinc-500">{{ $v->created_at->toDayDateTimeString() }}</td>
                                                <td class="py-3 pr-4 text-sm text-zinc-500">{{ $v->uploader?->email ?? '—' }}</td>
                                                <td class="py-3 pr-4 text-sm text-zinc-500">
                                                    @if ($v->size_bytes)
                                                        {{ number_format($v->size_bytes / 1024, 1) }} KB
                                                    @else
                                                        —
                                                    @endif
                                                </td>
                                                <td class="py-3 pr-4 text-sm text-zinc-500">
                                                    <div class="max-w-xs truncate" title="{{ $v->change_summary ?? '' }}">
                                                        {{ $v->change_summary ?: '—' }}
                                                    </div>
                                                </td>
                                                <td class="py-3 pr-4 text-sm text-right">
                                                    @if ($canEdit && ! $v->is_current)
                                                        <form method="POST" action="{{ route('documents.versions.restore', [$document, $v]) }}">
                                                            @csrf
                                                            <x-secondary-button type="submit">
                                                                Restore
                                                            </x-secondary-button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="rounded-xl bg-white border border-zinc-200">
                        <div class="border-b border-zinc-100 px-6 py-4">
                            <div class="text-sm font-semibold text-zinc-900">Rename</div>
                            <div class="mt-1 text-xs text-zinc-400">Update the document title</div>
                        </div>
                        <div class="p-6">
                            @if ($canEdit)
                                <form method="POST" action="{{ route('documents.update', $document) }}">
                                    @csrf
                                    @method('PATCH')
                                    <x-input-label for="title" value="Title" />
                                    <x-text-input id="title" name="title" type="text" value="{{ $document->title }}" class="mt-1 block w-full" required />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                    <div class="mt-4">
                                        <x-primary-button>Save</x-primary-button>
                                    </div>
                                </form>
                            @else
                                <div class="text-sm text-zinc-500">You have view-only access.</div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-xl bg-white border border-zinc-200">
                        <div class="border-b border-zinc-100 px-6 py-4">
                            <div class="text-sm font-semibold text-zinc-900">Sharing</div>
                            <div class="mt-1 text-xs text-zinc-400">Grant view or edit access</div>
                        </div>
                        <div class="p-6">
                            @if ($canEdit)
                                <form method="POST" action="{{ route('documents.shares.store', $document) }}" class="space-y-4">
                                    @csrf
                                    <div>
                                        <x-input-label for="email" value="User email" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-input-label for="permission" value="Permission" />
                                        <select id="permission" name="permission" class="mt-1 block w-full rounded-lg border-zinc-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 text-sm">
                                            <option value="view">View</option>
                                            <option value="edit">Edit</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('permission')" class="mt-2" />
                                    </div>
                                    <div>
                                        <x-primary-button>Share</x-primary-button>
                                    </div>
                                </form>

                                <div class="my-6 border-t border-zinc-100"></div>
                            @endif

                            @if ($document->shares->count() === 0)
                                <div class="text-sm text-zinc-400">Not shared yet.</div>
                            @else
                                <div class="space-y-2">
                                    @foreach ($document->shares as $share)
                                        <div class="flex items-center justify-between gap-3 rounded-lg border border-zinc-200 px-3 py-2">
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-medium text-zinc-900">{{ $share->sharedWith?->email ?? '—' }}</div>
                                                <div class="mt-0.5 text-xs text-zinc-400">
                                                    {{ ucfirst($share->permission) }} • shared by {{ $share->sharedBy?->email ?? '—' }}
                                                </div>
                                            </div>
                                            @if ($canEdit)
                                                <form method="POST" action="{{ route('documents.shares.destroy', [$document, $share]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-xs text-zinc-400 hover:text-red-600 transition-colors">Remove</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
