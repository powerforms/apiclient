# Powerforms REST client


## Basic usage

```php
// create client with configuration above
$client = new \powerforms\apiclient\Client($baseApiUrl, $apiKey, $apiSecret);

// get all available Forms
$forms = $client->getForms();

// get all data states
$states = $client->getDataStates();

// get data from 1.1.2016 for form #1
$data = $client->getData(1, '2016-01-01'); 

// get count and data from 1.1.2016 to 10.3.2016 for form #1 and #2 where state is OK 
$countData = $client->getDataCount([1,2], '2016-01-01', '2016-03-10',['OK']);
$data = $client->getData([1,2], '2016-01-01', '2016-03-10',['OK']);

```

### Installing via Composer

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next:

```bash
composer.phar require powerforms/apiclient
```

And add include to your script:

```php
require 'vendor/autoload.php';
``` 