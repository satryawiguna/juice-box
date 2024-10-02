<?php

namespace App\Models;

use App\Enums\EntitySchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends BaseModel
{
    use HasFactory;

    public $table = 'permissions';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }
}
