phongo libraries
================

MongoDB CRUD interface for [PHongo](https://github.com/10gen-labs/mongo-php-driver-prototype).


This interface is meant for the general public to use with PHongo,
and will serve as the default reference interface when creating other bindings.


## Documentation
- http://10gen-labs.github.io/mongo-php-library-prototype/

# Installation

As `PHongo libraries` is an abstraction layer for PHongo, it naturally requires
[PHongo to be installed](http://10gen-labs.github.io/mongo-php-driver-prototype/#installation):

	$ wget https://github.com/10gen-labs/mongo-php-driver-prototype/releases/download/0.1.5/phongo-0.1.5.tgz
	$ pecl install phongo-0.1.5.tgz
	$ echo "extension=phongo.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`

The best way to then install `PHongo libraries` is via [composer](https://getcomposer.org/)
by adding the following to
[composer.json](https://getcomposer.org/doc/01-basic-usage.md#composer-json-project-setup):

```json
    "repositories": [
        {
	    "type": "vcs",
	    "url": "https://github.com/10gen-labs/mongo-php-libraries-prototype"
        }
    ],
    "require": {
        "ext-phongo": ">=0.1.5",
        "10gen-labs/mongo-php-libraries-prototype": "dev-master"
    }
```

and then running

```shell
$ composer install
```

## Reporting tickets
- https://jira.mongodb.org/secure/CreateIssue.jspa?pid=12483&issuetype=1
