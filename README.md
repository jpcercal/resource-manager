# ResourceManager

[![Build Status](https://img.shields.io/travis/jpcercal/resource-manager/master.svg?style=square)](http://travis-ci.org/jpcercal/resource-manager)
[![Code Climate](https://codeclimate.com/github/jpcercal/resource-manager/badges/gpa.svg)](https://codeclimate.com/github/jpcercal/resource-manager)
[![Coverage Status](https://coveralls.io/repos/github/jpcercal/resource-manager/badge.svg?branch=master)](https://coveralls.io/github/jpcercal/resource-manager?branch=master)
[![Latest Stable Version](https://img.shields.io/packagist/v/cekurte/resource-manager.svg?style=square)](https://packagist.org/packages/cekurte/resource-manager)
[![License](https://img.shields.io/packagist/l/cekurte/resource-manager.svg?style=square)](https://packagist.org/packages/cekurte/resource-manager)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/42d8e5de-3999-4155-bddf-31e401c304cf/mini.png)](https://insight.sensiolabs.com/projects/42d8e5de-3999-4155-bddf-31e401c304cf)

- A Resource Manager to PHP (with all methods covered by php unit tests), with this library you can perform queries and manage resources using a unique interface. Now, you can increase the power of your resources, **contribute with this project**!.

**If you liked of this library, give me a *star =)*.**

## Installation

- The package is available on [Packagist](http://packagist.org/packages/cekurte/resource-manager).
- The source files is [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md) compatible.
- Autoloading is [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md) compatible.
- [RequestParser](https://github.com/jpcercal/resource-query-language/blob/master/src/Parser/RequestParser.php) is [PSR-7](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-7-http-message.md) compatible.

```shell
composer require cekurte/resource-manager
```

## Documentation

Currently is available one ResourceManager implementation that can be used with the Doctrine ORM.

So, to use this library you must create your entity class and implement the [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php):

```php
<?php

namespace YourNamespace;

use Cekurte\ResourceManager\Contract\ResourceInterface;

class YourEntity implements ResourceInterface
{
    // ...
}
```

After that, you must retrieve an instance of [ResourceManagerInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceManagerInterface.php):

```php
<?php

use Cekurte\ResourceManager\Driver\DoctrineDriver;
use Cekurte\ResourceManager\ResourceManager;
use Cekurte\ResourceManager\Service\DoctrineResourceManager;

$resourceManager = ResourceManager::create('doctrine', [
    'em'     => $entityManager,
    'entity' => 'YourNamespace\YourEntity',
]);

// OR ...
$resourceManager = ResourceManager::create(new DoctrineDriver([
    'em'     => $entityManager,
    'entity' => 'YourNamespace\YourEntity',
]));

// OR ...
$resourceManager = new DoctrineResourceManager(new DoctrineDriver([
    'em'     => $entityManager,
    'entity' => 'YourNamespace\YourEntity',
]));
```

### Getting resources

To retrieve the resources you must call the method `findResources` passing as argument an implementation of [ExprQueue](https://github.com/jpcercal/resource-query-language/blob/master/src/ExprQueue.php). This method will return an array of resources.

```php
<?php

use Cekurte\Resource\Query\Language\ExprQueue;
use Cekurte\Resource\Query\Language\Expr\EqExpr;

// ...

$queue = new ExprQueue();
$queue->enqueue(new EqExpr('alias.field', 'value'));

$resources = $resourceManager->findResources($queue);

// You can call this method without any expression
// to retrive all resources...
// $resources = $resourceManager->findResources();
```

### Getting one resource

To retrieve one resource you must call the method `findResource` passing as argument an implementation of [ExprQueue](https://github.com/jpcercal/resource-query-language/blob/master/src/ExprQueue.php). This method will throw an exception if the resource can not be found.

```php
<?php

use Cekurte\Resource\Query\Language\ExprQueue;
use Cekurte\Resource\Query\Language\Expr\EqExpr;
use Cekurte\ResourceManager\Exception\ResourceDataNotFoundException;

// ...

$queue = new ExprQueue();
$queue->enqueue(new EqExpr('alias.field', 'value'));

try {
    $resource = $resourceManager->findResource($queue);
} catch (ResourceDataNotFoundException $e) {
    // ...
}
```

### Creating a resource

To create one resource you must call the method `writeResource` passing as argument an implementation of [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php).

```php
<?php

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedWriteException;

// ...

try {
    $resourceManager->writeResource($resource);
} catch (ResourceManagerRefusedWriteException $e) {
    // ...
}
```

### Updating a resource

To update one resource you must call the method `updateResource` passing as argument an implementation of [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php).

```php
<?php

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedUpdateException;

// ...

try {
    $resourceManager->updateResource($resource);
} catch (ResourceManagerRefusedUpdateException $e) {
    // ...
}
```

### Removing a resource

To remove one resource you must call the method `deleteResource` passing as argument an implementation of [ResourceInterface](https://github.com/jpcercal/resource-manager/blob/master/src/Contract/ResourceInterface.php).

```php
<?php

use Cekurte\ResourceManager\Exception\ResourceManagerRefusedDeleteException;

// ...

try {
    $resourceManager->deleteResource($resource);
} catch (ResourceManagerRefusedDeleteException $e) {
    // ...
}
```

If you liked of this library, give me a *star* **=)**.

Contributing
------------

1. Give me a star **=)**
1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Make your changes
4. Run the tests, adding new ones for your own code if necessary (`vendor/bin/phpunit`)
5. Commit your changes (`git commit -am 'Added some feature'`)
6. Push to the branch (`git push origin my-new-feature`)
7. Create new Pull Request
