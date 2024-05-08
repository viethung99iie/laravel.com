<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'album',
        'icon',
        'image',
        'user_id',
        'publish',
        'order',
        'follow',
        'post_catalogue_id'
    ];

    public function languages()
    {
        return $this->belongsToMany(Language::class,
                            'post_language',
                            'post_id',
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

    public function post_language(){
        return $this->hasMany(PostCatalogueLanguage::class,'post_id','id');
    }

    public static function isChildrentNode(int $id =0){
        $postCatalogue = PostCatalogue::find($id);
        if($postCatalogue->rgt - $postCatalogue->lft !== 1){
            return false;
        }
        return true;
    }
    public function post_catalogues()
    {
        return $this->belongsToMany(PostCatalogue::class,'post_catalogue_post','post_id','post_catalogue_id');
    }
}
