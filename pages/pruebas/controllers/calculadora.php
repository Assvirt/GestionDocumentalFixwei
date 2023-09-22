<?php
// llamado a la conexión de la base de datos
 require_once 'bd.php';

/// captura de datos
	$valueReg1 = $_POST['reg1']; // numero 1
    $valueReg2 = $_POST['reg2']; // numero 1
    $valueReg3 = $_POST['reg3']; // operacion 

/// validamos que los campos sean obligatorios
if($valueReg1 != NULL && $valueReg2 != NULL && $valueReg3 != NULL){

    // declaramos una clase
    class matematica{
        /// declaramos fuciones estaticas para las operaciones matematicas
        public static function sumar($valueReg1,$valueReg2){
                
            $resultado = $valueReg1 + $valueReg2;
            return $resultado;
        }
        public static function restar($valueReg1,$valueReg2){
                
            $resultado = $valueReg1 - $valueReg2;
            return $resultado;
        }
        public static function multiplicar($valueReg1,$valueReg2){
                
            $resultado = $valueReg1 * $valueReg2;
            return $resultado;
        }
        public static function dividir($valueReg1,$valueReg2){
            
            $resultado = $valueReg1 / $valueReg2;
            return $resultado;
            
        }

        /// funcion para la validacion de división
        public static function ValidacionDividir($valueReg1,$valueReg2,$valueReg3){
            
            //se valida que no se puede divir en 0
            if( $valueReg2 == 0 && $valueReg3 == 'dividir'){
                
               $resultado='error';
               return $resultado;
                
            }else{
                
                  $resultado=matematica::dividir($valueReg1,$valueReg2);
                return $resultado;
            }
            
        }
    } 

    // enviamos los datos por parametros
    if($valueReg3 == 'sumar'){
        echo $resultado=matematica::sumar($valueReg1,$valueReg2);;
    }elseif($valueReg3 == 'restar'){
        echo $resultado=matematica::restar($valueReg1,$valueReg2);;
    }elseif($valueReg3 == 'multiplicar'){
        echo $resultado=matematica::multiplicar($valueReg1,$valueReg2);;
    }elseif($valueReg3 == 'dividir'){
        echo $resultado=matematica::ValidacionDividir($valueReg1,$valueReg2,$valueReg3);
    }


    if( $resultado == 'error'){ /// en caso que la validacion de la división en o nos vote error nos activa el mensaje y no registra, caso contrario almacena

    }else{
        $mysqli->query("INSERT INTO resultados (numero1, numero2, operacion, resultado)VALUES('$valueReg1', '$valueReg2', '$valueReg3', '$resultado')");
    }

}else{
        echo 'vacio';
}
?>