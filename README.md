# php-cnpja

Is a communication interface with the [cnpjá API](https://www.cnpja.com/) to obtain specific data from a company.

A single query is made during the construction of the object and then the data can be queried through the methods of the class, if you want the entire return object use the `getResponse` method

---

## Installation

Using Composer:

```bash
composer require joulgs/php-cnpja
```

---

## How Using

``` php
<?php
use JGS\CNPJa\CNPJaInterface;

$token = 'your-token';
$cnpj  = 'company cnpj to be consulted';

$company = new CNPJaInterface($token,$cnpj);

echo $company->getName();

echo $company->getResponse()->company->name;
```

## Methods

* getFounded()
* getName()
* getAddress()
* getPhoneFormatted()
* getPhone()
* getCnpj()
* getEmail()
* getState()
* getCity()
* getStreet()
* getNumber()
* getDistrict()
* getZipCode()
* getCountry()
* getStatus() - returns the code of registration status
* isActive() - returns true if the company's registration status is active
* getResponse() - returns the entire response object
