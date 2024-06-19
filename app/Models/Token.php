<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'target_chat_id',
        'secret',
        'created_at',
        'revoked_at',
    ];
}
