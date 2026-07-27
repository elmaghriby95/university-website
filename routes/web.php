<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\FacultyController as AdminFacultyController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ResultController as AdminResultController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/admissions', [HomeController::class, 'admissions'])->name('admissions');
Route::get('/faculties', [HomeController::class, 'faculties'])->name('faculties.index');
Route::get('/faculties/{faculty}', [HomeController::class, 'faculty'])->name('faculties.show');
Route::get('/news', [HomeController::class, 'news'])->name('news.index');
Route::get('/news/{news}', [HomeController::class, 'newsShow'])->name('news.show');
Route::get('/events', [HomeController::class, 'events'])->name('events.index');
Route::get('/events/{event}', [HomeController::class, 'eventShow'])->name('events.show');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactStore'])->name('contact.store');
Route::get('/pages/{page}', [HomeController::class, 'page'])->name('pages.show');

Route::get('/students/register', [StudentController::class, 'registerForm'])->name('students.register');
Route::post('/students/register', [StudentController::class, 'register'])->name('students.register.store');
Route::get('/students/register/success', [StudentController::class, 'registerSuccess'])->name('students.register.success');
Route::get('/results', [StudentController::class, 'resultsForm'])->name('results.lookup');
Route::post('/results', [StudentController::class, 'resultsLookup'])->name('results.lookup.submit');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('news', AdminNewsController::class)->except(['show']);
        Route::resource('events', AdminEventController::class)->except(['show']);
        Route::resource('faculties', AdminFacultyController::class)->except(['show']);
        Route::resource('sliders', SliderController::class)->except(['show']);
        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::resource('students', AdminStudentController::class)->except(['show']);
        Route::post('students/{student}/reset-secret', [AdminStudentController::class, 'resetSecret'])->name('students.reset-secret');
        Route::resource('results', AdminResultController::class)->except(['show']);

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
