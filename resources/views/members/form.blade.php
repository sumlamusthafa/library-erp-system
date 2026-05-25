@extends('layouts.app')
@section('title', isset($member) ? 'Edit Member' : 'Register Member')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-header">
        <h3 class="card-title">{{ isset($member) ? 'Edit Member' : 'Register New Member' }}</h3>
        <a href="{{ route('members.index') }}" class="btn btn-outline">← Back</a>
    </div>

    <form method="POST" action="{{ isset($member) ? route('members.update', $member->member_id) : route('members.store') }}">
        @csrf
        @if(isset($member)) @method('PUT') @endif

        <div class="form-group">
            <label>Full Name *</label>
            <input type="text" name="member_name" value="{{ old('member_name', $member->member_name ?? '') }}" required placeholder="Enter full name">
            @error('member_name')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
        </div>
        <div class="form-grid">
            <div class="form-group">
                <label>Contact Number *</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $member->contact_number ?? '') }}" required placeholder="07X XXX XXXX">
                @error('contact_number')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}" placeholder="email@example.com">
                @error('email')<span style="color:#c0392b; font-size:12px;">{{ $message }}</span>@enderror
            </div>
        </div>

        <div style="display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">
                {{ isset($member) ? '✅ Update Member' : '+ Register Member' }}
            </button>
            <a href="{{ route('members.index') }}" class="btn btn-outline">Cancel</a>
        </div>
    </form>
</div>

@if(isset($member))
<div class="card" style="max-width:600px; margin-top:20px;">
    <div class="card-header">
        <h3 class="card-title">Borrow History</h3>
    </div>
    <table>
        <thead>
            <tr><th>Book</th><th>Borrowed</th><th>Return Date</th><th>Status</th></tr>
        </thead>
        <tbody>
            @forelse($member->borrowTransactions as $t)
            <tr>
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
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center; color:#999; padding:20px;">No borrow history</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif
@endsection
