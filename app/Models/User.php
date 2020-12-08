<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Javaabu\EfaasSocialite\EfaasUser;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'efaas_data' => 'array',
    ];

    /**
     * @param EfaasUser $efaas_user
     * @return User
     */
    public static function findEfaasUserAndUpdate(EfaasUser $efaas_user): User
    {
        $user = static::where('email', $efaas_user->getEmail())->first();

        if (! $user) {
            $user = new User();
            $user->email = $efaas_user->getEmail();
        }

        $user->name = $efaas_user->getName();
        $user->efaas_data = $efaas_user->getRaw();
        $user->markEmailAsVerified();

        return $user;
    }
}
