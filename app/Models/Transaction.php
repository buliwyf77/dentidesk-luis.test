<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_transaction',
        'desc_transaction',
        'fech_transaction',
        'amount',
        'email',
        'password',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);    
    }
}
