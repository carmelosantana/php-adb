# php-adb

A PHP wrapper to help communicate with [adb](https://developer.android.com/studio/command-line/adb) server.

> **Note:** *This project is in active development and will change frequently till we reach a stable version.*

## Install

While under active development please include the **main** branch of `php-adb` from **this** repository in your project. Stable releases will be made available on [Packagist](https://packagist.org/) once ready.

Add the following to your composer to include `php-adb` in your project.

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/carmelosantana/php-adb.git"
    }
  ],
  "require": {
    "carmelosantana/php-adb": "dev-main"
  }
}
```

## Use

### Basic

```php
use carmelosantana\ADB\ADB;

$adb = new ADB();

$adb->version();
```

#### Output

```txt
Android Debug Bridge version 1.0.39
```

## ToDo

- [ ] Add docblocks to `src/*.php`
- [ ] Add support for more `adb` features
- [ ] Finish documentation

## License

The code is licensed [MIT](https://opensource.org/licenses/MIT) and the documentation is licensed [CC BY-SA 4.0](https://creativecommons.org/licenses/by-sa/4.0/).
