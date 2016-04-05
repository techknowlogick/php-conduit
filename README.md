# PHP Conduit

SDK for [Phabricator's Conduit API](https://secure.phabricator.com/book/phabricator/article/conduit/).

## Implemented API Calls

* maniphest
 * query
 * info
 * update
* user
 * query

## Install

```bash
$ php composer.phar require techknowlogick/php-conduit
```

## Basic usage

```php
<?php

require_once 'vendor/autoload.php';

$client = new \Techknowlogick\Phabricator\Client('https://secure.phabricator.com', 'PHAB_TOKEN');

$user = $client->api("user")->query(array(
            "emails" => array("john.doe@exapmle.com")
        ));

```

## Notes

- This library is based on the [php-phabricator-api](https://github.com/sethington/php-phabricator-api) library

## License

[MIT License](http://en.wikipedia.org/wiki/MIT_License)
