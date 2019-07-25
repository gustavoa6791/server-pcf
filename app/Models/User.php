<?php
namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, UsesTenantConnection, HasRoles, HasApiTokens;

    /**
     * Dates fields
     *
     * @var array
     */
    protected $dates = [
        'last_login',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'salt', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'salt', 'password', 'remember_token',
    ];

    /**
     * @param $username
     */
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

    /**
     * @param $password
     */
    public function validateForPassportPasswordGrant(array $password)
    {
        return Hash::check($password, $this->getAuthPassword(), ['salt' => $this->salt]);
    }
}
