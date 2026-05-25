@extends('layouts.app')
@section('title', 'Reports')

@section('content')
<!-- Summary Stats -->
<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);">
    <div class="stat-card books">
        <div class="stat-num">{{ $stats['total_books'] }}</div>
        <div class="stat-label">Total Books</div>
        <div class="stat-icon">📚</div>
    </div>
    <div class="stat-card members">
        <div class="stat-num">{{ $stats['total_members'] }}</div>
        <div class="stat-label">Registered Members</div>
        <div class="stat-icon">👥</div>
    </div>
    <div class="stat-card borrowed">
        <div class="stat-num">{{ $stats['total_transactions'] }}</div>
        <div class="stat-label">Total Transactions</div>
        <div class="stat-icon">🔄</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
    <!-- Most Borrowed Books -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📖 Most Borrowed Books</h3>
        </div>
        <table>
            <thead><tr><th>Book Title</th><th>Times Borrowed</th></tr></thead>
            <tbody>
                @forelse($mostBorrowedBooks as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>
                        <span class="badge badge-info">{{ $book->borrow_count }}x</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center; color:#999; padding:20px;">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Active Members -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">👥 Most Active Members</h3>
        </div>
        <table>
            <thead><tr><th>Member</th><th>Total Borrows</th></tr></thead>
            <tbody>
                @forelse($activeMembers as $member)
                <tr>
                    <td>{{ $member->member_name }}</td>
                    <td><span class="badge badge-info">{{ $member->borrow_count }}x</span></td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center; color:#999; padding:20px;">No data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Overdue Books -->
<div class="card" style="margin-bottom:20px;">
    <div class="card-header">
        <h3 class="card-title">⚠️ Overdue Books</h3>
        <span class="badge badge-danger">{{ $overdueBooks->count() }} overdue</span>
    </div>
    <table>
        <thead>
            <tr><th>Member</th><th>Contact</th><th>Book</th><th>Due Date</th><th>Days Overdue</th></tr>
        </thead>
        <tbody>
            @forelse($overdueBooks as $t)
            <tr>
                <td style="font-weight:500;">{{ $t->member->member_name }}</td>
                <td>{{ $t->member->contact_number }}</td>
                <td>{{ $t->book->title }}</td>
                <td style="color:#c0392b;">{{ \Carbon\Carbon::parse($t->return_date)->format('d M Y') }}</td>
                <td><span class="badge badge-danger">{{ \Carbon\Carbon::parse($t->return_date)->diffInDays() }} days</span></td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; color:#1a7a4a; padding:20px;">✅ No overdue books!</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Monthly Report Filter -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">📊 Monthly Transaction Report</h3>
        <form method="GET" style="display:flex; gap:10px; align-items:center;">
            <select name="month">
                @for($m=1; $m<=12; $m++)
                    <option value="{{ $m }}" {{ request('month', date('n')) == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0,0,0,$m,1)) }}
                    </option>
                @endfor
            </select>
            <select name="year">
                @for($y=date('Y'); $y>=date('Y')-3; $y--)
                    <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary">Generate</button>
        </form>
    </div>
    <table>
        <thead>
            <tr><th>Date</th><th>Member</th><th>Book</th><th>Action</th></tr>
        </thead>
        <tbody>
            @forelse($monthlyReport as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->borrow_date)->format('d M Y') }}</td>
                <td>{{ $t->member->member_name }}</td>
                <td>{{ $t->book->title }}</td>
                <td>
                    @if($t->status==='returned')
                        <span class="badge badge-success">Returned</span>
                    @else
                        <span class="badge badge-warning">Borrowed</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#999; padding:20px;">No transactions this month</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:12px; font-size:13px; color:#999;">
        Total: {{ $monthlyReport->count() }} transactions in {{ date('F', mktime(0,0,0,request('month',date('n')),1)) }} {{ request('year', date('Y')) }}
    </div>
</div>
@endsection
