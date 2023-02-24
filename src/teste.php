<?php
require 'CNPJaInterface.php';
use JGS\CNPJa\CNPJaInterface;

$token = 'YOUR_TOKEN';
$cnpj  = 'SEARCH_CNPJ';

$company = new CNPJaInterface($token,$cnpj);

echo $company->getName()."\n";
