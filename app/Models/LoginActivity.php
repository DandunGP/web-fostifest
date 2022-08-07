<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\HasUUID;

class LoginActivity extends Model
{
    use HasFactory, HasUUID;

    protected $fillable = [
        'user_id',
        'user_agent',
        'ipv4_address',
        'expire_time'
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;
}
