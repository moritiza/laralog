# laralog
### Simple Log Viewer for Laravel
Developed with :heart: for developers

[![Packagist](https://img.shields.io/packagist/v/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/l/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Packagist](https://img.shields.io/packagist/dm/moritiza/laralog.svg)](https://packagist.org/packages/moritiza/laralog)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/eab4d8855fb14806ba9ce412ce5ceedc)](https://www.codacy.com/manual/mortezanasiri/laralog?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=mortezanasiri/laralog&amp;utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mortezanasiri/laralog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/mortezanasiri/laralog/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/mortezanasiri/laralog/badges/build.png?b=master)](https://scrutinizer-ci.com/g/mortezanasiri/laralog/build-status/master)
[![Author](https://img.shields.io/badge/author-@mortezanasiri-blue.svg)](https://mortezanasiri.github.io)

## Screenshot
![MoriTiza/LaraLog](https://github.com/mortezanasiri/laralog/blob/master/MoriTiza-LaraLog.png?raw=true)

## Install
Install via composer
```shell
composer require moritiza/laralog
```
## Add Service Provider
Add ```MoriTiza\LaraLog``` service provider to `config/app.php` in `providers` section
```php
MoriTiza\LaraLog\LaraLogServiceProvider::class,
```
## Dive into :wink:
No need to add route, Just go to `http://myapp/logs` and enjoy it! :heart_eyes:
