# Codeception Stripe Module

[![Latest Stable Version](https://poser.pugx.org/portrino/codeception-stripe-module/v/stable)](https://packagist.org/packages/portrino/codeception-stripe-module)
[![Total Downloads](https://poser.pugx.org/portrino/codeception-stripe-module/downloads)](https://packagist.org/packages/portrino/codeception-stripe-module)

## Installation

You need to add the repository into your composer.json file

```bash
composer require --dev portrino/codeception-stripe-module
```

## Configuration

```yml
modules:
    enabled:
        - Stripe:
            api_key: 'sk_test_IGvdODXxy1xXFviyAjWMiK12'
            api_version: '2017-08-15'
            connected_accounts:
                account_1:
                    api_key: 'sk_test_IGvdODXxy1xXFviyAjWMiK34'
                account_2:
                    api_key: 'sk_test_IGvdODXxy1xXFviyAjWMiK56'
 ```  
 
Update codeception build
   
```bash
codecept build
```

### Methods

#### amOnConnectedAccount

```php
  $I->amOnConnectedAccount($accountName);
```

Switch to an account which is defined in the config under `connected_accounts`. All further API request will go through this account.

#### amOnDefaultAccount

```php
  $I->amOnDefaultAccount();
```

Switch (back) to default account. All further API request will go through this account.

#### haveStripeCustomer

```php
  $I->haveStripeCustomer($params);
```

#### deleteStripeCustomer

```php
  $I->deleteStripeCustomer($params);
```

#### detachStripeSource

```php
  $I->detachStripeSource($params);
```

#### haveStripeToken

```php
  $I->haveStripeToken($params);
```

#### haveStripeSource

```php
  $I->haveStripeSource($params);
```

#### addStripeSourceToStripeCustomer

```php
  $I->addStripeSourceToStripeCustomer($customer, $source);
```

#### seeStripeCustomerWithId

```php
  $I->seeStripeCustomerWithId($customerId);
```

#### grabStripeCustomerWithId

```php
  $customer = $I->grabStripeCustomerWithId($id);
```

#### seeStripeChargeWithId

```php
  $I->seeStripeChargeWithId($chargeId);
```

## Authors

![](https://avatars0.githubusercontent.com/u/726519?s=40&v=4)

* **André Wuttig** - *Initial work* - [aWuttig](https://github.com/aWuttig)

See also the list of [contributors](https://github.com/portrino/codeception-stripe-module/graphs/contributors) who participated in this project.
