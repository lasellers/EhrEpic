## EHR Epic

It has been a while since I've started a brand-new Laravel project from scratch,
especially one that has nothing to do with work. Which means I have little in
the way of my own Laravel project to play around with for testing things.
So this is a bit of a refresher and a place experiment with a few things.
Will build a React frontend for it later on.


### Installation

* sudo apt install php7.4-cli
* composer locally
* sudo apt install php-zip php-mbstring php-dom phpunit  php-mysql
php-code-coverage phpunit/php-invoker ext-soap xdebug
ext-uopz

 php composer.phar install
 php artisan --version
 php artisan serve

php artisan key:generate


npm i


php artisan cache:clear
php artisan route:clear

docker run --name ehrepic -e MYSQL_ROOT_PASSWORD=password -d mariadb:latest


## Suggestions
voku/portable-ascii suggests installing ext-intl (Use Intl for transliterator_transliterate() support)
symfony/var-dumper suggests installing ext-intl (To show region name in time zone dump)
symfony/routing suggests installing symfony/config (For using the all-in-one router or any loader)
symfony/routing suggests installing symfony/yaml (For using the YAML loader)
symfony/routing suggests installing symfony/expression-language (For using expression matching)
symfony/routing suggests installing doctrine/annotations (For using the annotation loader)
symfony/polyfill-intl-idn suggests installing ext-intl (For best performance)
symfony/event-dispatcher suggests installing symfony/dependency-injection
symfony/http-kernel suggests installing symfony/browser-kit
symfony/http-kernel suggests installing symfony/config
symfony/http-kernel suggests installing symfony/dependency-injection
symfony/polyfill-intl-normalizer suggests installing ext-intl (For best performance)
symfony/polyfill-intl-grapheme suggests installing ext-intl (For best performance)
symfony/service-contracts suggests installing symfony/service-implementation
symfony/console suggests installing symfony/lock
egulias/email-validator suggests installing ext-intl (PHP Internationalization Libraries are required to use the SpoofChecking validation)
swiftmailer/swiftmailer suggests installing ext-intl (Needed to support internationalized email addresses)
swiftmailer/swiftmailer suggests installing true/punycode (Needed to support internationalized email addresses, if ext-intl is not installed)
ramsey/uuid suggests installing ext-bcmath (Enables faster math with arbitrary-precision integers using BCMath.)
ramsey/uuid suggests installing ext-gmp (Enables faster math with arbitrary-precision integers using GMP.)
ramsey/uuid suggests installing ext-uuid (Enables the use of PeclUuidTimeGenerator and PeclUuidRandomGenerator.)
ramsey/uuid suggests installing ramsey/uuid-doctrine (Allows the use of Ramsey\Uuid\Uuid as Doctrine field type.)
ramsey/uuid suggests installing paragonie/random-lib (Provides RandomLib for use with the RandomLibAdapter)
symfony/translation suggests installing symfony/config
symfony/translation suggests installing symfony/yaml
monolog/monolog suggests installing graylog2/gelf-php (Allow sending log messages to a GrayLog2 server)
monolog/monolog suggests installing doctrine/couchdb (Allow sending log messages to a CouchDB server)
monolog/monolog suggests installing ruflin/elastica (Allow sending log messages to an Elastic Search server)
monolog/monolog suggests installing elasticsearch/elasticsearch (Allow sending log messages to an Elasticsearch server via official client)
monolog/monolog suggests installing php-amqplib/php-amqplib (Allow sending log messages to an AMQP server using php-amqplib)
monolog/monolog suggests installing ext-amqp (Allow sending log messages to an AMQP server (1.0+ required))
monolog/monolog suggests installing ext-mongodb (Allow sending log messages to a MongoDB server (via driver))
monolog/monolog suggests installing mongodb/mongodb (Allow sending log messages to a MongoDB server (via library))
monolog/monolog suggests installing aws/aws-sdk-php (Allow sending log messages to AWS services like DynamoDB)
monolog/monolog suggests installing rollbar/rollbar (Allow sending log messages to Rollbar)
monolog/monolog suggests installing php-console/php-console (Allow sending log messages to Google Chrome)
league/flysystem suggests installing league/flysystem-eventable-filesystem (Allows you to use EventableFilesystem)
league/flysystem suggests installing league/flysystem-rackspace (Allows you to use Rackspace Cloud Files)
league/flysystem suggests installing league/flysystem-azure (Allows you to use Windows Azure Blob storage)
league/flysystem suggests installing league/flysystem-webdav (Allows you to use WebDAV storage)
league/flysystem suggests installing league/flysystem-aws-s3-v2 (Allows you to use S3 storage with AWS SDK v2)
league/flysystem suggests installing league/flysystem-aws-s3-v3 (Allows you to use S3 storage with AWS SDK v3)
league/flysystem suggests installing spatie/flysystem-dropbox (Allows you to use Dropbox storage)
league/flysystem suggests installing srmklive/flysystem-dropbox-v2 (Allows you to use Dropbox storage for PHP 5 applications)
league/flysystem suggests installing league/flysystem-cached-adapter (Flysystem adapter decorator for metadata caching)
league/flysystem suggests installing league/flysystem-sftp (Allows you to use SFTP server storage via phpseclib)
league/flysystem suggests installing league/flysystem-ziparchive (Allows you to use ZipArchive adapter)
laravel/framework suggests installing ext-gd (Required to use Illuminate\Http\Testing\FileFactory::image().)
laravel/framework suggests installing ext-memcached (Required to use the memcache cache driver.)
laravel/framework suggests installing ext-redis (Required to use the Redis cache and queue drivers (^4.0|^5.0).)
laravel/framework suggests installing aws/aws-sdk-php (Required to use the SQS queue driver, DynamoDb failed job storage and SES mail driver (^3.0).)
laravel/framework suggests installing doctrine/dbal (Required to rename columns and drop SQLite columns (^2.6).)
laravel/framework suggests installing league/flysystem-aws-s3-v3 (Required to use the Flysystem S3 driver (^1.0).)
laravel/framework suggests installing league/flysystem-cached-adapter (Required to use the Flysystem cache (^1.0).)
laravel/framework suggests installing league/flysystem-sftp (Required to use the Flysystem SFTP driver (^1.0).)
laravel/framework suggests installing moontoast/math (Required to use ordered UUIDs (^1.1).)
laravel/framework suggests installing nyholm/psr7 (Required to use PSR-7 bridging features (^1.2).)
laravel/framework suggests installing pda/pheanstalk (Required to use the beanstalk queue driver (^4.0).)
laravel/framework suggests installing pusher/pusher-php-server (Required to use the Pusher broadcast driver (^4.0).)
laravel/framework suggests installing symfony/cache (Required to PSR-6 cache bridge (^5.0).)
laravel/framework suggests installing symfony/filesystem (Required to create relative storage directory symbolic links (^5.0).)
laravel/framework suggests installing symfony/psr-http-message-bridge (Required to use PSR-7 bridging features (^2.0).)
laravel/framework suggests installing wildbit/swiftmailer-postmark (Required to use Postmark mail driver (^3.0).)
guzzlehttp/psr7 suggests installing zendframework/zend-httphandlerrunner (Emit PSR-7 responses)
psy/psysh suggests installing ext-pdo-sqlite (The doc command requires SQLite to work.)
psy/psysh suggests installing hoa/console (A pure PHP readline implementation. You'll want this if your PHP install doesn't already support readline or libedit.)
filp/whoops suggests installing whoops/soap (Formats errors as SOAP responses)
facade/ignition suggests installing laravel/telescope (^3.1)
sebastian/global-state suggests installing ext-uopz (*)
phpunit/php-code-coverage suggests installing ext-xdebug (^2.7.2)
phpunit/phpunit suggests installing phpunit/php-invoker (^2.0.0)
phpunit/phpunit suggests installing ext-soap (*)
phpunit/phpunit suggests installing ext-xdebug (*)
