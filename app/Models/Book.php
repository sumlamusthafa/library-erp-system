<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Book extends Model {
    protected $primaryKey = 'book_id';
    protected $fillable = ['title', 'author_id', 'category_id', 'isbn', 'quantity'];

    public function author() { return $this->belongsTo(Author::class, 'author_id', 'author_id'); }
    public function category() { return $this->belongsTo(Category::class, 'category_id', 'category_id'); }
    public function borrowTransactions() { return $this->hasMany(BorrowTransaction::class, 'book_id', 'book_id'); }

    public function getAvailableQtyAttribute() {
        $borrowed = $this->borrowTransactions()->where('status', 'active')->count();
        return max(0, $this->quantity - $borrowed);
    }
}
