@extends('layouts.app')
@section('title', 'Member Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Members</h3>
        <a href="{{ route('members.create') }}" class="btn btn-primary">+ Register Member</a>
    </div>

    <div class="search-bar">
        <form method="GET" style="display:flex; gap:10px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email...">
            <button type="submit" class="btn btn-primary">Search</button>
            <a href="{{ route('members.index') }}" class="btn btn-outline">Clear</a>
        </form>
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Member ID</th><th>Name</th><th>Contact</th><th>Email</th><th>Active Loans</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td style="color:#999;">{{ $loop->iteration }}</td>
                <td><span class="badge badge-info">MBR-{{ str_pad($member->member_id, 4, '0', STR_PAD_LEFT) }}</span></td>
                <td style="font-weight:500;">{{ $member->member_name }}</td>
                <td>{{ $member->contact_number }}</td>
                <td>{{ $member->email }}</td>
                <td>
                    @if($member->active_borrows_count > 0)
                        <span class="badge badge-warning">{{ $member->active_borrows_count }} book(s)</span>
                    @else
                        <span class="badge badge-success">None</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('members.show', $member->member_id) }}" class="btn btn-outline btn-sm">👁️ View</a>
                    <a href="{{ route('members.edit', $member->member_id) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
                    <form method="POST" action="{{ route('members.destroy', $member->member_id) }}" style="display:inline" onsubmit="return confirm('Delete this member?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center; color:#999; padding:30px;">No members found</td></tr>
            @endforelse
        </tbody>
    </table>
    <div style="margin-top:16px;">{{ $members->links() }}</div>
</div>
@endsection
