<?php 
//header("Content-type: text/xml; charset=utf-8");
require_once('StoreXml.php');
$storeXML = new StoreXML();
try {
$soapClient = new SoapClient('http://localhost:8888/definition.wsdl',array('trace' => 1));
    print_r($soapClient->addContact('Pippo','pippo@pippo.it','92392929','Road of the hell'));
    //print_r($soapClient->deleteContact(1));
    //print_r($soapClient->searchContact('Pr3ip'));
    //print_r($soapClient->listContacts());
    //$soapClient->editContact('1','Poppo','pippo@pippo.it','9393939','Road to paradise');
    //print_r($soapClient->editContact(3,'Pioop','pippo@pippo.it','34234234','Road to Paradise'));
    //var_dump($soapClient->__getFunctions());
    //echo htmlentities(str_ireplace('><', ">\n<", $soapClient->__getLastResponse())) . "\n";
    if($storeXML->saveXML($soapClient->__getLastRequest(),'deleteContact','request')){
        echo "xml saved";
    } else {
        echo "xml not saved";
    }
    
    if($storeXML->saveXML($soapClient->__getLastResponse(),'deleteContact','response')){
        echo "xml saved";
    } else {
        echo "xml not saved";
    }

} catch (SoapFault $e) {
    print_r($e);
}
?>