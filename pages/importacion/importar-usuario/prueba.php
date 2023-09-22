<?php
function eliminar_acentos($centroTrabajo){
		
                            		//Reemplazamos la A y a
                            		$centroTrabajo = str_replace(
                            		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
                            		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
                            		$centroTrabajo
                            		);
                            
                            		//Reemplazamos la E y e
                            		$centroTrabajo = str_replace(
                            		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
                            		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la I y i
                            		$centroTrabajo = str_replace(
                            		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
                            		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la O y o
                            		$centroTrabajo = str_replace(
                            		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
                            		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la U y u
                            		$centroTrabajo = str_replace(
                            		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
                            		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
                            		$centroTrabajo );
                            
                            		//Reemplazamos la N, n, C y c
                            		$centroTrabajo = str_replace(
                            		array('Ñ', 'ñ', 'Ç', 'ç'),
                            		array('N', 'n', 'C', 'c'),
                            		$centroTrabajo
                            		);
                            		
                            		return $centroTrabajo;
                            	}
                            	echo $centroTrabajo='bogotá;cali;cartagena';
                            	echo '<br>';
                            	echo $centroTrabajo=eliminar_acentos($centroTrabajo);
                            	
                            	echo '<br>';echo '<br>';
                            	
                            	echo $centroTrabajo='bogotá;cali;cartagena';
                            	echo '<br>';
                            	echo $centroTrabajo=eliminar_acentos($centroTrabajo);
                            	
                            	echo '<br>';echo '<br>';
                            	
                            	echo $centroTrabajo='bogotá;cali;cartagena';
                            	echo '<br>';
                            	echo $centroTrabajo=eliminar_acentos($centroTrabajo);
                            	
                            	echo '<br>';echo '<br>';
                            	
                            	echo $centroTrabajo='bogotá;cali;cartagena';
                            	echo '<br>';
                            	echo $centroTrabajo=eliminar_acentos($centroTrabajo);
                            	
                            	
      echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';                      	
                            	
                            	/* Función que elimina los acantos y letras ñ*/
function quitar_acentos($cadena){
    $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';
    $cadena = utf8_decode($cadena);
    $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
    return utf8_encode($cadena);
}
 
/*Haciendo una prueba de la función*/
echo quitar_acentos('ProgramaciónExterma.com');
/*Haciendo una prueba de la función*/
echo quitar_acentos('ProgramaciónExterma.com');
/*Haciendo una prueba de la función*/
echo quitar_acentos('ProgramaciónExterma.com');
/*Haciendo una prueba de la función*/
echo quitar_acentos('ProgramaciónExterma.com');


?>