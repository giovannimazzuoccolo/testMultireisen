<?php

    require_once('Database.php');
    require_once('Validate.php');

    class SoapServerMultireisen {
            
        protected $db;
        
        function __construct() {
            
            $this->db = new Database();
            $this->vd = new Validate();
        }
        
        
        /**
         * 
         * Add a contact into the book_address.
         * Sanitize and validate strings and email
         * 
         * @param string $name
         * @param string $email
         * @param string $phone_number
         * @param string $address
         * @return integer
         * @throws SoapFault
         */
        function addContact($name,$email,$phone_number,$address) {
            $nameSan = $this->vd->sanitizeString($name);
            $emailSan = $this->vd->sanitizeString($email);
            $phone_numberSan = $this->vd->sanitizeString($phone_number);
            $addressSan = $this->vd->sanitizeString($address);
            
            if(!$this->vd->validateEmail($email)){
                throw new SoapFault("email","Please insert a real email");
            }
            
            $this->db->beginTransaction();

        $this->db->query('INSERT INTO ADDRESS_BOOK (name,email,phone_number,address) VALUES (:name,:email,:phone_number,:address)');
            $this->db->bind(':name',$nameSan);
            $this->db->bind(':email',$emailSan);
            $this->db->bind(':phone_number',$phone_numberSan);
            $this->db->bind(':address',$addressSan);
            
            $this->db->execute();
            
            $this->db->endTransaction();
            
            return $this->db->lastInsertId();
            
            
        }//addContact
        
        /**
         * Delete a contact by id return true if success.
         * 
         * @param int $address_id
         * @return bool
         * @throws SoapFault
         */
        function deleteContact($address_id) {
            if(!$this->vd->validateIntId($address_id)) {
                throw new SoapFault("address",'Please insert an integer greater than one');
            }
            
           if(!$this->ifAddressExist($address_id)) {
                throw new SoapFault("address",'Id not found');
            }
            
            $this->db->beginTransaction();
            
            $this->db->query('DELETE FROM ADDRESS_BOOK WHERE address_id = :address_id');
            
            $this->db->bind(':address_id',$address_id);
            
            $this->db->execute();
            
            $this->db->endTransaction();
            
            return true;
            
        }//deleteContact
        
       /**
        * Search contact by name
        * return an array of results 
        *
        * @param string $name
        * @return array of results
        */
        
        function searchContact($name) {
            $nameSan = $this->vd->sanitizeString($name);
            
            $this->db->beginTransaction();
            
            $this->db->query("SELECT * FROM ADDRESS_BOOK WHERE name LIKE concat('%', :name, '%') ");
            
            $this->db->bind(':name', $nameSan);
            
            $this->db->execute();
            
            $this->db->endTransaction();
            
            return $this->db->resultset();
            
        }
        
        /**
         * List all the contacts into an array
         * 
         * @return array
         */
        function listContacts() {
            
            $this->db->beginTransaction();
            
            $this->db->query('SELECT * FROM ADDRESS_BOOK');
            
            $this->db->execute();
            
            $this->db->endTransaction();
            
            return $this->db->resultset();
            
        }
        
        /**
         * Edit the contact 
         * 
         * @param type $address_id
         * @param type $name
         * @param type $email
         * @param type $phone_number
         * @param type $address
         * @return boolean
         * @throws SoapFault
         */
        function editContact($address_id,$name,$email,$phone_number,$address) {
            
            if(!$this->vd->validateIntId($address_id)) {
                throw new SoapFault("address",'Please insert an integer greater than one');
            }
            
            if(!$this->ifAddressExist($address_id)) {
                throw new SoapFault("address",'Id not found');
            }

            $this->db->beginTransaction();
            
            $breakQuery = array();
            
            if(trim($name) !== "") {
                $breakQuery[] = "name = :name";
            }
            
            if(trim($email) !== "") {
                $breakQuery[] = "email = :email";
            }
            
            if(trim($phone_number) !== "") {
                $breakQuery[] = "phone_number = :phone_number";
            }
            
            if(trim($address) !== "") {
                $breakQuery[] = "address = :address";
            }
            
            if(sizeof($breakQuery) > 1){
                $this->db->query('UPDATE ADDRESS_BOOK SET '.  implode(", ", $breakQuery).' WHERE address_id = :address_id');
                            
               if(trim($name) !== "") {
                $this->db->bind(':name', $this->vd->sanitizeString($name));
               }
               
               if(trim($email) !== "") {
                $this->db->bind(':email', $email);
               }
                
               if($phone_number !== "") {
                  $this->db->bind(':phone_number', $phone_number);
               }
               
               if(trim($address) !== "") {
                  $this->db->bind(':address', $this->vd->sanitizeString($address));
               }
               
               $this->db->bind(':address_id', $address_id);
            }
            
            
            
            $this->db->execute();
            
            $this->db->endTransaction();
            
            return true;
            
        }//editContact
        
        
        
        
        
        /**
         * Check if the address exist, throw a soapfault if is not a int
         * 
         * @param type $address_id
         * @return boolean
         * @throws SoapFault
         */
        private function ifAddressExist($address_id){
            
            if(!$this->vd->validateIntId($address_id)) {
                throw new SoapFault("address",'Please insert an integer greater than one');
            }
            
            $this->db->beginTransaction();
            
            $this->db->query('SELECT * FROM ADDRESS_BOOK WHERE address_id = :address_id');
            
            $this->db->bind(':address_id',$address_id);
            
            $this->db->execute();
            
            
            if($this->db->rowCount() > 0) {
                $this->db->endTransaction();
                return true;
            } else {
                $this->db->endTransaction();
                return false;
            }
            
            
        }
        
        
    }
    
    $server= new SoapServer("definition.wsdl");
    $server->setClass("SoapServerMultireisen");
    $server->handle();
    
    
 ?>