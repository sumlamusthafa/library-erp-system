<?php
// ============================================================
// FILE: app/Models/User.php
// ============================================================
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    protected $primaryKey = 'user_id';
    protected $fillable = ['username', 'password', 'role'];
    protected $hidden = ['password'];
    public function getAuthPassword() { return $this->password; }
}
