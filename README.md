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

| Method | Description |
| ------ | ----------- |
| getFounded() | Get the date of foundation |
| getName() | Get the name of the company |
| getAlias() | Get the alias of the company |
| getAddress() | Get the full address object of the company |
| getPhoneFormatted() | Get the phone number of the company formatted |
| getPhone() | Get the phone number of the company |
| getCnpj() | Get the cnpj of the company |
| getEmail() | Get the email of the company |
| getState() | Get the state of the company |
| getCity() | Get the city of the company |
| getStreet() | Get the street of the company | 
| getNumber() | Get the address number of the company |
| getDistrict() | Get the district of the company |
| getComplement() | Get the address complement of the company |
| getZipCode() | Get the zip code of the company |
| getCountry() | Get the country of the company |
| getStatus() | Get the code of registration status |
| isActive() | Returns true if the company's registration status is active |
| getCNAE() | Get the CNAE code of the company |
| getMunicipalityCode() | Get the municipality code of the company |
| isHead() | Returns true if the company is a head company |
| getResponse() | Returns the entire response object |
| getMainCnaeCode() | Get the main CNAE code of the company |
| getMainCnaeDescription() | Get the main CNAE description of the company |
| getSideCnaeArray() | Get the side CNAE array of the company |
| getAllCnaeArray() | Get the all CNAE array of the company |
