<?php
namespace App\Extensions\Hashing;

use Illuminate\Contracts\Hashing\Hasher as HasherContract;

class SymfonyHasher implements HasherContract
{
    /**
     * Default salt
     *
     * @var bool
     */
    protected $defaultSalt = 'IzTS7Gfgg9XnO3ns1cYJ';

    /**
     * Create a new hasher instance.
     *
     * @param  array  $options
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->defaultSalt = $options['salt'] ?? $this->defaultSalt;
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string              $value
     * @param  string              $hashedValue
     * @param  array               $options
     * @throws \RuntimeException
     * @return bool
     */
    public function check($value, $hashedValue, array $options = [])
    {
        return strcmp($this->make($value, $options), $hashedValue) === 0;
    }

    /**
     * Get information about the given hashed value.
     *
     * @param  string  $hashedValue
     * @return array
     */
    public function info($hashedValue)
    {
        return [
            'algo'     => 0,
            'algoName' => 'symfony',
            'options'  => [],
        ];
    }

    /**
     * Hash the given value.
     *
     * @param  string              $value
     * @param  array               $options
     * @throws \RuntimeException
     * @return string
     */
    public function make($value, array $options = [])
    {
        return sha1($this->salt($options) . md5($value));
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string $hashedValue
     * @param  array  $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = [])
    {
        return false;
    }

    /**
     * Extract the salt value from the options array.
     *
     * @param  array $options
     * @return int
     */
    protected function salt(array $options = [])
    {
        return $options['salt'] ?? $this->defaultSalt;
    }
}
