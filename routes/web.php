<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Logout;
use App\Livewire\Profile;
use App\Livewire\Dashboard;
use App\Livewire\ManageClubs;
use App\Livewire\ManageSocialLinks;
use App\Livewire\ManageClubs\ManageClubForm;
use App\Livewire\ManageSocialLinks\ManageSocialLinksForm;
use App\Livewire\ManageUploads;
use App\Livewire\ManageUploads\ManageUploadsForm;
use App\Livewire\DocumentUploads; 
use App\Livewire\DocumentUploads\DocumentUploadsForm; 
use App\Livewire\Athlete;
use App\Livewire\Athlete\AthleteForm;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');
Route::get('/logout', Logout::class)->name('logout');

// Protected Routes (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', Profile::class)->name('profile');
    Route::post('/profile/update', [Profile::class, 'updateProfile'])->name('profile.update');


    Route::get('/manage-clubs', ManageClubs::class)->name('clubs');
    Route::get('/manage-clubs-data', [ManageClubs::class, 'getClubData'])->name('clubs.data');
    Route::get('/clubs/create', ManageClubForm::class)->name('clubs.create');
    Route::get('/clubs/{id}/edit', ManageClubForm::class)->name('clubs.edit');

    Route::get('/social-links', ManageSocialLinks::class)->name('social-links');
    Route::get('/social-links-data', [ManageSocialLinks::class, 'getLinksData'])->name('social-links.data');
    Route::get('/social-links/create', ManageSocialLinksForm::class)->name('social-links.create');
    // Route::post('/social-links/store', [ManageSocialLinks::class, 'store'])->name('social-links.store');
    Route::get('/social-links/{id}/edit',ManageSocialLinksForm::class)->name('social-links.edit');
    // Route::post('/social-links/update/{id}', [ManageSocialLinks::class, 'update'])->name('social-links.update');
    // Route::delete('/social-links/delete/{id}', [ManageSocialLinks::class, 'destroy'])->name('social-links.destroy');

    Route::get('/manage-uploads', ManageUploads::class)->name('uploads');
    Route::get('/manage-uploads-data', [ManageUploads::class, 'getUploadsData'])->name('uploads.data');
    Route::get('/uploads/create', ManageUploadsForm::class)->name('uploads.create');
    Route::get('/uploads/{id}/edit', ManageUploadsForm::class)->name('uploads.edit');

    Route::get('/document-uploads', DocumentUploads::class)->name('document.uploads');  
    Route::get('/document-uploads/create', DocumentUploadsForm::class)->name('document-uploads.create');
    Route::get('/document-uploads/data', [DocumentUploads::class, 'getDocumentsData'])->name('document-uploads.data');

    Route::get('/athletes', Athlete::class)->name('athlete');
    Route::get('/athletes/create', AthleteForm::class)->name('athlete.create');
    Route::get('/athletes/data', [AthleteForm::class, 'getAthletesData'])->name('athlete.data');
    Route::get('/athletes/{id}/edit', AthleteForm::class)->name('athlete.edit');

});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
