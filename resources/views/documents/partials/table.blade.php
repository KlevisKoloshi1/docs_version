@php
    $paginator = $items;
    $rows = $items->items();
@endphp

@if (count($rows) === 0)
    <div class="rounded-lg border border-dashed border-zinc-200 p-6 text-sm text-zinc-400">
        {{ $emptyText ?? 'No items.' }}
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-zinc-100">
            <thead>
                <tr class="text-left text-xs font-semibold uppercase tracking-wider text-zinc-400">
                    <th class="py-3 pr-4">Name</th>
                    <th class="py-3 pr-4">Current</th>
                    <th class="py-3 pr-4">Size</th>
                    <th class="py-3 pr-4">Updated</th>
                    <th class="py-3 pr-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-100">
                @foreach ($rows as $doc)
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="py-3 pr-4">
                            <a href="{{ route('documents.show', $doc) }}" class="font-medium text-zinc-900 hover:text-brand-600 transition-colors">
                                {{ $doc->title }}
                            </a>
                            @if ($doc->relationLoaded('owner') && $doc->owner)
                                <div class="mt-0.5 text-xs text-zinc-400">{{ $doc->owner->email }}</div>
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-zinc-500">
                            @if ($doc->currentVersion)
                                <span class="inline-flex items-center rounded-md bg-zinc-100 px-2 py-0.5 text-xs font-medium text-zinc-600">v{{ $doc->currentVersion->version_number }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-zinc-500">
                            @if ($doc->currentVersion?->size_bytes)
                                {{ number_format($doc->currentVersion->size_bytes / 1024, 1) }} KB
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-zinc-500">
                            {{ $doc->updated_at?->diffForHumans() }}
                        </td>
                        <td class="py-3 pr-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('documents.show', $doc) }}" class="rounded-md border border-zinc-200 px-2.5 py-1.5 text-xs font-medium text-zinc-700 hover:bg-zinc-50 transition-colors">
                                    View
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="rounded-md bg-brand-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-brand-700 transition-colors">
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $paginator->links() }}
    </div>
@endif
