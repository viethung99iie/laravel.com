<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PostCatalogue extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'post_catalogues';

    protected $fillable = [
        'parent_id',
        'lft',
        'rgt',
        'level',
        'album',
        'icon',
        'image',
        'user_id',
        'publish',
        'order',
        'follow',
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class,
            'post_catalogue_language',
            'post_catalogue_id',
            'language_id'
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

    public function post_catalogue_language()
    {
        return $this->hasMany(PostCatalogueLanguage::class, 'post_catalogue_id', 'id');
    }

    public static function isChildrentNode(int $id = 0)
    {
        $postCatalogue = PostCatalogue::find($id);
        if ($postCatalogue->rgt - $postCatalogue->lft !== 1) {
            return false;
        }
        return true;
    }
}
