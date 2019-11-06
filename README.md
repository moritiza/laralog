# laralog
Simple Log Viewer for Laravel

[![Packagist](https://img.shields.io/packagist/v/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/l/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/dm/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/moritiza/laralog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/moritiza/laralog/?branch=master)

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
