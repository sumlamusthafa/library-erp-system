<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller {
    public function index(Request $request) {
        $members = Member::withCount(['borrowTransactions as active_borrows_count' => fn($q) => $q->where('status','active')])
            ->when($request->search, fn($q) => $q->where('member_name','like',"%{$request->search}%")
                ->orWhere('email','like',"%{$request->search}%"))
            ->paginate(15);
        return view('members.index', compact('members'));
    }

    public function create() { return view('members.form'); }

    public function store(Request $request) {
        $request->validate([
            'member_name'    => 'required|max:255',
            'contact_number' => 'required|max:20',
            'email'          => 'nullable|email|unique:members,email',
        ]);
        Member::create($request->only('member_name','contact_number','email'));
        return redirect()->route('members.index')->with('success','Member registered!');
    }

    public function show(Member $member) {
        $member->load('borrowTransactions.book');
        return view('members.form', compact('member'));
    }

    public function edit(Member $member) {
        $member->load('borrowTransactions.book');
        return view('members.form', compact('member'));
    }

    public function update(Request $request, Member $member) {
        $request->validate([
            'member_name'    => 'required|max:255',
            'contact_number' => 'required|max:20',
            'email'          => 'nullable|email|unique:members,email,'.$member->member_id.',member_id',
        ]);
        $member->update($request->only('member_name','contact_number','email'));
        return redirect()->route('members.index')->with('success','Member updated!');
    }

    public function destroy(Member $member) {
        if ($member->borrowTransactions()->where('status','active')->exists()) {
            return back()->with('error','Cannot delete: member has active borrows.');
        }
        $member->delete();
        return redirect()->route('members.index')->with('success','Member removed.');
    }
}
