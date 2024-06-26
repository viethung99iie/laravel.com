<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCatalogue extends Model
{
    use HasFactory, QueryScopes;

    protected $table = 'user_catalogues';

    protected $fillable = [
        'name',
        'description',
        'publish',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'user_catalogue_id', 'id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_catalogue_permission', 'user_catalogue_id', 'permission_id');

    }
}
