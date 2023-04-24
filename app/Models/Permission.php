<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Permission
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property int $id
 * @property string $name
 * @property-read Collection<int, \App\Models\Role> $roles
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @property-read Collection<int, \App\Models\Role> $roles
 * @property-read Collection<int, \App\Models\Role> $roles
 * @mixin Eloquent
 */
class Permission extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
