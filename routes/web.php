<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, DashboardController, BookController,
    MemberController, BorrowController, ReportController,
    AuthorController, CategoryController
};

// Auth
Route::get('/',      [AuthController::class, 'showLogin'])->name('login');
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/',     [AuthController::class, 'login']);
Route::post('/login',[AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Books
    Route::resource('books', BookController::class)->parameters(['books' => 'book:book_id']);

    // Members
    Route::resource('members', MemberController::class)->parameters(['members' => 'member:member_id']);

    // Borrow & Return
    Route::get('/borrow',          [BorrowController::class, 'index'])->name('borrow.index');
    Route::post('/borrow',         [BorrowController::class, 'store'])->name('borrow.store');
    Route::get('/borrow/create',   fn() => redirect()->route('borrow.index'))->name('borrow.create');
    Route::patch('/borrow/{borrow}/return', [BorrowController::class, 'returnBook'])
         ->name('borrow.return')->whereNumber('borrow');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Quick-add helpers
    Route::post('/authors',    [AuthorController::class, 'store'])->name('authors.store');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});
