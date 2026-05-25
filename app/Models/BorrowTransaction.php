<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BorrowTransaction extends Model {
    protected $primaryKey = 'borrow_id';
    protected $fillable = ['member_id', 'book_id', 'borrow_date', 'return_date', 'status', 'issued_by'];

    public function member() { return $this->belongsTo(Member::class, 'member_id', 'member_id'); }
    public function book() { return $this->belongsTo(Book::class, 'book_id', 'book_id'); }
    public function issuedBy() { return $this->belongsTo(User::class, 'issued_by', 'user_id'); }
}
