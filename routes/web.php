<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('apprenant.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('formations', \App\Http\Controllers\FormationController::class);
    Route::resource('apprenants', \App\Http\Controllers\ApprenantController::class);
    
    // Inscription des apprenants aux formations (Many-to-Many)
    Route::post('formations/{formation}/enroll', [\App\Http\Controllers\FormationEnrollmentController::class, 'enroll'])->name('formations.enroll');
    Route::delete('formations/{formation}/unenroll/{apprenant}', [\App\Http\Controllers\FormationEnrollmentController::class, 'unenroll'])->name('formations.unenroll');
    
    // Inscriptions côté Apprenant (Miroir)
    Route::post('apprenants/{apprenant}/enroll', [\App\Http\Controllers\ApprenantEnrollmentController::class, 'enroll'])->name('apprenants.enroll');
    Route::delete('apprenants/{apprenant}/unenroll/{formation}', [\App\Http\Controllers\ApprenantEnrollmentController::class, 'unenroll'])->name('apprenants.unenroll');


    Route::resource('formations.chapitres', \App\Http\Controllers\ChapitreController::class)->shallow();
    Route::resource('chapitres.sous_chapitres', \App\Http\Controllers\SousChapitreController::class)->shallow();
    Route::resource('sous_chapitres.contenus', \App\Http\Controllers\ContenuController::class)->shallow();
    Route::post('sous_chapitres/{sous_chapitre}/contenus/import', [\App\Http\Controllers\ContenuController::class, 'importStore'])
         ->name('sous_chapitres.contenus.import');
    Route::resource('sous_chapitres.quizzes', \App\Http\Controllers\QuizController::class)->shallow();
    Route::resource('quizzes.questions', \App\Http\Controllers\QuestionController::class)->shallow();
    Route::resource('notes', \App\Http\Controllers\NoteController::class);
    Route::get('assistant-ia', [\App\Http\Controllers\AssistantIAController::class, 'index'])->name('assistant.ia');
    Route::post('assistant-ia/generate', [\App\Http\Controllers\AssistantIAController::class, 'generate'])->name('assistant.ia.generate');
    Route::post('assistant-ia/create', [\App\Http\Controllers\AssistantIAController::class, 'create'])->name('assistant.ia.create');
});

// ──── Espace Apprenant ────────────────────────────────────────────────────
Route::middleware(['auth', 'apprenant'])->prefix('apprenant')->name('apprenant.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Apprenant\DashboardController::class, 'index'])->name('dashboard');
    
    // Parcours de cours avec support multi-formations
    Route::get('/formations/{formation}/chapitres', [\App\Http\Controllers\Apprenant\CoursController::class, 'chapitres'])->name('cours.chapitres');
    Route::get('/chapitres/{chapitre}/sous-chapitres', [\App\Http\Controllers\Apprenant\CoursController::class, 'sousChapitres'])->name('cours.sous_chapitres');
    Route::get('/sous-chapitres/{sous_chapitre}/contenus', [\App\Http\Controllers\Apprenant\CoursController::class, 'contenus'])->name('cours.contenus');
    
    Route::get('/quiz/{quiz}', [\App\Http\Controllers\Apprenant\QuizPassageController::class, 'show'])->name('quiz.show');
    Route::post('/quiz/{quiz}/submit', [\App\Http\Controllers\Apprenant\QuizPassageController::class, 'submit'])->name('quiz.submit');
    Route::get('/mes-resultats', [\App\Http\Controllers\Apprenant\ResultatsController::class, 'index'])->name('resultats');
});

require __DIR__.'/auth.php';
