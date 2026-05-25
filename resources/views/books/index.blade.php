@extends('layouts.app')
@section('title', 'Book Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Books</h3>
        <a href="{{ route('books.create') }}" class="btn btn-primary">+ Add New Book</a>
    </div>

    <div class="search-bar">
        <form method="GET" style="display:flex; gap:10px; align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title or author...">
            <select name="category">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                        {{ $cat->category_name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('books.index') }}" class="btn btn-outline">Clear</a>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th><th>Title</th><th>Author</th><th>Category</th>
                <th>Qty</th><th>Available</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td style="color:#999;">{{ $loop->iteration }}</td>
                <td style="font-weight:500;">{{ $book->title }}</td>
                <td>{{ $book->author->author_name }}</td>
                <td><span class="badge badge-info">{{ $book->category->category_name }}</span></td>
                <td>{{ $book->quantity }}</td>
                <td>
                    @if($book->available_qty > 0)
                        <span class="badge badge-success">{{ $book->available_qty }} available</span>
                    @else
                        <span class="badge badge-danger">Out of stock</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('books.edit', $book->book_id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                    <form method="POST" action="{{ route('books.destroy', $book->book_id) }}" style="display:inline" onsubmit="return confirm('Delete this book?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#999; padding:30px;">No books found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $books->links() }}</div>
</div>
@endsection
