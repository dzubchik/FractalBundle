League Fractal Symfony Bundle
=============================

[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)

This bundle provides integration of [league/fractal](https://github.com/thephpleague/fractal) for Symfony. In addition it allows you to use [transformers as a services](#using-transformers-as-services).

## Getting Started

First of all you need to add dependency to composer.json:

```
composer require paymaxi/fractal-bundle
```

Then register bundle in `app/AppKernel.php`:

```php
public function registerBundles()
{
    return [
        // ...
        new Paymaxi\FractalBundle\PaymaxiFractalBundle(),
    ];
}
```

Now we can write and use fractal transformers:

## Using Transformers as Services

There are several cases when you need to pass some dependencies into transformer. The common one is [role/scope based results](https://github.com/thephpleague/fractal/issues/327) in transformers. For example you need to show `email` field only for administrators or owner of user profile:

```php
class UserTransformer extends TransformerAbstract
{
    private $authorizationCheker;
    
    public function __construct(AuthorizationChecker $authorizationCheker)
    {
        $this->authorizationCheker = $authorizationCheker;
    }
    
    public function transform(User $user)
    {
        $data = [
            'id' => $user->id(),
            'name' => $user->name(),
        ];
        
        if ($this->authorizationChecker->isGranted(UserVoter::SEE_EMAIL, $user)) {
            $data['email'] = $user->email();
        }
        
        return $data;
    }
}
```

Then you could just register this class as service, and pass service ID as transformer. This bundle then will try to get it from container:

```php
$resource = new Collection($users, 'app.transformer.user');
```

This works in includes as well:

```php
public function includeFriends(User $user)
{    
    return $this->collection($user->friends(), 'app.transformer.user');
}
```

You could see example of how to use transformers in [sample application](tests/Fixtures) which is used in test suites.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/paymaxi/fractal-bundle.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/paymaxi/FractalBundle/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/paymaxi/fractal-bundle.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/paymaxi/fractal-bundle.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/paymaxi/fractal-bundle.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/paymaxi/fractal-bundle
[link-travis]: https://travis-ci.org/paymaxi/FractalBundle
[link-scrutinizer]: https://scrutinizer-ci.com/g/paymaxi/fractal-bundle/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/paymaxi/fractal-bundle
[link-downloads]: https://packagist.org/packages/paymaxi/fractal-bundle
[link-author]: https://github.com/paymaxi/fractal-bundle
[link-contributors]: ../../contributors
