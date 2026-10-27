<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 't004_roles';
    protected $guarded = ['id'];

    // Relasi 1 Role memiliki banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
