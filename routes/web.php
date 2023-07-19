<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    // 'register' => false, // Registration Routes...
    // 'reset' => false, // Password Reset Routes...
    // 'verify' => false, // Email Verification Routes...
]);

// Route::get('/', [AdminController::class, 'index']);

Route::middleware(['auth', 'isTeacher'])->group(function () {
    Route::get('/dashboard', App\Http\Livewire\Dashboard::class)->name('dashboard');
    Route::view('/admin/profile', 'admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'profileUpdate']);
    //Route Hooks - Do not delete//
    Route::get('answers-list', App\Http\Livewire\AnswersList::class)->middleware('auth');
    Route::get('list-classroom/{student_id}', App\Http\Livewire\Answers\ClassroomList::class)->middleware('auth');
    Route::get('quizDetail/{quiz_id}/{student_id}', App\Http\Livewire\Answers\QuizDetail::class)->middleware('auth');
    Route::get('quizzes', App\Http\Livewire\Quizs::class)->middleware('auth');
    Route::get('question-options', App\Http\Livewire\QuestionOptions::class)->middleware('auth');
    Route::get('questions', App\Http\Livewire\Questions::class)->middleware('auth');
    Route::get('classrooms', App\Http\Livewire\Classrooms::class)->middleware('auth');
    Route::get('students', App\Http\Livewire\StudentList::class)->middleware('auth');

    Route::get('/admin/site_settings', App\Http\Livewire\SiteSettings::class)->middleware('auth');
    Route::get('/admin/users', App\Http\Livewire\Users::class)->middleware('auth');
    Route::get('/admin/roles', App\Http\Livewire\Roles::class)->middleware('auth');
    Route::get('/admin/permissions', App\Http\Livewire\Permissions::class)->middleware('auth');

});

//frontend
Route::get('/', App\Http\Livewire\Home::class);
Route::get('/classroom/list', App\Http\Livewire\ClassroomList::class)->name('classroom.list')->middleware('auth');
Route::get('/classroom/{classroom_id}', App\Http\Livewire\Classroom::class)->name('classroom.show')->middleware('auth');
Route::get('/classroom/{quiz_id}/quiz', App\Http\Livewire\QuizList::class)->name('classroom.quiz')->middleware('auth');
Route::post('/classroom/{quiz_id}/quiz', [App\Http\Livewire\QuizList::class, 'ansStore']);
Route::get('logout', function () {
    auth()->logout();
    return redirect('/');
});
