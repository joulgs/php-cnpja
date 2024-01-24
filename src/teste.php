<?php
require 'CNPJaInterface.php';

use JGS\CNPJa\CNPJaInterface;

$token = 'YOUR_TOKEN';
$cnpj  = 'SEARCH_CNPJ';

$company = new CNPJaInterface($token, $cnpj);

if ($company->isValid()) {
    echo "Empresa encontrada!\n";
    print_r($company->getResponse()) . "\n";
    echo $company->getName() . "\n";
    echo $company->getPhoneFormatted() . "\n";
    echo $company->getAlias() . "\n";
    echo $company->getStreet() . "\n";
    echo $company->getNumber() . "\n";
    echo $company->getComplement() . "\n";
    echo $company->getDistrict() . "\n";
    echo $company->getCity() . "\n";
    echo $company->getCityCode() . "\n";
    echo $company->getState() . "\n";
    echo $company->getCountry() . "\n";
    echo $company->isHead() ? 'MATRIZ' : 'FILIAL' . "\n";
    echo $company->getZipCode() . "\n";
    echo $company->getEmail() . "\n";
    echo $company->getMainCnaeCode() . "\n";
    echo $company->getFounded() . "\n";
    echo strtoupper($company->getStatus()) . "\n";
    // print_r($company->getAllCnaeArray()) . "\n";
} else {
    echo "Empresa não encontrada!\n";
}
