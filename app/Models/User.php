<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Watchlist;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'surname',
        'location',
        'photo',
        'gender',
        'birthday',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function seriesCount()
    {
        return $this->ratings()->where('media_type', 'tv')->count();
    }

    public function moviesCount()
    {
        return $this->ratings()->where('media_type', 'movie')->count();
    }

    public function favoriteCount()
    {
        return $this->watchlists()->where('list_type', 'favorites')->count();
    }

    public function watchLaterCount()
    {
        return $this->watchlists()->where('list_type', 'watch_later')->count();
    }

    public function isInWatchLater($movieId)
    {
        return $this->watchlists()->where('movie_tmdb_id', $movieId)->where('list_type', 'watch_later')->exists();
    }

    public function isFavorite($movieId)
    {
        return $this->watchlists()->where('movie_tmdb_id', $movieId)->where('list_type', 'favorites')->exists();
    }
}
