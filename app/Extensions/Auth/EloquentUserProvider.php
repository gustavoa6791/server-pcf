<?php
namespace App\Extensions\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\EloquentUserProvider as DefaultUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;

class EloquentUserProvider extends DefaultUserProvider
{
    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     * @param  array                                      $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword(), ['salt' => $user->salt]);
    }
}
