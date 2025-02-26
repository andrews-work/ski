<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Meetings;
use App\Http\Controllers\Calendar;
use App\Http\Controllers\ForumPostController;
use App\Http\Controllers\ForumCommentController;
use App\Http\Controllers\ForumCategoryController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/pricing', function () {
    return Inertia::render('Pricing');
})->name('pricing');

Route::get('/features', function () {
    return Inertia::render('Features');
})->name('features');

Route::get('/news', function () {
    return Inertia::render('News');
})->name('news');

Route::get('/support', function () {
    return Inertia::render('Support');
})->name('support');

// auth routes
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Auth/Dashboard');
    })->name('dashboard');

    Route::get('/news-feeds', function () {
        return Inertia::render('Auth/NewsFeeds');
    })->name('news-feeds');

    Route::get('/marketplace', function () {
        return Inertia::render('Auth/Marketplace');
    })->name('marketplace');

    Route::get('/resorts', function () {
        return Inertia::render('Auth/Resorts');
    })->name('resorts');

    // meetings page
    Route::get('/meetings', [
        Meetings::class, 'index'
    ])->name('meetings.index');

            // create
            Route::post('/meetings', [
                Meetings::class, 'create'
            ])->name('meetings.create');

            // update
            Route::put('/meetings/{meetingId}', [
                Meetings::class, 'update'
            ])->name('meetings.update');

            // delete
            Route::delete('/meetings/{meetingId}', [
                Meetings::class, 'delete'
            ])->name('meetings.delete');

    Route::get('/calendar', function () {
        return Inertia::render('Auth/Calendar');
    })->name('calendar.index');

            // daily
            Route::get('/calendar/daily', [Calendar::class, 'daily'])->name('calendar.daily');

            // weekly
            Route::get('/calendar/weekly', [Calendar::class, 'weekly'])->name('calendar.weekly');

            // monthly
            Route::get('/calendar/monthly', [Calendar::class, 'monthly'])->name('calendar.monthly');

    // basic forum page
    Route::get('/forums', [ForumPostController::class, 'index'])->name('forums');
    Route::post('/forums', [ForumPostController::class, 'store'])->name('forums.store');
    Route::get('/forums/{post}', [ForumPostController::class, 'show'])->name('forums.show');
    Route::put('/forums/{post}', [ForumPostController::class, 'update'])->name('forums.update');
    Route::delete('/forums/{post}', [ForumPostController::class, 'destroy'])->name('forums.destroy');
    Route::post('/posts/{post}/comments', [ForumCommentController::class, 'store']);
    Route::put('/comments/{comment}', [ForumCommentController::class, 'update']);
    Route::delete('/comments/{comment}', [ForumCommentController::class, 'destroy']);
    Route::get('/forum-categories', [ForumCategoryController::class, 'index']);
    Route::get('/forums/categories/{category}', [ForumCategoryController::class, 'show'])->name('forum-categories.show');




    Route::get('/timesheets', function () {
        return Inertia::render('Auth/Timesheets');
    })->name('timesheets');

    Route::get('/accounts', function () {
        return Inertia::render('Auth/Accounts');
    })->name('accounts');

    Route::get('/reports', function () {
        return Inertia::render('Auth/Reports');
    })->name('reports');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
