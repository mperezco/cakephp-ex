<?php

include_once 'App/config.php';


class modeloDB {
    
    private static $dbh = null;
    private static $select_user = "Select * from empleados where EMP_NO = ? and CLAVE = ?";
    private static $select_reservas = "Select * from reserva";
    private static $insert_event = "INSERT INTO reserva (title,descripcion,color,start,sala_no,emp_no) VALUES (?,?,?,?,2,?)";           
    public static function init(){
        
        if (self::$dbh == null){
            try {
                // Cambiar  los valores de las constantes en config.php
                $dsn = "mysql:host=". DBSERVER  .";dbname=". DBNAME .";charset=utf8";
                self::$dbh = new PDO($dsn, DBUSER, DBPASSWORD);
                // Si se produce un error se genera una excepci�n;
                self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e){
                echo "Error de conexi�n ".$e->getMessage();
                exit();
            }
            
        }
    }
    //-------FUNCION PARA VALIDAR USUARIO-------
    public static function OkUser($user,$password){
        $solucion = false;
        $stmt = self::$dbh->prepare(self::$select_user);
        $stmt->bindValue(1,$user);
        $stmt->bindValue(2,$password);
        $stmt->execute();
        if ($stmt->rowCount() > 0 ){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $fila = $stmt->fetch();
            $solucion = true;
        }
        return $solucion;
    }
  
    
    //-------FUNCION PARA VOLCAR DATOS en el calendario -------
    
    public static function recoverData(){
        
        $stmt = self::$dbh->prepare(self::$select_reservas);
        $stmt->execute();
        $solucion = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
        
        $reservas_string = json_encode($solucion);
        
        $file = 'App/dat/reserva.json';
        file_put_contents($file, $reservas_string);
      
        return $file;
    }
    
    //------- Agregar reserva a la base de datos ------
    public static function saveEvent($evento,$user):bool{
        $stmt = self::$dbh->prepare(self::$insert_event);
        $stmt->bindValue(1,$evento[0]);
        $stmt->bindValue(2,$evento[1]);
        $stmt->bindValue(3,$evento[2]);
        $stmt->bindValue(4,$evento[3]);
        $stmt->bindValue(5,$user);

        if ($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
    //-------FUNCION PARA CERRAR LA BASE DE DATOS------
    public static function closeDB(){
        self::$dbh = null;
    }
    
}



?>