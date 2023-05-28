<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Contacto extends Model
{
    use HasFactory;
    public $incrementing = 'false';
    protected $fillable = ['id','name','lastname','phone','direction','birthday'];
    public function users()
    {
        return $this->belongsTo(User::class, 'id_users');
    }
}
