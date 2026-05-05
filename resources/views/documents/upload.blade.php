<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Upload Document</h2>
                <p class="mt-1 text-sm text-gray-500">Create a new document and start version tracking.</p>
            </div>
            <a href="{{ route('documents.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 rounded-xl bg-white p-6 shadow-md">
            <form id="upload-doc-form" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-5" x-data="{ selectedFile: '' }">
                @csrf
                <div class="flex flex-wrap items-center justify-end gap-3 border-b border-gray-100 pb-4">
                    <a href="{{ route('documents.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                </div>

                <div>
                    <x-input-label for="title" value="Document title" />
                    <x-text-input id="title" name="title" type="text" value="{{ old('title') }}" class="mt-1 block w-full" placeholder="e.g., Project Contract" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="file" value="Select file" />
                    <label for="file" class="mt-1 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 px-6 py-10 text-center hover:border-blue-400 hover:bg-blue-50/40">
                        <span class="text-sm font-medium text-gray-700">Click to browse and upload</span>
                        <span class="mt-1 text-xs text-gray-500">PDF, DOCX, images and more (max 50MB)</span>
                    </label>
                    <input id="file" name="file" type="file" class="mt-3 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 file:mr-3 file:rounded-md file:border-0 file:bg-blue-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100" x-on:change="selectedFile = $event.target.files.length ? $event.target.files[0].name : ''" required />
                    <p class="mt-2 text-xs text-gray-500" x-show="selectedFile" x-text="'Selected file: ' + selectedFile"></p>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="change_summary" value="Change summary (optional)" />
                    <textarea id="change_summary" name="change_summary" rows="4" class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Describe what this document contains...">{{ old('change_summary') }}</textarea>
                    <x-input-error :messages="$errors->get('change_summary')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('documents.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</a>
                    <input type="submit" value="Upload File Now" style="background:#2563eb;color:#fff;padding:10px 16px;border-radius:8px;border:0;font-weight:700;cursor:pointer;" />
                </div>
            </form>
        </div>

        <div class="rounded-xl bg-white p-6 shadow-md">
            <h3 class="text-sm font-semibold text-gray-900">Upload checklist</h3>
            <ul class="mt-4 space-y-3 text-sm text-gray-600">
                <li>- Title should be clear and searchable.</li>
                <li>- First upload automatically creates Version 1.</li>
                <li>- Every new file upload later becomes a new version.</li>
                <li>- You can share with view/edit permissions from document details.</li>
                <li>- Any version can be restored as current.</li>
            </ul>
        </div>
    </div>

</x-app-layout>

