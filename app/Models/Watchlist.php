<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Watchlist
 *
 * @property int $id
 * @property int $movie_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Watchlist whereUserId($value)
 * @mixin \Eloquent
 */
class Watchlist extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'watchlist_movies');
    }

}
