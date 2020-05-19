<?php

$auto = $_SERVER['PHP_SELF'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Javier y Olga" />
    <title>RoomView</title>
    
    <!-- BOOTSTRAP CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
    
    <script src='Web/js/fullcalendar/jquery.min.js'></script>
	<script src='Web/js/fullcalendar/moment.min.js'></script>
    
    <!-- FULLCALENDAR CSS-->
     <link href='Web/css/fullcalendar/fullcalendar.min.css' rel='stylesheet' />
     <script src='Web/js/fullcalendar/fullcalendar.min.js'></script>
    
	<!-- FULLCALENDAR JS PLUGINS-->
	
	<script src='Web/js/fullcalendar/es.js'></script>

    <!-- BOOTSTRAP JS -->
    
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
   	
    
	<!-- CUSTOM CSS -->
    <link rel="stylesheet" href="Web/css/main.css">
    <link rel="shortcut icon" type="image/x-icon" href="Web/favicon/favicon.ico" />
    
	
	
	<script>

    	$(document).ready(function(){
        	$('#calendar').fullCalendar({
				header:{
					left:'today,prev,next,Miboton',
					center:'title',
					right:'month,basicWeek,agendaWeek,agendaDay'
				},

				customButtons:{
					Miboton:{
						text:"Boton",
						click:function(){
							alert("accion");
						}
					}
				},

				dayClick:function(date,jsEvent,view){

					$('#txtFecha').val(date.format());
					$("#ModalReserva").modal();
				},

				

					events:'App/dat/reserva.json',
				
				

				eventClick:function(calEvent,jsEvent,view){

						$('#tituloEvento').html(calEvent.title);

						//Mostrar info de inputs
						$('#txtDescripcion').val(calEvent.descripcion);
						$('#txtID').val(calEvent.id);
						$('#txtTitulo').val(calEvent.title);
						$('#txtColor').val(calEvent.color);

						//Convierte el elemento en fecha y hora
						FechaHora= calEvent.start._i.split(" ");
						$('#txtFecha').val(FechaHora[0]);
						$('#txtHora').val(FechaHora[1]);


						
						$("#ModalReserva").modal();
				}
				
				
			});
    	});
    </script>



</head>

<body>
    <!-- CABECERA -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <img src="Web/img/logo.png" style="width: 20%" alt="logo bootstrap">
			<a href="<?= $auto?>?orden=Cerrar"><img src="Web/img/logout.png"></a>
        </div>
        </div>
    </nav>

    <!-- CONTENIDO-->
   
           <div id="calendar"></div>
	
			<!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
          Launch demo modal
        </button>
        
        
         <!-- Modal para crear reserva -->
        <div class="modal fade" id="ModalReserva" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="tituloEvento"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <form  method="post" action="index.php?orden=Agregar">
              <div class="modal-body">
                <div id="descripcionEvento"></div>
               <b><?= (isset($msg))?$msg:"" ?></b>
              
                Id<input type="text" id="txtID" name="txtID">
                Fecha <input type="text" id="txtFecha" name="txtFecha"><br>
                Titulo <input type="text" id="txtTitulo" name="txtTitulo"><br>
                Hora <input type="text" id="txtHora" name="txtHora"><br>
                Descripcion <textarea id="txtDescripcion" name="txtDescripcion" rows="3"></textarea><br>
                Color <input type="color" id="txtColor" name="txtColor"><br>
               
              </div>
              <div class="modal-footer">
         
              	<input  type="submit" name="orden" value="Agregar" id="agregar" class="btn btn-success">
            
              
              
              	<input type="submit" name="orden" value="Modificar" class="btn btn-success" data-dismiss="modal">
            
              	
              
              	<input type="submit" name="orden" value="Borrar" class="btn btn-danger" data-dismiss="modal">
          
             
                <button type="button" class="btn btn-default">Cancelar</button>
              </div>
               </form>
            </div>
          </div>
        </div>
        
    <script>

    var NuevoEvento;
    
	$('#agregar').click(function(){
			capturarDatos();
			$('#calendar').fullCalendar('renderEvent',NuevoEvento);
			$("#ModalReserva").modal('toggle');
			
	});

	function capturarDatos(){
		 NuevoEvento = {
				    id:$('#txtID').val(),
					title:$('#txtTitulo').val(),
					start:$('#txtFecha').val()+" "+$('#txtHora').val(),
					color:$('#txtColor').val(),
					descripcion:$('#txtDescripcion').val(),
					textColor:"#ffffff"

			};
			
	

	}
	


    </script>
           
</body>

</html>