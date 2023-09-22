<?php


//$mysqli = new mysqli('localhost','fixwei_pageroot','l_9&e~Lu+SzX','fixwei_c9rp5r4t2v8')or die(mysqli_error($mysqli));

class DBConnection{

    private $host = 'localhost';
    private $username = 'fixwei_pageroot';
    private $password = 'l_9&e~Lu+SzX';
    private $database = 'fixwei_prueba_formulario';
    
    public $conn;
    
    public function __construct(){

        if (!isset($this->conn)) {
            
            $this->conn = new mysqli('localhost','fixwei_pageroot','l_9&e~Lu+SzX','fixwei_c9rp5r4t2v8');
            
            if (!$this->conn) {
                //echo 'Cannot connect to database server'or die(mysql_error());
                //exit;
            }else{
                //echo 'Conexion establecida';
                
            }            
        }    
        
    }
    
}
?>