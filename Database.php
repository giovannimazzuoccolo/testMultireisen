<?php
class Database{
    private $host      = 'localhost';
    private $user      = 'multireisenTest';
    private $pass      = 'R0adToBerlin';
    private $dbname    = 'multireisen';
    private $port      = 8889;
 
    private $dbh;
    private $error;
    private $statement;
    
    public function __construct(){
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';port='.$this->port;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => true,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );
        // Create a new PDO instanace
        try{
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            print_r($this->dbh);
        }
        // Catch any errors
        catch(PDOException $e){
            $this->error = $e->getMessage();
        }
    }//construct
    
    
    /**
     * Start the transaction for mysql
     * 
     * @return object
     */
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    
    
    /**
     * Complete and the transaction
     * 
     * @return type
     */
    public function endTransaction(){
        return $this->dbh->commit();
    }
    
    /**
     * 
     * Cancel the transaction
     * 
     * @return function
     */
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    /**
     * Prepare the query
     * 
     * @param String $query
     */
    public function query($query){
        $this->statement = $this->dbh->prepare($query);
    }
    
    /**
     * 
     * Bind a single value
     * 
     * @param type $param
     * @param type $value
     * @param type $type
     */
    public function bind($param, $value, $type = null){
            if (is_null($type)) {
                 switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                    break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                    break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                    break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            
            $this->statement->bindValue($param, $value, $type);
    }//bind
    
    
    /**
     * Execute the query
     * 
     * @return function
     */
    public function execute(){
        return $this->statement->execute();
    }
    
    
    /**
     * Return the row count
     * 
     * @return Integer
     */
    public function rowCount(){
        return $this->statement->rowCount();
    }
    
    
    /**
     * returns a single record from the database
     * 
     * @return array
     */
    public function single(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * returns an array of rows
     * 
     * @return array
     */
    
    public function resultset(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    /**
     * Get the last insert Id 
     * 
     * @return integer
     */
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }//lastInsertId
    
    
}

?>