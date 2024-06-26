<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'id_team',
        'zone',
        'ba',
        'user_type',
        'team_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userTeam() {
        return $this->belongsTo(Team::class, 'id_team');
    }

    public function substations()
    {
        return $this->hasMany(Substation::class, 'created_by', 'name');
    }

    public function feederPillar()
    {
        return $this->hasMany(Substation::class, 'created_by', 'name');
    }

    public function tiang()
    {
        return $this->hasMany(Substation::class, 'created_by', 'name');
    }

    public function linkBox()
    {
        return $this->hasMany(Substation::class, 'created_by', 'name');
    }

    public function cableBridge()
    {
        return $this->hasMany(Substation::class, 'created_by', 'name');
    }

    public function userType()
    {
        return $this->belongsTo(Team::class, 'id_team');
    }
}
