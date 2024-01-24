<?php
require 'CNPJaInterface.php';

use JGS\CNPJa\CNPJaInterface;

$token = 'YOUR_TOKEN';
$cnpj  = 'SEARCH_CNPJ';

$company = new CNPJaInterface($token, $cnpj);

if ($company->isValid()) {
    echo "Empresa encontrada!\n";
    echo $company->getName() . "\n";
} else {
    echo "Empresa não encontrada!\n";
}
