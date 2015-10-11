# ResourceManager

[![Build Status](https://img.shields.io/travis/jpcercal/resource-manager/master.svg?style=flat-square)](http://travis-ci.org/jpcercal/resource-manager)
[![Coverage Status](https://coveralls.io/repos/jpcercal/resource-manager/badge.svg)](https://coveralls.io/r/jpcercal/resource-manager)
[![Latest Stable Version](https://img.shields.io/packagist/v/cekurte/resource-manager.svg?style=flat-square)](https://packagist.org/packages/cekurte/resource-manager)
[![License](https://img.shields.io/packagist/l/cekurte/resource-manager.svg?style=flat-square)](https://packagist.org/packages/cekurte/resource-manager)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/42d8e5de-3999-4155-bddf-31e401c304cf/mini.png)](https://insight.sensiolabs.com/projects/42d8e5de-3999-4155-bddf-31e401c304cf)

- A library to increase the power of your resources, **contribute with this project**!

## Installation

The package is available on [Packagist](http://packagist.org/packages/cekurte/resource-manager).
The source files is [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) compatible.
Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.

```shell
composer require cekurte/resource-manager
```

## Documentation

Actually is available one ResourceManager implementation that is to the Doctrine ORM.

To use, create your entity class and implements the [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php):

```php
<?php

use Cekurte\ResourceManager\Contract\ResourceInterface;

class YourEntity implements ResourceInterface
{
    // ...
}
```

Now use the a implementation of [ResourceManagerInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceManagerInterface.php). This interface implements:

- [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php)
- [ResourceLoggableInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceLoggableInterface.php)
- [ResourceSearchableInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceSearchableInterface.php)
- [ResourceWritableInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceWritableInterface.php)
- [ResourceUpdatableInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceUpdatableInterface.php)
- [ResourceDeletableInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceDeletableInterface.php)

Today is available only the [DoctrineResourceManager](https://github.com/jpcercal/resource-manager/blob/master/src/DoctrineResourceManager.php) to manage your resources.

```php
<?php

use Cekurte\ResourceManager\Contract\ResourceInterface;
use Cekurte\ResourceManager\DoctrineResourceManager;
use Cekurte\ResourceManager\Query\Expr\DoctrineQueryExpr;
use Cekurte\ResourceManager\Query\QueryString;

class YourController
{
    // ...

    public function someMethodAction()
    {
        // ...

        $resourceManager = new DoctrineResourceManager(
            $entityManager,
            "YourNamespace\YourEntity"
        );

        // perform a query given a query string from PSR ServerRequestInterface
        // http://yourdomain.com/your-route/?q[]=alias.field:eq:value
        // The QueryString::process will convert the ServerRequestInterface to a valid DoctrineQueryExpr
        $resources = $resourceManager
            ->findResources((new QueryString())->process($psrServerRequest))
        ;

        // Other methods from API:

        // $expr = new DoctrineQueryExpr();
        // $expr->eq('c.slug', $yourSlugPage);
        //
        // $resource = $resourceManager->findResource($expr);

        // $writted  = $resourceManager->writeResource($resource);

        // $updated  = $resourceManager->updateResource($resource);

        // $deleted  = $resourceManager->deleteResource($resource);
    }
}
```

Are available the following query expressions:

| Expression  | Class::method                                                                                       | Description      |
|-------------|-----------------------------------------------------------------------------------------------------|------------------|
| **eq**      | [QueryExprInterface::eq](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L29)  | Equals, to use in query string *?q[]=alias.field:eq:value*
| **neq**     | [QueryExprInterface::neq](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L39) | NotEquals, to use in query string *?q[]=alias.field:neq:value*
| **between** | [QueryExprInterface::between](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L49) | Between, to use in query string *?q[]=alias.field:between:from-to*
| **like**    | [QueryExprInterface::like](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L59)| Like, to use in query string *?q[]=alias.field:like:%value%*
| **gt**      | [QueryExprInterface::gt](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L69)  | Greater than, to use in query string *?q[]=alias.field:gt:value*
| **gte**     | [QueryExprInterface::gte](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L79) | Greater than or equal, to use in query string *?q[]=alias.field:gte:value*
| **lt**      | [QueryExprInterface::lt](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L89)  | Lower than, to use in query string *?q[]=alias.field:lt:value*
| **lte**     | [QueryExprInterface::lte](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/QueryExprInterface.php#L99) | Lower than or equal, to use in query string *?q[]=alias.field:lte:value*

If you liked of this library, give me a *star* **=)**.

Contributing
------------

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Make your changes
4. Run the tests, adding new ones for your own code if necessary (`vendor/bin/phpunit`)
5. Commit your changes (`git commit -am 'Added some feature'`)
6. Push to the branch (`git push origin my-new-feature`)
7. Create new Pull Request
