<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Book, Author, Category};

class BookController extends Controller {
    public function index(Request $request) {
        $query = Book::with(['author','category']);
        if ($request->search) {
            $query->where('title','like',"%{$request->search}%")
                  ->orWhereHas('author', fn($q) => $q->where('author_name','like',"%{$request->search}%"));
        }
        if ($request->category) $query->where('category_id', $request->category);
        $books = $query->paginate(15);
        $categories = Category::all();
        return view('books.index', compact('books','categories'));
    }

    public function create() {
        $authors    = Author::orderBy('author_name')->get();
        $categories = Category::orderBy('category_name')->get();
        return view('books.form', compact('authors','categories'));
    }

    public function store(Request $request) {
        $request->validate([
            'title'       => 'required|max:255',
            'author_id'   => 'required|exists:authors,author_id',
            'category_id' => 'required|exists:categories,category_id',
            'quantity'    => 'required|integer|min:1',
        ]);
        Book::create($request->only('title','author_id','category_id','isbn','quantity'));
        return redirect()->route('books.index')->with('success','Book added successfully!');
    }

    public function edit(Book $book) {
        $authors    = Author::orderBy('author_name')->get();
        $categories = Category::orderBy('category_name')->get();
        return view('books.form', compact('book','authors','categories'));
    }

    public function update(Request $request, Book $book) {
        $request->validate([
            'title'       => 'required|max:255',
            'author_id'   => 'required|exists:authors,author_id',
            'category_id' => 'required|exists:categories,category_id',
            'quantity'    => 'required|integer|min:1',
        ]);
        $book->update($request->only('title','author_id','category_id','isbn','quantity'));
        return redirect()->route('books.index')->with('success','Book updated successfully!');
    }

    public function destroy(Book $book) {
        if ($book->borrowTransactions()->where('status','active')->exists()) {
            return back()->with('error','Cannot delete: book is currently borrowed.');
        }
        $book->delete();
        return redirect()->route('books.index')->with('success','Book deleted.');
    }
}
