<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Member extends Model {
    protected $primaryKey = 'member_id';
    protected $fillable = ['member_name', 'contact_number', 'email'];
    public function borrowTransactions() { return $this->hasMany(BorrowTransaction::class, 'member_id', 'member_id'); }
    public function getActiveBorrowsCountAttribute() {
        return $this->borrowTransactions()->where('status', 'active')->count();
    }
}
