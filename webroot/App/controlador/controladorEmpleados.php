<?php

// -------Controlador que realiza la reserva de salas--------

include_once 'App/config.php';
include_once 'App/modelo/modeloDB.php';


//-----Inicio Muestra o procesa el formulario (POST)------

function ctlInicio(){
    modeloDB::init();
    $msg = "";
    $user ="";
    $password ="";
    if ( $_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['user']) && isset($_POST['password'])){
            $user =$_POST['user'];
            $password=$_POST['password'];
            if ( modeloDB::OkUser($user,$password)){
               
                $_SESSION['user'] = $user;
                header('Location:index.php?orden=VerReserva');
                }
               
            else {
                $msg="Error: usuario y contrase�a no v�lidos.";
                
                include_once 'App/plantilla/principal.php';
                session_destroy();
            }
        }

    }else{
    include_once 'App/plantilla/principal.php';
    }   
}


function ctlVerReserva(){
    
    modeloDB::recoverData();
  
    include_once 'App/plantilla/reservaEmpleado.php';
    
}

function ctlAgregar(){
    
    
    $msg = "";
    $fecha = "";
    $titulo = "";
    $hora = "";
    $descripcion = "";
    $color = "";
    $user="";
   
   
        if (isset($_POST['txtFecha']) && isset($_POST['txtTitulo']) && isset($_POST['txtHora'])) {
           
            $titulo = $_POST['txtTitulo'];
            
        
            $start = $_POST['txtFecha']." ".$_POST['txtHora'];
            $descripcion = $_POST['txtDescripcion'];
            $color = $_POST['txtColor'];
          
            $evento = [
                $titulo,
                $descripcion,
                $color,
                $start
                
             
            ];
            $user = $_SESSION['user'];
           
            if(modeloDB::saveEvent($evento,$user)){
                modeloDB::recoverData();
                
                header('Location:index.php?orden=VerReserva');
               
                
            }
            
                
        } else {
            
            header('Location:index.php?orden=VerReserva');
        }
    
}
//--------Cierra la sesi�n--------
function ctlCerrar(){
    session_destroy();
    modeloDB::closeDB();
    header('Location:index.php');
}



?>