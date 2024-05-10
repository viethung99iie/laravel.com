<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use HasFactory, SoftDeletes, QueryScopes;
    protected $table = 'languages';

    protected $fillable = [
        'id',
        'name',
        'canonical',
        'description',
        'image',
        'user_id',
        'publish',
        'current',
    ];

    public function post_catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class,
            'post_catalogue_language',
            'language_id',
            'post_catalogue_id',
        )->withPivot(
            'name',
            'canonical',
            'meta_keyword',
            'meta_title',
            'content',
            'description',
            'meta_description',
        )->withTimestamps();
    }
}
