<?php
require_once 'alumno.entidad.php';
require_once 'alumno.model.php';

// Logica
$alm = new Alumno();
$model = new AlumnoModel();
$name_err = '';
if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id',              $_REQUEST['id']);
			$alm->__SET('Nombre',          $_REQUEST['Nombre']);
			$alm->__SET('Apellido',        $_REQUEST['Apellido']);
			$alm->__SET('Sexo',            $_REQUEST['Sexo']);
			$alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);

			$model->Actualizar($alm);
			header('Location: index.php');
			break;

		case 'registrar':		
		  	$input_nombre=$_REQUEST['Nombre'];
    		if(empty($input_nombre)){
        		$nombre_err = "Introduzca un nombre.";
    		} elseif(!filter_var(trim($_REQUEST['Nombre']), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        		$nombre_err = 'Introduzca un nombre válido.';
        	} 
        	else{
        		$nombre = $input_nombre;
        	}
        	
        	$input_apellido=$_REQUEST['Apellido'];
    		if(empty($input_apellido)){
        		$apellido_err = "Introduzca un apellido.";
    		} elseif(!filter_var(trim($_REQUEST['Apellido']), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        		$apellido_err = 'Introduzca un apellido válido.';
        	} 
        	else{
        		$apellido = $input_apellido;
        	}    	        	   		  		
    		if(empty($nombre_err) && empty($apellido_err)){ 		
		   	$alm->__SET('Nombre',          $_REQUEST['Nombre']);
				$alm->__SET('Apellido',        $_REQUEST['Apellido']);
				$alm->__SET('Sexo',            $_REQUEST['Sexo']);
				$alm->__SET('FechaNacimiento', $_REQUEST['FechaNacimiento']);

				$model->Registrar($alm);
				//header('Location: index.php');
		   }
		   break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: index.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['id']);
			break;		
	}
}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Gestion de Alumnos</title>
		<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $alm->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id" value="<?php echo $alm->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            	
                            		<td><input type="text" name="Nombre" value="<?php echo $alm->__GET('Nombre'); ?>" style="width:100%;" />
                            			<div class="form-group <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
                            				<span class="help-block"><?php echo $nombre_err;?></span>
                        	  			</div>
                            	  	</td>
                                 
                        </tr>
                        <tr>
                            <th style="text-align:left;">Apellido</th>
                            <td><input type="text" name="Apellido" value="<?php echo $alm->__GET('Apellido'); ?>" style="width:100%;" />
											<div class="form-group <?php echo (!empty($apellido_err)) ? 'has-error' : ''; ?>">
                            				<span class="help-block"><?php echo $apellido_err;?></span>
                        	  		</div>                            
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Sexo</th>
                            <td>
                                <select name="Sexo" style="width:100%;">
                                    <option value="1" <?php echo $alm->__GET('Sexo') == 1 ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="2" <?php echo $alm->__GET('Sexo') == 2 ? 'selected' : ''; ?>>Femenino</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Fecha</th>
                            <td><input type="text" name="FechaNacimiento" value="<?php echo $alm->__GET('FechaNacimiento'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            <th style="text-align:left;">Apellido</th>
                            <th style="text-align:left;">Sexo</th>
                            <th style="text-align:left;">Nacimiento</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Nombre'); ?></td>
                            <td><?php echo $r->__GET('Apellido'); ?></td>
                            <td><?php echo $r->__GET('Sexo') == 1 ? 'H' : 'F'; ?></td>
                            <td><?php echo $r->__GET('FechaNacimiento'); ?></td>
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>                                                                         
                </table>
                <br>
                	<h3>Listado de Masculinos</h3>
                <br>
                
                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            <th style="text-align:left;">Apellido</th>
                            <th style="text-align:left;">Sexo</th>
                            <th style="text-align:left;">Nacimiento</th>

	                      </tr>
                    </thead>
                    <?php foreach($model->ListarSexo('M') as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Nombre'); ?></td>
                            <td><?php echo $r->__GET('Apellido'); ?></td>
                            <td><?php echo $r->__GET('Sexo') == 1 ? 'H' : 'F'; ?></td>
                            <td><?php echo $r->__GET('FechaNacimiento'); ?></td>                                              
                        </tr>
                    <?php endforeach; ?>
              	</table>
                      
                <br>
                	<h3>Listado de Femeninas</h3>
                <br>
                
                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Nombre</th>
                            <th style="text-align:left;">Apellido</th>
                            <th style="text-align:left;">Sexo</th>
                            <th style="text-align:left;">Nacimiento</th>

	                      </tr>
                    </thead>
                    <?php foreach($model->ListarSexo('F') as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Nombre'); ?></td>
                            <td><?php echo $r->__GET('Apellido'); ?></td>
                            <td><?php echo $r->__GET('Sexo') == 1 ? 'H' : 'F'; ?></td>
                            <td><?php echo $r->__GET('FechaNacimiento'); ?></td>                                              
                        </tr>
                    <?php endforeach; ?>  
                    
                </table>  
                                                                                      
                     
                
                
            </div>
        </div>

    </body>
</html>