<?php

namespace App\Models;

use App\Enums\EntitySchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Policy extends BaseModel
{
    use HasFactory;

    public $table = 'policies';

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }
}
