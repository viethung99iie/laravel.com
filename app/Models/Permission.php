<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory, QueryScopes;
    protected $table = 'permissions';

    protected $fillable = [
        'id',
        'name',
        'canonical',
    ];

    public function user_catalogues(): BelongsToMany
    {
        return $this->belongsToMany(UserCatalogue::class, 'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
    }
}
