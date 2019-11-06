# laralog
Simple Log Viewer for Laravel

[![Packagist](https://img.shields.io/packagist/v/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/l/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/dm/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Author](https://img.shields.io/badge/author-@mortezanasiri-blue.svg)](https://mortezanasiri.github.io)

# Install
Install via composer
```
composer require moritiza/laralog
```

Add Service Provider to `config/app.php` in `providers` section
```php
MoriTiza\LaraLog\LaraLogServiceProvider::class,
```

Go to `http://myapp/logs` or some other route
