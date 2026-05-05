@php
    $paginator = $items;
    $rows = $items->items();
@endphp

@if (count($rows) === 0)
    <div class="rounded-md border border-dashed border-gray-200 p-6 text-sm text-gray-600">
        {{ $emptyText ?? 'No items.' }}
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                    <th class="py-3 pr-4">Name</th>
                    <th class="py-3 pr-4">Current</th>
                    <th class="py-3 pr-4">Size</th>
                    <th class="py-3 pr-4">Updated</th>
                    <th class="py-3 pr-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($rows as $doc)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 pr-4">
                            <a href="{{ route('documents.show', $doc) }}" class="font-medium text-gray-900 hover:text-blue-700">
                                {{ $doc->title }}
                            </a>
                            @if ($doc->relationLoaded('owner') && $doc->owner)
                                <div class="mt-1 text-xs text-gray-500">Owner: {{ $doc->owner->email }}</div>
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-gray-700">
                            @if ($doc->currentVersion)
                                v{{ $doc->currentVersion->version_number }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-gray-700">
                            @if ($doc->currentVersion?->size_bytes)
                                {{ number_format($doc->currentVersion->size_bytes / 1024, 1) }} KB
                            @else
                                —
                            @endif
                        </td>
                        <td class="py-3 pr-4 text-sm text-gray-700">
                            {{ $doc->updated_at?->diffForHumans() }}
                        </td>
                        <td class="py-3 pr-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('documents.show', $doc) }}" class="rounded-md border border-gray-200 px-2.5 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-100">
                                    View
                                </a>
                                <a href="{{ route('documents.download', $doc) }}" class="rounded-md bg-blue-500 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-blue-600">
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

