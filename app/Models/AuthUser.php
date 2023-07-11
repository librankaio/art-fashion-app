<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthUser extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $table = "auth_users";

    protected $fillable = [
        'id_user',
        'username',
        'name',
        'email',
        'feature',
        'open',
        'save',
        'updt',
        'dlt',
        'stat',
    ];
}
