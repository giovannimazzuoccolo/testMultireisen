<?php

try {
$addContact = new SoapClient('http://localhost:8888/definition.wsdl');
print_r($addContact->addContact('Pippo','pippo@pippa.it','92392929','Road of the hell'));
} catch (SoapFault $e) {
print_r($e);
}

