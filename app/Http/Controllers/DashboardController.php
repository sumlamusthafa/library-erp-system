<?php
namespace App\Http\Controllers;

use App\Models\{Book, Member, BorrowTransaction, Category};
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index() {
        $totalBooks    = Book::sum('quantity');
        $totalMembers  = Member::count();
        $activeBorrows = BorrowTransaction::where('status', 'active')->count();
        $overdueCount  = BorrowTransaction::where('status', 'active')
                            ->where('return_date', '<', now())->count();
        $recentBorrows = BorrowTransaction::with(['member', 'book'])
                            ->latest()->take(8)->get();
        $categoryStats = Category::withCount('books')->orderByDesc('books_count')->take(5)->get();

        return view('dashboard', compact(
            'totalBooks','totalMembers','activeBorrows','overdueCount','recentBorrows','categoryStats'
        ));
    }
}
