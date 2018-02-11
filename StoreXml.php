<?php

class StoreXML {

    private $directory = 'storage';
    private $dirAndTime;

    public function __construct() {
        $this->dirAndTime = $this->directory . '/' . date("Y-m-d--H-i-s");
        mkdir($this->dirAndTime);
    }

    /**
     * Save the xml file. Default folder name: storage
     * return true if saved correctly, false if not.
     * 
     * @param string $xml
     * @param string $functionName
     * @param string $requestOrResponse
     * @return boolean
     */
    
    public function saveXML($xml,$functionName,$requestOrResponse) {
        $xmlEl = new SimpleXMLElement($xml);
        
        if ($xmlEl->asXML($this->dirAndTime . '/' . date("Y-m-d--H-i-s") .'-'.$functionName.'-'.$requestOrResponse.'.xml')) {
                return true;
        } else {
                return false;
        }
    }

}
