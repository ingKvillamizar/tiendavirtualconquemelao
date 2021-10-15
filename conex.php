<?php include "global.php";

$link = mysqli_connect(HOST, USER, PASSWORD, DB);

if (!$link) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

error_reporting(E_ERROR | E_PARSE);

				function consultar($sql,$link){
						$sql_a=mysqli_query($link,$sql);
						if ($sql_a){
							list($r)=mysqli_fetch_array($sql_a);
							return($r);
							}
						else
						{
							return false;
							}	
						}

						mysqli_query ($link,"SET NAMES 'utf8'");



function generarCodigo($longitud) {
 $key = '';
 $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTWUYZ';
 $max = strlen($pattern)-1;
 for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
 return $key;
}



function fpreciosD($precio){
	
	return number_format($precio,2,",",".");
	
}					
function limpiar($link,$value)
{
					
$_Cadena = htmlspecialchars(trim(addslashes(stripslashes(strip_tags($value)))));
$_Cadena = str_replace(chr(160),"",$_Cadena);
return mysqli_real_escape_string($link,$_Cadena);
										
}					
						
function eliminar($tabla,$id,$link){
	mysqli_query($link,"delete from ".$tabla." where id=".$id."");
	$sms="Eliminado satisfactoriamente";
	return $sms;
}						
function extension($string){
	
	if(strpos($string,'.jpg')==true){
		  $ext ="jpg"; 
	}else if(strpos($string,'.JPG')==true){
		  $ext ="JPG"; 
	}else if(strpos($string,'.jpeg')==true){
		   $ext ="jpeg"; 
	}
	else if(strpos($string,'.png')==true){
		   $ext ="png"; 
	}else{
		   $ext =""; 
	}
	return $ext;
	
	
}


function fprecios($precio){
	
	return number_format($precio,2,".",",");
	
}					

function getSubString130($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 130;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}
						
function getSubString($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 140;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}						
function getSubString2($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 80;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}
function getSubString3($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 35;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}
function url($cadena)
{
	 $cadena = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $cadena
    );
 
    $cadena = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $cadena );
 
    $cadena = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $cadena );
 
    $cadena = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $cadena );
 
    $cadena = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $cadena );
 
    $cadena = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $cadena
    );
	$cadena = str_replace(" ","-",trim($cadena));
	$cadena = str_replace("%","-por-ciento",$cadena);
	$cadena = str_replace("(","",$cadena);
	$cadena = str_replace(")","",$cadena);
	$cadena = str_replace("+","",$cadena);
	$cadena = str_replace("!","",$cadena);
	$cadena = str_replace("----","-",$cadena);
	$cadena = str_replace("---","-",$cadena);
	$cadena = str_replace("--","-",$cadena);
	$cadena = str_replace("/","",$cadena);
	$cadena = str_replace("¡","",$cadena);
	$cadena = str_replace(":","",$cadena);
	$cadena = str_replace("’","",$cadena);
	$cadena = str_replace("“","",$cadena);
	$cadena = str_replace("&","and",$cadena);
	$cadena = str_replace("”","",$cadena);
	$cadena = str_replace("?","",$cadena);
	$cadena = str_replace("¿","",$cadena);
	$cadena = str_replace("#","",$cadena);
	$cadena = str_replace(".","-",$cadena);
	$cadena = str_replace("'","-",$cadena);
	$cadena = str_replace("´","-",$cadena);
	$cadena = str_replace("*","-",$cadena);
	$cadena = str_replace('"',"",$cadena);
	$cadena = str_replace(',',"",$cadena);
	$cadena = str_replace(':',"",$cadena);
	$cadena = str_replace('$',"",$cadena);
	$cadena=strtolower($cadena);
	return $cadena;
}


function voltear($fecha){
	
	$espa=explode(" ",$fecha);
	
	
	$fecha1=explode("-",$espa[0]);
	
	$fecha=$fecha1[2]."/".$fecha1[1]."/".$fecha1[0]." ".$espa[1];
	
	return $fecha;
}

function formatDateDiff($start, $end=null) {
    if(!($start instanceof DateTime)) {
        $start = new DateTime($start);
    }
   
    if($end === null) {
        $end = new DateTime();
    }
   
    if(!($end instanceof DateTime)) {
        $end = new DateTime($start);
    }
   
    $interval = $end->diff($start); 
	//$doPlural = function($nb,$str){return $nb>1?$str.'s':$str;}; // adds plurals
   
    $format = array();
    if($interval->y !== 0) {
        $format[] = "%y ".doPlural($interval->y, "a&ntilde;o");
    }
    if($interval->m !== 0) {
        $format[] = "%m ".doPlural($interval->m, "mes");
    }
    if($interval->d !== 0) {
        $format[] = "%d ".doPlural($interval->d, "d&iacute;a");
    }
    if($interval->h !== 0) {
        $format[] = "%h ".doPlural($interval->h, "hr");
    }
    if($interval->i !== 0) {
        $format[] = "%i ".doPlural($interval->i, "min");
    }
    if($interval->s !== 0) {
        if(!count($format)) {
            return "menos de 1 minuto";
        } else {
            $format[] = "%s ".doPlural($interval->s, "seg");
        }
    }
   
    // We use the two biggest parts
    if(count($format) > 1) {
        $format = array_shift($format)." y ".array_shift($format);
    } else {
        $format = array_pop($format);
    }
   
    // Prepend 'since ' or whatever you like
    return "Hace ".$interval->format($format);
}
?>

