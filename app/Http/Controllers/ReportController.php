<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Book, Member, BorrowTransaction, Author, Category};

class ReportController extends Controller {
    public function index(Request $request) {
        $month = $request->month ?? date('n');
        $year  = $request->year  ?? date('Y');

        $stats = [
            'total_books'        => Book::sum('quantity'),
            'total_members'      => Member::count(),
            'total_transactions' => BorrowTransaction::count(),
        ];

        $mostBorrowedBooks = Book::withCount('borrowTransactions as borrow_count')
            ->orderByDesc('borrow_count')->take(8)->get();

        $activeMembers = Member::withCount('borrowTransactions as borrow_count')
            ->orderByDesc('borrow_count')->take(8)->get();

        $overdueBooks = BorrowTransaction::with(['member','book'])
            ->where('status','active')->where('return_date','<',now())->get();

        $monthlyReport = BorrowTransaction::with(['member','book'])
            ->whereMonth('borrow_date', $month)->whereYear('borrow_date', $year)->get();

        return view('reports.index', compact('stats','mostBorrowedBooks','activeMembers','overdueBooks','monthlyReport'));
    }
}

// ============================================================
// AuthorController (quick-add)
// ============================================================
class AuthorController extends Controller {
    public function store(Request $request) {
        $request->validate(['author_name' => 'required|max:255']);
        Author::create($request->only('author_name'));
        return back()->with('success','Author added!');
    }
}

// ============================================================
// CategoryController (quick-add)
// ============================================================
class CategoryController extends Controller {
    public function store(Request $request) {
        $request->validate(['category_name' => 'required|max:255']);
        Category::create($request->only('category_name'));
        return back()->with('success','Category added!');
    }
}
