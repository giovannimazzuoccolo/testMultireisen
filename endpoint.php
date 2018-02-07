<?php

    class SoapServerMultireisen {
            
        function addContact($name,$email,$phone_number,$address) {
            $nameSan = $this->sanitizeString($name);
            $emailSan = $this->sanitizeString($email);
            $phone_numberSan = $this->sanitizeString($phone_number);
            $addressSan = $this->sanitizeString($address);
            
            return 'myList'.$nameSan.''.$emailSan.''.$phone_numberSan.''.$addressSan;
            
        }
        
        
        function sanitizeString($string) {
            return filter_var($string,FILTER_SANITIZE_STRING);
        }
        
        function sanitizeEmail($email) {
            return filter_var($email,FILTER_SANITIZE_EMAIL);
        }
        
        
        
    }
    
    $server= new SoapServer("definition.wsdl");
    $server->setClass("SoapServerMultireisen");
    $server->handle();
    
    
 ?>