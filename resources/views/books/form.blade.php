@extends('layouts.app')
@section('title', isset($book) ? 'Edit Book' : 'Add New Book')

@section('content')
<div class="card" style="max-width:700px;">
    <div class="card-header">
        <h3 class="card-title">{{ isset($book) ? 'Edit Book' : 'Add New Book' }}</h3>
        <a href="{{ route('books.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <form method="POST" action="{{ isset($book) ? route('books.update', $book->book_id) : route('books.store') }}">
        @csrf
        @if(isset($book)) @method('PUT') @endif

        <div class="form-grid">
            <div class="form-group" style="grid-column:1/-1;">
                <label>Book Title *</label>
                <input type="text" name="title" value="{{ old('title', $book->title ?? '') }}" required placeholder="Enter book title">
                @error('title')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Author *</label>
                <select name="author_id" required>
                    <option value="">-- Select Author --</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->author_id }}" {{ old('author_id', $book->author_id ?? '') == $author->author_id ? 'selected' : '' }}>
                            {{ $author->author_name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category_id" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->category_id }}" {{ old('category_id', $book->category_id ?? '') == $cat->category_id ? 'selected' : '' }}>
                            {{ $cat->category_name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>ISBN</label>
                <input type="text" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" placeholder="e.g. 978-3-16-148410-0">
            </div>
            <div class="form-group">
                <label>Quantity *</label>
                <input type="number" name="quantity" value="{{ old('quantity', $book->quantity ?? 1) }}" min="1" required>
                @error('quantity')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn btn-primary">
                {{ isset($book) ? '✅ Update Book' : '+ Add Book' }}
            </button>
            <a href="{{ route('books.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>

    <div style="margin-top:28px; padding-top:20px; border-top:1px solid #f0ebe2;">
        <p style="font-size:12px; color:#999; margin-bottom:12px;">QUICK ADD</p>
        <div style="display:flex; gap:10px; flex-wrap:wrap;">
            <div style="flex:1; min-width:200px;">
                <p style="font-size:12px; font-weight:600; margin-bottom:6px;">New Author</p>
                <form method="POST" action="{{ route('authors.store') }}" style="display:flex; gap:8px;">
                    @csrf
                    <input type="text" name="author_name" placeholder="Author name" style="flex:1;">
                    <button type="submit" class="btn btn-gold btn-sm">Add</button>
                </form>
            </div>
            <div style="flex:1; min-width:200px;">
                <p style="font-size:12px; font-weight:600; margin-bottom:6px;">New Category</p>
                <form method="POST" action="{{ route('categories.store') }}" style="display:flex; gap:8px;">
                    @csrf
                    <input type="text" name="category_name" placeholder="Category name" style="flex:1;">
                    <button type="submit" class="btn btn-gold btn-sm">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
