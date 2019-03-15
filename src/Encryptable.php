<?php

namespace Hgacreative\Encryptable;

use ErrorException;

use Illuminate\Support\Facades\Crypt;

/**
 * Use this trait to encrypt/decrypt data on the fly between
 * the database and the view.
 *
 */
trait Encryptable
{

    /**
     * Boot the trait and determine whether or not we have an encryptable
     * property on the model to read from
     *
     * @return void
     */
    protected static function bootEncryptable()
    {
        if (!property_exists(new static, 'encryptable')) {
            throw new ErrorException('$encryptable must be present on the model instance to use the Encryptable trait');
        }
    }

    /**
     * Get and decrypt an attribute if required
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        // get the original value of our attribute
        $value = parent::getAttribute($key);

        return $this->isEncryptable($key) && $this->valueIsNotNull($value)
            ? Crypt::decrypt($value)
            : $value;
    }

    /**
     * Set and encrypt an attribute if required
     * @param  string  $key
     * @param  string  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(
            $key,
            $this->isEncryptable($key) && $this->valueIsNotNull($value)
                ? Crypt::encrypt($value)
                : $value
        );
    }

    /**
     * Determine if an attribute key is encryptable
     *
     * @param  string  $key
     * @return bool
     */
    private function isEncryptable($key)
    {
        return in_array($key, $this->encryptable);
    }

    /**
     * Determine if the value of the attribute is not null. We don't want to
     * encrypt a null value so that we can still leverage Eloquent's
     * whereNull and whereNotNull query methods.
     *
     * @param  mixed  $value
     * @return bool
     */
    private function valueIsNotNull($value)
    {
        return $value !== null;
    }
}
