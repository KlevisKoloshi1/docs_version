<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentShareController;
use App\Http\Controllers\DocumentVersionController;
use App\Models\Document;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    $totalDocuments = Document::where('user_id', $user->id)->count();
    $storageUsedBytes = Document::query()
        ->where('user_id', $user->id)
        ->join('document_versions', 'documents.current_version_id', '=', 'document_versions.id')
        ->sum('document_versions.size_bytes');
    $sharedFiles = $user->sharedDocuments()->count();

    $recentDocuments = Document::query()
        ->where('user_id', $user->id)
        ->with(['owner', 'currentVersion'])
        ->latest('updated_at')
        ->take(8)
        ->get();

    return view('dashboard', [
        'totalDocuments' => $totalDocuments,
        'storageUsedBytes' => (int) $storageUsedBytes,
        'sharedFiles' => $sharedFiles,
        'recentDocuments' => $recentDocuments,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::patch('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::post('/documents/{document}/versions', [DocumentVersionController::class, 'store'])->name('documents.versions.store');
    Route::post('/documents/{document}/versions/{version}/restore', [DocumentVersionController::class, 'restore'])->name('documents.versions.restore');

    Route::post('/documents/{document}/shares', [DocumentShareController::class, 'store'])->name('documents.shares.store');
    Route::delete('/documents/{document}/shares/{share}', [DocumentShareController::class, 'destroy'])->name('documents.shares.destroy');
});

require __DIR__.'/auth.php';
