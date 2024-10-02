<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends BaseModel
{
    use HasFactory, HasSlug;

    public $table = 'posts';

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'publish_date',
        'status',
        'content'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string)Str::uuid();
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function featureImage()
    {
        return $this->belongsTo(Media::class);
    }
}
