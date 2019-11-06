# laralog
Simple Log Viewer for Laravel

[![Packagist](https://img.shields.io/packagist/v/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)

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
