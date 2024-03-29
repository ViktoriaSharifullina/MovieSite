<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
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

    public function isInWatchLater($movieId)
    {
        return $this->watchlists()->where('movie_tmdb_id', $movieId)->where('list_type', 'watch_later')->exists();
    }

    public function isFavorite($movieId)
    {
        return $this->watchlists()->where('movie_tmdb_id', $movieId)->where('list_type', 'favorites')->exists();
    }
}
