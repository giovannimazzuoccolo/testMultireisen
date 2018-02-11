<?php

class Validate{
    
        /**
         * Sanitize the string
         * @param type $string
         * @return int
         */
        function sanitizeString($string) {
            return filter_var($string,FILTER_SANITIZE_STRING);
        }
        
         /**
         * Sanitize the email 
         * 
         * @param string $email
         * @return bool
         */
        function validateEmail($email) {
            return filter_var($email,FILTER_VALIDATE_EMAIL);
        }
        /**
         * Validate an int
         * @param int $id
         * @return bool
         */
        function validateIntId($id) {
            return (filter_var($id, FILTER_VALIDATE_INT, array('min_range'=>0)) );
        }
        
        
}