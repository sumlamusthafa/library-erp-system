<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Book, Member, BorrowTransaction};

class BorrowController extends Controller {
    public function index(Request $request) {
        $members       = Member::orderBy('member_name')->get();
        $availableBooks = Book::with('author')->get()->filter(fn($b) => $b->available_qty > 0);
        $activeBorrows = BorrowTransaction::with(['member','book'])->where('status','active')
                            ->orderBy('return_date')->get();

        $transactions = BorrowTransaction::with(['member','book','issuedBy'])
            ->when($request->status === 'active',   fn($q) => $q->where('status','active'))
            ->when($request->status === 'returned', fn($q) => $q->where('status','returned'))
            ->when($request->status === 'overdue',  fn($q) => $q->where('status','active')->where('return_date','<',now()))
            ->latest()->paginate(15);

        return view('borrow.index', compact('members','availableBooks','activeBorrows','transactions'));
    }

    public function store(Request $request) {
        $request->validate([
            'member_id'   => 'required|exists:members,member_id',
            'book_id'     => 'required|exists:books,book_id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after:borrow_date',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->available_qty <= 0) {
            return back()->with('error','This book is not available.');
        }

        BorrowTransaction::create([
            'member_id'   => $request->member_id,
            'book_id'     => $request->book_id,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => 'active',
            'issued_by'   => Auth::id(),
        ]);

        return redirect()->route('borrow.index')->with('success','Book issued successfully!');
    }

    public function returnBook(BorrowTransaction $borrow) {
        $borrow->update(['status' => 'returned']);
        return back()->with('success','Book returned successfully!');
    }
}
