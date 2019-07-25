<?php
namespace App\Extensions\Hashing;

use Illuminate\Hashing\HashManager as DefaultManager;

class HashManager extends DefaultManager
{
    /**
     * Create an instance of the Symfony hash Driver.
     *
     * @return \Illuminate\Hashing\BcryptHasher
     */
    public function createSymfonyDriver()
    {
        return new SymfonyHasher($this->app['config']['hashing.symfony'] ?? []);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['hashing.driver'] ?? 'symfony';
    }
}
