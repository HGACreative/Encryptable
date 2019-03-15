# HGA Encryptable

This package works with Laravel to allow any model to have encryptable attribues encrypted and decrypted on-the-fly in a very eloquent/Laravel fashion.

We opt to ignore encrypting or decrypting null values when accessing and mutating attributes so that we can use Laravel's `$model->whereNull()` and `$model->whereNotNull()` query builder methods.

Use the `Hgacreative\Encryptable\Encryptable` trait within the relevant models and copy the following code:

```
/**
 * The attributes which should be encrypted in the database
 *
 * @var array
 */
protected $encryptable = [
    //
];
```
