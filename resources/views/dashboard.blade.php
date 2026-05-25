@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card books">
        <div class="stat-num">{{ $totalBooks }}</div>
        <div class="stat-label">Total Books</div>
        <div class="stat-icon">📚</div>
    </div>
    <div class="stat-card members">
        <div class="stat-num">{{ $totalMembers }}</div>
        <div class="stat-label">Members</div>
        <div class="stat-icon">👥</div>
    </div>
    <div class="stat-card borrowed">
        <div class="stat-num">{{ $activeBorrows }}</div>
        <div class="stat-label">Active Borrows</div>
        <div class="stat-icon">🔄</div>
    </div>
    <div class="stat-card overdue">
        <div class="stat-num">{{ $overdueCount }}</div>
        <div class="stat-label">Overdue</div>
        <div class="stat-icon">⚠️</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:2fr 1fr; gap:20px;">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Recent Borrow Transactions</h3>
            <a href="{{ route('borrow.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Member</th><th>Book</th><th>Borrowed</th><th>Due</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->member->member_name }}</td>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->borrow_date)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->return_date)->format('d M Y') }}</td>
                    <td>
                        @if($borrow->status === 'returned')
                            <span class="badge badge-success">Returned</span>
                        @elseif(\Carbon\Carbon::parse($borrow->return_date)->isPast())
                            <span class="badge badge-danger">Overdue</span>
                        @else
                            <span class="badge badge-warning">Active</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center; color:#999; padding:20px;">No transactions yet</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
        </div>
        <div style="display:flex; flex-direction:column; gap:10px;">
            <a href="{{ route('books.create') }}" class="btn btn-primary">📖 Add New Book</a>
            <a href="{{ route('members.create') }}" class="btn btn-gold">👤 Register Member</a>
            <a href="{{ route('borrow.create') }}" class="btn btn-outline">🔄 Issue Book</a>
            <a href="{{ route('reports.index') }}" class="btn btn-outline">📊 View Reports</a>
        </div>

        <div style="margin-top:24px; padding-top:20px; border-top:1px solid #f0ebe2;">
            <h4 style="font-size:13px; color:#6b7a8d; margin-bottom:12px; text-transform:uppercase; letter-spacing:1px;">Book Categories</h4>
            @foreach($categoryStats as $cat)
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                <span style="font-size:13px;">{{ $cat->category_name }}</span>
                <span style="font-size:13px; font-weight:600; color:#0d2137;">{{ $cat->books_count }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
