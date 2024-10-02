<?php

namespace App\Models;

use App\Enums\EntitySchema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Profile extends BaseModel
{
    use HasFactory;

    public $table = 'profiles';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $guarded = ['deleted_at'];


    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    public function profileable()
    {
        return $this->morphTo();
    }
}
