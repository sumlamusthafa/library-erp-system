@extends('layouts.app')
@section('title', 'Borrow & Return')

@section('content')
<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
    <!-- Issue Book -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📤 Issue Book</h3>
        </div>
        <form method="POST" action="{{ route('borrow.store') }}">
            @csrf
            <div class="form-group">
                <label>Select Member *</label>
                <select name="member_id" required>
                    <option value="">-- Choose Member --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->member_id }}" {{ old('member_id') == $member->member_id ? 'selected' : '' }}>
                            {{ $member->member_name }} (MBR-{{ str_pad($member->member_id, 4, '0', STR_PAD_LEFT) }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Select Book *</label>
                <select name="book_id" required>
                    <option value="">-- Choose Book --</option>
                    @foreach($availableBooks as $book)
                        <option value="{{ $book->book_id }}" {{ old('book_id') == $book->book_id ? 'selected' : '' }}>
                            {{ $book->title }} ({{ $book->available_qty }} available)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label>Borrow Date *</label>
                    <input type="date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                </div>
                <div class="form-group">
                    <label>Return Date *</label>
                    <input type="date" name="return_date" value="{{ old('return_date', date('Y-m-d', strtotime('+14 days'))) }}" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">📤 Issue Book</button>
        </form>
    </div>

    <!-- Return Book -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">📥 Return Book</h3>
        </div>
        @if($activeBorrows->count() > 0)
        <table>
            <thead>
                <tr><th>Member</th><th>Book</th><th>Due</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($activeBorrows->take(6) as $borrow)
                <tr>
                    <td style="font-size:13px;">{{ $borrow->member->member_name }}</td>
                    <td style="font-size:13px;">{{ Str::limit($borrow->book->title, 25) }}</td>
                    <td>
                        @if(\Carbon\Carbon::parse($borrow->return_date)->isPast())
                            <span class="badge badge-danger">{{ \Carbon\Carbon::parse($borrow->return_date)->diffForHumans() }}</span>
                        @else
                            <span style="font-size:12px;">{{ \Carbon\Carbon::parse($borrow->return_date)->format('d M') }}</span>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('borrow.return', $borrow->borrow_id) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-gold btn-sm">Return</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color:#999; text-align:center; padding:30px;">No active borrows</p>
        @endif
    </div>
</div>

<!-- All Transactions -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Transactions</h3>
        <div style="display:flex; gap:10px;">
            <form method="GET" style="display:flex; gap:8px;">
                <select name="status" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
                    <option value="returned" {{ request('status')=='returned' ? 'selected' : '' }}>Returned</option>
                    <option value="overdue" {{ request('status')=='overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
            </form>
        </div>
    </div>
    <table>
        <thead>
            <tr><th>ID</th><th>Member</th><th>Book</th><th>Borrowed</th><th>Due Date</th><th>Status</th><th>Processed By</th></tr>
        </thead>
        <tbody>
            @forelse($transactions as $t)
            <tr>
                <td style="color:#999; font-size:12px;">#{{ $t->borrow_id }}</td>
                <td>{{ $t->member->member_name }}</td>
                <td>{{ $t->book->title }}</td>
                <td>{{ \Carbon\Carbon::parse($t->borrow_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($t->return_date)->format('d M Y') }}</td>
                <td>
                    @if($t->status==='returned')
                        <span class="badge badge-success">Returned</span>
                    @elseif(\Carbon\Carbon::parse($t->return_date)->isPast())
                        <span class="badge badge-danger">Overdue</span>
                    @else
                        <span class="badge badge-warning">Active</span>
                    @endif
                </td>
                <td style="font-size:12px; color:#999;">{{ $t->issuedBy->username ?? 'System' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#999; padding:30px;">No transactions</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $transactions->links() }}</div>
</div>
@endsection
