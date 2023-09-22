<?php
session_start(); error_reporting(E_ERROR);
if(!isset($_SESSION["session_username"])){
    require_once'cierreSesion.php';
}else{
require_once 'inactividad.php';

///////// notificaciones para plataforma y correo
require_once 'conexion/bd.php';
$formulario = 'usuarios'; //Se cambia el nombre del formulario
$documento = $_SESSION["session_username"];
$queryGrupos = $mysqli->query("SELECT * FROM grupoUusuario WHERE idUsuario = '$documento'");

while($row = $queryGrupos->fetch_assoc()){
    $idGrupo = $row['idGrupo'];
    
    $queryPermisos = $mysqli->query("SELECT * FROM permisosNotificaciones WHERE idGrupo = '$idGrupo' AND formulario = '$formulario'");
    
    $permisos = $queryPermisos->fetch_array(MYSQLI_ASSOC);
    if($permisos['plataforma'] == TRUE){
        $permisoPlataforma = $permisos['plataforma'];    
    }
    if($permisos['correo'] == TRUE){
        $permisoCorreo = $permisos['correo'];    
    }
    
}

if($permisoPlataforma == FALSE){
    $visibleP = 'none';
}else{
    $visibleP = '';
}

if($permisoCorreo == FALSE){
    $visibleC = 'none';
}else{
    $visibleC = '';
}

//////// fin notificaciones correo plataforma
?>
<!DOCTYPE html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FIXWEI - Aplicar</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- grafica -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- EDN -->
</head>
<script>
   	
    function nobackbutton(){
    	
       window.location.hash="no-back-button";
    	
       window.location.hash="Again-No-back-button" //chrome
    	
       window.onhashchange=function(){window.location.hash="no-back-button";}
    	
    }
</script>
<body class="hold-transition sidebar-mini" onload="nobackbutton();" oncopy="return false" onpaste="return false" >
<div class="wrapper">


  <!-- Main Sidebar Container -->
  <?php echo require_once'menu.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <?php 
              $quienCrea=$_POST['quienCrea'];
               
                    $muestraCalculadora=$_POST['calculadoraMostrar'];
                    $variablesIdPrincipal=$_POST['variablesIdPrincipal'];
                   
                                /// se trae el ��ltimo indicador que realizo el usuario
                                //$quienCrea;
                                $acentos = $mysqli->query("SET NAMES 'utf8'");
                                $ultimoIndicado=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal'  ");
                                $extraeDatoIndicador= $ultimoIndicado->fetch_array(MYSQLI_ASSOC);
                                $ultimoIndicadorSale=$extraeDatoIndicador['id'];
                                $nombreIndicador=$extraeDatoIndicador['nombre'];
                                $formulaMostrar=$extraeDatoIndicador['formula'];
                                $formulaQuienCrea=$extraeDatoIndicador['quienCrea'];
                                
                                
                              
                                ?>
            <h1>Gestionar Indicadores</h1> 
          </div>
          
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="home">Inicio</a></li>
              <li class="breadcrumb-item active">Gestionar indicadores</li>
            </ol>
          </div>
        </div>
        <div>
            <div class="row">
                <div class="col">
                    
                </div>
                <div class="col-9">
                    <div class="row">
                        <div class="col-sm-3">
                            <form action="indicadoresGestionar" method="POST">
                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" readonly type="hidden" required>
                            <button type="submit" class="btn btn-block btn-success btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Regresar</font></a></button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-block btn-info btn-sm"><a href="indicadores"><font color="white"><i class="fas fa-list"></i> Listar indicadores</font></a></button>
                        </div>
                    </div>
                </div>
                <div class="col">
                    
                </div>
                
           
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.row -->
        <div class="row">
            <div class="col">
            </div>
            <div class="col-9">
               
                <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Aplicar fórmula para el indicador <b><?php echo $nombreIndicador; ?></b> del mes de <b><?php echo $mesIndicador=$_POST['mes']; ?></b> del año <b><?php echo $anoPresente=$_POST['anoPresente']; ?></b></h3>
              </div>
              <!-- /.card-header -->
               <div class="card-body">
                    <label>Fórmula</label>
                    <?php  echo ' " '.$formulaMostrar.' " '; ?>
                    
                    
                    <!-- se agregar calculadora más completa -->
                    
                    
                                            
                                                <!--- Primero el jquery -->
                                                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
                                                <!--- Estilos de la calculadora-->
                                                <style>
                                             
                                            input{
                                            font-size:13px;
                                            font-weight:bold;
                                            padding:5px;
                                            margin:5px; 
                                             } 
                                             
                                            #scientificCalc11 {
                                             font-size: 13px;
                                             margin: 0;
                                             color: #666;
                                             text-shadow: 1px 1px 2px #ffffff;
                                             font-weight:bold;
                                              font-family: "MuseoSans500Regular", sans-serif;
                                            }
                                            #scientificCalc11  cell{
                                             width:20%;
                                             font-weight:bold
                                             
                                             }
                                            #scientificCalc11  #results{
                                             width:250px;
                                             background-color:#CCC;
                                             height:20px;
                                             margin:5px;
                                             padding:3px; 
                                             }
                                             .calcbttn {
                                             border: 0px;
                                             cursor:pointer;
                                             font-family: "MuseoSans500Regular", sans-serif;
                                             text-shadow: 1px 1px 2px #ffffff;
                                             color: #666;
                                             
                                             padding-left: 8px;
                                             padding-right: 8px;
                                             
                                             font-size: 13px;
                                             
                                             background-repeat: no-repeat;
                                                background: #eee;
                                                background: -webkit-linear-gradient(#fff, #eee);
                                                background: -moz-linear-gradient(top,  #fff,  #eee);
                                                filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#eeeeee');
                                             
                                             -moz-box-shadow:    0px 1px 3px 0px #bcbcbc, inset 0 0 3px #ffffff;
                                             -webkit-box-shadow: 0px 1px 3px 0px #bcbcbc, inset 0 0 3px #ffffff;
                                             box-shadow:         0px 1px 3px 0px #bcbcbc, inset 0 0 3px #ffffff;
                                            }
                                            #errmsg{
                                             display:none;
                                             background-color:#F9F; 
                                             color:#900;
                                             border-width:2px;
                                             border-style:solid;
                                             border-color:#900;
                                             font-weight:bold;
                                            -webkit-border-radius: 5px;
                                            -moz-border-radius: 5px;
                                            border-radius: 5px;
                                             
                                             } 
                                             
                                            </style> <!-- the main script follows: -->
                                                <script>
                                             $(window).ready(function(){
                                            
                                            var debug = false;
                                            var input = $("#calc_tb");
                                            var $posfix = $("#posfix");
                                            var $answer = $("#answer");
                                            var bFirstTime = true;
                                            var $results =  $("#results");
                                            var bWasNumeric =false;
                                            var bisNumeric = false;  
                                            var $rb =$("#radians_rb");
                                            
                                            // if(debug)$results.html('1 +sin(30) + cos(60) + 2.1')
                                              
                                            
                                            
                                            var functions = [ 'sqrt' , 'cos' , 'sin' , 'log10', 'ln'  ,'abs' ,'tan'  ] 
                                            
                                              function isOperand(elem, bAllowParenthesis){
                                              elem = $.trim( elem) ;
                                              
                                               if(bAllowParenthesis && ( elem == '(' || elem == ')' ) )
                                                 return true;
                                              return (elem == '+' || elem == '-' || elem == '*' || elem =='/' || elem == '^'  );
                                              }
                                             
                                             
                                            
                                             function displayError(msg, data)
                                              {
                                              var h ='' 
                                              if(msg =='mismatched_parenthesis')
                                               h = ' Sus paréntesis no están equilibradas'; 
                                              else if(msg == 'too_many_decimals')
                                               h = ('Ha introducido un número con muchos decimales');
                                              else if(msg == 'number_parse_problem')
                                               h = ('No se entiende el siguiente término-->' + data); 
                                              else if(msg == 'rpn_pop_pop')
                                               h = ('No se ha podido procesar su expresion') //Sintaxis invalida'); 
                                              else if (msg == 'division_by_zero' )
                                               h = (' Está tratando de dividir por cero!' );
                                              else if (msg =='could_not_parse')
                                               h = ('No se puede procesar su expresion');
                                                $("#errmsg").css('display','block');
                                                $("#errmsg").html( h )
                                              } 
                                              
                                              
                                             function getFullNumber(str){
                                              var bFoundDot = false;
                                              var out="";
                                              for( var j = 0 ;j< str.length ; j++)
                                               {
                                                var currLett = str.substring(j, j + 1 )  ;
                                                 
                                                if(  '0123456789'.indexOf(currLett) != -1 )
                                                 out += currLett;
                                            
                                                else if( '.' == currLett && bFoundDot)
                                                  {
                                                  displayError('too_many_decimals');
                                                  break; 
                                                  }
                                                else if( '.' == currLett && bFoundDot== false)
                                                  {
                                                  out += currLett ;
                                                  bFoundDot =  true;
                                                  }
                                                else
                                                 break; 
                                               }
                                              return out;
                                              } 
                                              
                                            
                                            
                                              function toArr(data){
                                                     var bAllowParenthesis = true;
                                                var arr =[];
                                               for(var i = 0;i< data.length; i++)
                                                 {
                                                 var currLett = data.substring(i, i+1);
                                                if(currLett== ' ')  continue;
                                              //is a dot or is a digit
                                                var bisNumeric = currLett ==  '.' || '0123456789'.indexOf(currLett) != -1 ;
                                                if(bisNumeric   )
                                                 {//get the full number which could be several characters long
                                                 var fullNum = getFullNumber(data.substring(i ) ) 
                                                  var isOk = isNaN( +fullNum) == false; //one last check that it actually is a number
                                                 if(isOk )
                                                  arr.push( parseFloat( fullNum) +"") ;
                                                 else 
                                                  displayError('number_parse_problem', fullNum); 
                                                 i += fullNum.length-1; // -1 because i is i++ in loop
                                                 }
                                                 else if( isOperand( currLett, bAllowParenthesis) )
                                                 arr.push(currLett);
                                                }
                                                
                                              //there's got be a better way to do this..but it works ;)
                                               //support unary negative signs by finding them and putting them with numbers they preceed
                                               for( i = arr.length-1 ;i >= 0 ; i--)
                                                {
                                                 var token  = arr[i];
                                                 //look for negatives 
                                                 if(  arr[i] == '-' )
                                                  {
                                                   if( i ==0 && arr.length > 0)
                                                    {
                                                     arr[0] = '-' + arr[1];  
                                                     arr.splice(1,1);
                                                    } 
                                                   //negative preceded by an operand and  is a unary
                                                   else if ( i+ 1< data.length && i > 0 &&  isOperand(arr[i-1] , bAllowParenthesis )  && '0123456789.'.indexOf(arr[i+1] ))
                                                    {
                                                     arr[i] = '-'+ arr[i+1]  ;
                                                     arr.splice(i+1,1);
                                                    }
                                                  }
                                                } 
                                              return arr
                                               }
                                              
                                            
                                               
                                             function resetErr(){
                                               $("#errmsg").css('display','none')
                                              }
                                              
                                              input.focus(function(){
                                               if(bFirstTime)
                                                input.val('') 
                                               input.css('color','black');
                                               
                                               bFirstTime = false; 
                                               })
                                              
                                              function p( str){if (debug) console.log(str ) ; }
                                               
                                              function infixToPostfix(array){
                                               var i, operandStack = [];
                                                        var output=[] ;
                                               
                                                        var bAllowParenthesis = true;
                                               for( i = 0 ; i < array.length; i++)
                                                {
                                                var currentToken = $.trim( array[i] );
                                                if( isOperand( currentToken, bAllowParenthesis ))
                                                                {
                                                 p("I is operand " + currentToken + ', output : ' +output + ", operandStack: " +operandStack); 
                                                                if( operandStack.length == 0  )
                                                                    operandStack.push( currentToken );
                                                                 else if ( operandStack.length > 0 && currentToken == ')' )
                                                                    {
                                                   
                                                                        while (operandStack.length > 0 && operandStack[operandStack.length-1] != '(' )
                                                                            {
                                                    output. push( operandStack.pop());
                                                    }
                                                   p('\t B now, pop off ' +operandStack[operandStack.length-1] + ' Coloque paréntesis de cierre!' ); 
                                                   if(operandStack[operandStack.length-1]  != '(')
                                                    {
                                                    displayError('mismatched_parenthesis');  
                                                    return;
                                                    }
                                                                       operandStack.pop() ; // remove parenthesis
                                                                    }//                      
                                                  
                                                  else if( operandStack.length > 0 )
                                                                    {
                                                  p("II is operand " + currentToken + ', output : ' +output); 
                                                                     if( (operandStack[operandStack.length-1] ==  "(" && currentToken == "(" ||  ( currentToken != "(" ) && operatorToPrecedence(operandStack[operandStack.length-1]) >= operatorToPrecedence( currentToken) ) )
                                                                        {
                                                   p(" C  , operandStack : "+operandStack ); 
                                                                        while (operandStack.length > 0  && operandStack[operandStack.length-1] != "("   
                                                     && operatorToPrecedence(operandStack[operandStack.length-1]) >= operatorToPrecedence( currentToken) )
                                                                            {
                                                                               output.push( operandStack.pop()  );
                                            
                                                                            }
                                                                           
                                                      p('\t D now, pop off ' +operandStack[operandStack.length-1] );  
                                                       operandStack.push(currentToken) ;
                                                                        }
                                                                    else if ( operatorToPrecedence( operandStack[operandStack.length-1] ) < operatorToPrecedence( currentToken) )
                                                                            {
                                                     p('\t III operandStack[operandStack.length-1] ,' +operandStack[operandStack.length-1] + "< " + currentToken );  
                                                     operandStack.push( currentToken );
                                                    }
                                                                    }
                                                                }
                                                 
                                                 
                                                  // ELSE IT IS  ANUMBER
                                                    else if ( isNaN( +currentToken) == false) // ie it is a number
                                                                {
                                                 p("IV isNumber() currentToken = " +currentToken); 
                                                                output.push(currentToken)
                                                                }
                                                            }
                                                        while( operandStack.length > 0 )
                                                            output.push( operandStack.pop() ) ;
                                               
                                            
                                                    return output;
                                                    }
                                               
                                                 function  operatorToPrecedence( op){
                                                    if( op == "+" || op == "-" )
                                                        return 1;
                                                    else if( op== "*" || op == '/')
                                                        return 2;
                                                    else if (op == '^')
                                                        return 3;
                                                    else if (op == '(' || op == ')')
                                                        return 4;
                                                     else
                                                           throw ("Unknown operator =" +op + ',at  operatorToPrecedence()')
                                            
                                                    }
                                            
                                            
                                            ///this does not actually us a stack because the user has entered teh entire equation
                                            //
                                            
                                             function evaluateRPN( rpnArray )
                                              {
                                              var operandsStack = []; 
                                              var r = 0; 
                                              var i =0;
                                              var iterationCount = 0;
                                              
                                              while (rpnArray.length  > 1)
                                               {
                                                
                                               var currentToken =  $.trim(rpnArray[i]) ; 
                                              
                                               if( isOperand( currentToken ))
                                                {     //console.log(' isOperand()  ' + op);
                                                 var op = rpnArray.splice(i,1);
                                                 var insertAt = i-2;
                                                 i--;
                                                
                                                if(rpnArray.length < 2)
                                                 {
                                                   displayError('rpn_pop_pop')
                                                   return;
                                                 }
                                                 var n1Was =  rpnArray.splice(i,1);
                                                  i--;
                                                  var n2Was = rpnArray.splice(i,1);
                                                 
                                                 var n1 =parseFloat(n1Was );
                                                  var n2 =parseFloat( n2Was);
                                                 if( isNaN( +n1))
                                                  { 
                                                  console.log('n1 , ' + n1Was + ', is not a number. Parsing exiting now'); 
                                                  displayError('could_not_parse');//invalid_token_rpn', 'Invalid syntax. ' + n1Was + ' should be a number');
                                                  return ;
                                                  }
                                                   if( isNaN( +n2))
                                                  { 
                                                  displayError('could_not_parse');
                                                  console.log('n2 , ' + n2Was + ', is not a number. Parsing exiting now '); 
                                                  return ;
                                                  }      
                                                 
                                                 var pushMe = calculate( n2, n1, op);
                                                 rpnArray.splice(insertAt, 0, pushMe ); 
                                                 }
                                                else
                                                 i++;
                                                 
                                                
                                                if (iterationCount++ > 500 )
                                                {
                                                  displayError('could_not_parse');
                                                  console.log('get me outta here, there is something wrong');
                                                  return;
                                                } 
                                               }
                                            
                                              if(rpnArray.length != 1)
                                               {
                                               displayError('could_not_parse'); 
                                               console.log('unable to parse postfix expression : ' + rpnArray.toString().substring(1, rpnArray.toString().length-1) );
                                               }
                                               return rpnArray.pop();
                                             }
                                              
                                              
                                              
                                            function calculate (a,b,op){
                                               
                                               
                                              if( op == '+')
                                               return a + b; 
                                              else if( op == '-')
                                                return a - b; 
                                              else if( op == '*')
                                               return a * b; 
                                              else if( op == '^')
                                               return Math.pow(a,b);
                                               
                                              else if( op == '/')
                                               {
                                               if(b == 0)
                                                {
                                                displayError('division_by_zero');
                                                //throw ("division by zero");
                                                return; 
                                                }
                                               return a / b; 
                                               }
                                              
                                              }
                                            
                                            
                                            function replaceAllPis(){
                                             var data = new String($results.text()) ;
                                             if(data.indexOf('pi')  == -1)
                                              return;
                                              
                                             while( data.indexOf('pi') != -1)
                                              {
                                              var firstPart = data.substring(0,data.indexOf('pi') );
                                              var middle = Math.PI;
                                              var lastPart =  data.substring( data.indexOf('pi') + 2 )//
                                              data = firstPart + middle + lastPart;
                                              }
                                             $results.html(data) 
                                               
                                             }
                                            
                                               function  evaluateFuncts(){
                                               var finalString='';
                                               
                                               var bRadians =  $rb.is(":checked");
                                               var radDeg =  bRadians? 1 : ( Math.PI/180 );
                                               
                                               replaceAllPis();
                                               
                                                for(var i = 0 ; i < functions.length ; i++)
                                                {
                                                var data = new String($results.text()) ;
                                                var fxn= functions[i];
                                                var c =0;
                                               
                                                  
                                                var firstRun = true ;  
                                                while(data.indexOf(fxn ) != -1 && c++ < 5)
                                                  {
                                                  if(firstRun  )
                                                   {
                                                   p('fxn: ' + fxn + ', data : ' +data);
                                                   firstRun =false; 
                                                   }
                                                  var inject ='inject'
                                                  var iStart = data.indexOf(fxn );
                                                  var temp = data.substring(iStart + fxn.length );
                                                  var iEnd = temp.indexOf( ')' ) +1;
                                                  var lastPart  = temp.substring(iEnd);;
                                                 
                                                  temp = temp.substring( 0 ,iEnd);  // this is ( 60) for something like cos(60)
                                                  
                                                  
                                            
                                                  var number =  temp.substring(temp.indexOf('(')+1 ,  temp.indexOf(')' ));
                                                  
                                                  if( isNaN( +number))
                                                   console.log('problem parsing number = ' +number);
                                                  number = parseFloat (number);
                                                  
                                                  if(fxn == 'sin')
                                                   {
                                                   console.log('radDeg * number ' +(radDeg * number));
                                                   inject = Math.sin(radDeg * number);
                                                   console.log('Math.sin(radDeg * number)   Math.sin(' + (radDeg * number) +')= ' +inject  ); 
                                                   }
                                                  else if(fxn == 'cos')
                                                   inject = Math.cos(radDeg * number);
                                                  else if(fxn == 'tan')
                                                   inject = Math.tan(radDeg * number);
                                                  else if(fxn == 'sqrt')
                                                   inject = Math.sqrt(number);
                                                  else if(fxn == 'log10')
                                                   inject = Math.LOG10E(number);
                                                  else if(fxn == 'ln')
                                                   inject = Math.LN10(number);
                                                  else if(fxn == 'abs')
                                                   inject = Math.abs(number);
                                                   
                                                        
                                                  
                                                  var firstPart = data.substring(0,iStart);
                                                   
                                                  
                                                  data = firstPart + ' ' + inject + ' ' + lastPart;
                                                  $results.text( data )
                                                  }
                                                 
                                                
                                                }  
                                               
                                               }
                                              
                                              
                                             
                                             
                                             $(".calcbttn").click(function(){
                                              resetErr();
                                                  
                                              bisNumeric =false;
                                              
                                               var val = $(this).val()
                                               var inject=''
                                             
                                              if( $.inArray (val, functions) != -1 )
                                                {
                                                
                                                inject = ( bWasNumeric ? ' * ' : '' ) + val +'('
                                               }
                                              else if( val == 'del')
                                               {
                                               {
                                               var data = new String($results.text()) ; 
                                               if(data.length == 0 )
                                                 return;
                                               else if(data.length == 1 && data == ' ')
                                                return;
                                                
                                               var lastLttr = data.substring(data.length-1 );
                                               if(lastLttr == ' ')
                                                data =  data.substring(0, data.length-2) ;
                                               
                                               else
                                                data =  data.substring(0, data.length-1) ;
                                               
                                               $results.html (data);
                                               return;  
                                               } 
                                               }
                                              else if(val == 'C')
                                                {
                                               $results.html('')
                                               return;  
                                               }
                                              else if (val == 'parenleft')
                                               inject = '(' ;
                                              else if (val == 'parenright')
                                               inject = ')' ;
                                              else if(val== '=')
                                               {
                                               evaluateFuncts(); 
                                                
                                               var  arr = toArr($results.text());
                                               arr = infixToPostfix(arr) ;
                                               var theResult= evaluateRPN(arr); 
                                               $results .html (theResult); 
                                               return;
                                               }
                                              else if( val == 'pi')
                                               {
                                               inject = 'pi'
                                               bisNumeric = true;
                                               } 
                                              else
                                               {
                                               if( isNaN(+val ) == false || val == '.')
                                                bisNumeric = true;
                                                inject = val;  
                                               }
                                              // console.log( $(this).val() +  ' was clicked ');
                                               var space = (bWasNumeric && bisNumeric ) ? '' : ' ';
                                               $results .html ( $results.html() +  space + inject );
                                             
                                              
                                              
                                               bWasNumeric = bisNumeric; 
                                              
                                            
                                               })
                                              
                                              
                                             $("#clear").click(function(){
                                              input.val('');
                                              })
                                             
                                             
                                             
                                              })
                                             
                                             </script>
                                                <!-- now the html part -->
                                                <div id="scientificCalc11">
                                                  <div id="errmsg"></div>
                                                  
                                               
                                                 <?php 
                                                 // echo $formulaGuardar="<div style='width: 286px; text-align: center; margin-left: 8px;' id='results'></div>"; ?>
                                                 <!--<script>
                                                  $(document).ready(function(){
                                                    $("#results").click(function(){
                                                      var fechas_rango = $("#texto").text();
                                                      alert(fechas_rango);
                                                    });
                                                  });
                                                </script> -->
                                                <!--
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="" value="33" size="36px" id="capturaVariable" name="ecuacion"><br>
                                                
                                                <input type="button" onclick="alert('el contenido del div es:'+document.getElementById('results').inner HTML);" value="ver div" />
                                                
                                                <button onclick="funcionFormula()" type="submit" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Validar fórmula</button>
                                                
                                                <input style="background:#666;color:white;padding:9px;width:100%;color:white;" name="formula" id="capturarFormula" type="" value=""  size="36px" required>
                                                <script type="text/javascript">
                                                    document.getElementById("resultadoTotal").value = results;
                                                </script>
                                                -->
                                                
                                               <div style="width: 286px; text-align: center; margin-left: 8px;" id="results"></div>
                                                
                                                
                                                
                                                <script>
                                                    function funcionFormula() {
                                                        /*alert("entre");
                                                        alert(document.getElementById("results").innerHTML);*/
                                                       
                                                      document.getElementById("resultadoTotal").value = document.getElementById("results").innerHTML;
                                                    }
                                                </script>
                                                <br>
                                                
                                                <form action="" method="POST">
                                                <!-- para almacenar los datos que se registraron en la variable -->
                                                <input name="reci" id="reci" type="hidden">
                                                <!-- END -->
                                                <button onclick="funcionFormula()" type="submit" name="aplicarVariableUpdate" id="aplicarVariableUpdate"  style="display:none;background:black;color:white;border-color:black;">Validar fórmula</button>
                                                <font color="" id="AvisoValidarBoton">Haga clic en el signo ( = ) y proceda dando clic en "Validar Fórmula"</font>
                                                <br>
                                                <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" readonly type="hidden" required>
                                                <br>
                                                <?php
                                                $ultimoIndicadoMes=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mesIndicador' AND anoPresente='$anoPresente' ");
                                                $extraeDatoIndicadorMes= $ultimoIndicadoMes->fetch_array(MYSQLI_ASSOC);
                                                echo 'Resultado para el mes de '.$extraeDatoIndicadorMes['mes'];
                                                echo '<br>resultado: '.$DatoAlimentado=$extraeDatoIndicadorMes['alimentado'];
                                                
                                                ?><br>
                                                <input value="<?php echo $mesIndicador; ?>" type="hidden" readonly name="mes">
                                                <input type="hidden" name="resultadoTotal" id="resultadoTotal" value="<?php echo $respaldoResultado=$_POST['resultadoTotal'];?>" require>
                                                <input name="anoPresente" value="<?php echo $anoPresente; ?>" readonly type="hidden">
                                                </form>
                                                <?php
                                                $datosDeFormula=$_POST['reci'];
                                                $alimentado=$_POST['resultadoTotal'];
                                                $mesIndicadorEntrando=$_POST['mes'];
                                                $anoPresente=$_POST['anoPresente'];
                                                if(isset($_POST['aplicarVariableUpdate'])){ 
                                                    //$mysqli->query("UPDATE indicadores SET alimentado='$alimentado' WHERE id='$variablesIdPrincipal' ");
                                                    $consularExistencia=$mysqli->query("SELECT * FROM `indicadoresGestionar` WHERE idIndicador='$variablesIdPrincipal' AND mes='$mesIndicadorEntrando' AND anoPresente='$anoPresente' ");
                                                    $verificarExistencia= $consularExistencia->fetch_array(MYSQLI_ASSOC);
                                                    $verificarExistencia['mes'];
                                                    $verificarExistencia['idIndicador'];
                                                    $verificarExistencia['anoPresente'];
                                                    
                                                    ///// verificamos si existe, en caso que no exista debe registrarme
                                                    if($verificarExistencia['mes'] == $mesIndicadorEntrando && $verificarExistencia['idIndicador'] == $variablesIdPrincipal && $verificarExistencia['anoPresente'] == $anoPresente){ 
                                                         //echo 'Me actualiza si el registro existe';
                                                        $mysqli->query("UPDATE indicadoresGestionar SET alimentado='$alimentado', datosFormula='$datosDeFormula' WHERE idIndicador='$variablesIdPrincipal' AND mes='$mesIndicadorEntrando' AND anoPresente='$anoPresente'  ");
                                                    }else{ //echo 'Registra el dato para realizar la validación del indicador';
                                                        $mysqli->query("INSERT INTO indicadoresGestionar (alimentado,idIndicador,mes,anoPresente,quienCrea,nombreG,datosFormula)VALUES('$alimentado','$variablesIdPrincipal','$mesIndicadorEntrando','$anoPresente','$formulaQuienCrea','$nombreIndicador','$datosDeFormula')  ");
                                                    }
                                                    //// END
                                                    
                                                    ///header("Location: indicadoresGestionarAplicar;");
                                                    
                                                    ?>
                                                        <script>
                                                                window.onload=function(){
                                                                    //alert("El nombre o el archivo ya existen");
                                                                    document.forms["miformulario"].submit();
                                                                    }
                                                        </script>
                                                        <form name="miformulario" action="indicadoresGestionar" method="POST" onsubmit="procesar(this.action);" >
                                                            <input name="variablesIdPrincipal" value="<?php echo $variablesIdPrincipal; ?>" readonly type="hidden" required>
                                                            <input value="<?php echo $mesIndicador; ?>" type="hidden" readonly name="mes">
                                                            <input name="resultadoTotal" id="resultadoTotal" type="hidden" value="<?php echo $respaldoResultado=$_POST['resultadoTotal'];?>" require>
                                                        </form>
                                                        
                                                    <?php
                                                    
                                                }
                                                ?>                                                
                                                  <table style="width:100%;">
                                                    <tbody>
                                                      <tr>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="7" id="7" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="8" id="8" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="9" id="9" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="/" id="divide" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="(" id="parenleft" type="button"> </td>
                                                      </tr>
                                                      <tr align="center">
                                                        <td class="cell"> <input class="calcbttn" value="4" id="4" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="5" id="5" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="6" id="6" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="*" id="multiply" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value=")" id="parenright"
                                                            type="button"> </td>
                                                      </tr>
                                                      <tr align="center">
                                                        <td class="cell"> <input class="calcbttn" value="1" id="1" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="2" id="2" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="3" id="3" type="button">
                                                        </td>
                                                        <td class="cell"> <input class="calcbttn" value="+" id="plus" type="button">
                                                        </td>
                                                        <td class="cell"> <input onclick="funcion_ocultar_simbolo()" class="calcbttn" value="C" id="clear" type="button">
                                                        </td>
                                                      </tr>
                                                      <tr>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="0" id="0" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="." id="decimal" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="-" id="minus" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="^" id="^" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="=" onclick="funcionFormulaAlmacenar()" type="button"> </td>
                                                            <td>Digite los valores establecidos para la fórmula, haga clic en el signo ( = ) y proceda dando clic en "Validar Fórmula"</td>
                                                      </tr>
                                                      <script>
                                                          //// se agrega esta función para almacenar el dato que reemplaza las variables y saber cuales fueron los calculos para obtener el resultado
                                                          function funcionFormulaAlmacenar() {
                                                              // alert("entre");
                                                              document.getElementById('aplicarVariableUpdate').style.display = '';
                                                              document.getElementById('AvisoValidarBoton').style.display = 'none';
                                                              let actual = document.getElementById('results').innerHTML;
                                                              document.getElementById("reci").value = document.getElementById("results").innerHTML;
                                                          }
                                                          function funcion_ocultar_simbolo() {
                                                              // alert("entre");
                                                              document.getElementById('aplicarVariableUpdate').style.display = 'none';
                                                              document.getElementById('AvisoValidarBoton').style.display = '';
                                                          }
                                                      </script>
                                                     
                                                       <!--
                                                      <tr>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="abs" id="abs" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="sin" id="sin" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="cos" id="cos" type="button"></td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="tan" id="tan" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="del" id="del" type="button"> </td>
                                                      </tr>
                                                     
                                                      <tr>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="log10" id="log10" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="log2" id="log2" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="ln" id="ln" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="pi" id="pi" type="button"> </td>
                                                        <td style="text-align: center;" class="cell"> <input class="calcbttn"
                                                            value="sqrt" id="sqrt" type="button"> </td>
                                                      </tr>-->
                                                    </tbody>
                                                  </table>
                                                  &nbsp;
                                                  <!-- <input name="raddeg" value="radians" id="radians_rb" type="radio">
                                                  Radians <input name="raddeg" value="degrees" checked="checked" id="degrees_rb"
                                                    type="radio"> degrees--> </div>
  
                                                  <?php
                                                 $variablesIdPrincipal;
                                                 
                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadores` WHERE id='$variablesIdPrincipal' ");
                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                 echo '<b>Sentido:</b> '.$sentidoIndicador=$extraerMEta['sentido'];
                                                 $formulaAlimentada=$extraerMEta['alimentado'];
                                                 
                                                 $consultarMeta=$mysqli->query("SELECT * FROM `indicadoresMetas` WHERE idIndicador='$variablesIdPrincipal'  AND anoPresente='$anoPresente'");
                                                 $extraerMEta=$consultarMeta->fetch_array(MYSQLI_ASSOC);
                                                 
                                                 if($extraerMEta['unidad'] == '$'){
                                                      echo ' <b>meta:</b> $'.number_format($metaFormula=$extraerMEta['metaActual'],0,'.',',');
                                                 }else{
                                                      echo ' <b>meta:</b> '.$metaFormula=$extraerMEta['metaActual'];
                                                 }
                                                 
                                                
                                                 
                                                 
                                                  //// si el sentido de la meta viene positivo
                                                  if($sentidoIndicador == 'Positivo'){
                                                       if($extraerMEta['unidad'] == '$'){
                                                            if($DatoAlimentado > $metaFormula ){ 
                                                              echo '<br><br><font style="background:blue;color:white;">Zona de exceso: $'.number_format($extraerMEta['ze'],0,'.',',').' </font><br>';
                                                            }
                                                            if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                              echo '<br><br><font style="background:green;color:white;">zona de cumplimiento: $'.number_format($extraerMEta['zc'],0,'.',',').' </font><br>';
                                                            }  
                                                            if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                              echo '<br><br><font style="background:yellow;color:black;">Zona de alerta: $'.number_format($extraerMEta['za'],0,'.',',').' </font><br>';
                                                            }
                                                            if($DatoAlimentado <= $extraerMEta['zp']){
                                                              echo '<br><br><font style="background:red;color:white;">Zona de peligro: $'.number_format($extraerMEta['zp'],0,'.',',').' </font><br>';
                                                            }
                                                  
                                                       }else{
                                                           if($DatoAlimentado > $metaFormula ){ 
                                                              echo '<br><br><font style="background:blue;color:white;">Zona de exceso: '.$extraerMEta['ze'].' </font><br>';
                                                            }
                                                            if($DatoAlimentado <= $metaFormula && $DatoAlimentado > $extraerMEta['za']){
                                                              echo '<br><br><font style="background:green;color:white;">zona de cumplimiento: '.$extraerMEta['zc'].' </font><br>';
                                                            }  
                                                            if($DatoAlimentado <= $extraerMEta['za'] && $DatoAlimentado > $extraerMEta['zp']){
                                                              echo '<br><br><font style="background:yellow;color:black;">Zona de alerta: '.$extraerMEta['za'].' </font><br>';
                                                            }
                                                            if($DatoAlimentado <= $extraerMEta['zp']){
                                                              echo '<br><br><font style="background:red;color:white;">Zona de peligro: '.$extraerMEta['zp'].' </font><br>';
                                                            }
                                                       }
                                                  }
                                                  
                                                  if($sentidoIndicador == 'Negativo'){
                                                      if($extraerMEta['unidad'] == '$'){
                                                        if($DatoAlimentado < $metaFormula ){ 
                                                          echo '<br><br><font style="background:blue;color:white;">Zona de exceso: $'.number_format($extraerMEta['ze'],0,'.',',').' </font><br>';
                                                        }
                                                        if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                          echo '<br><br><font style="background:green;color:white;">zona de cumplimiento: $'.number_format($extraerMEta['zc'],0,'.',',').' </font><br>';
                                                        }
                                                        if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                          echo '<br><br><font style="background:yellow;color:black;">Zona de alerta: $'.number_format($extraerMEta['za'],0,'.',',').' </font><br>';
                                                        }
                                                        if($respaldoResultado >= $extraerMEta['zp']){
                                                          echo '<br><br><font style="background:red;color:white;">Zona de peligro: $'.number_format($extraerMEta['zp'],0,'.',',').' </font><br>';
                                                        }
                                                      }else{    
                                                        if($DatoAlimentado < $metaFormula ){ 
                                                          echo '<br><br><font style="background:blue;color:white;">Zona de exceso: '.$extraerMEta['ze'].' </font><br>';
                                                        }
                                                        if($DatoAlimentado >= $metaFormula && $DatoAlimentado < $extraerMEta['za']){
                                                          echo '<br><br><font style="background:green;color:white;">zona de cumplimiento: '.$extraerMEta['zc'].' </font><br>';
                                                        }
                                                        if($DatoAlimentado == $extraerMEta['za'] && $DatoAlimentado < $extraerMEta['zp']){
                                                          echo '<br><br><font style="background:yellow;color:black;">Zona de alerta: '.$extraerMEta['za'].' </font><br>';
                                                        }
                                                        if($respaldoResultado >= $extraerMEta['zp']){
                                                          echo '<br><br><font style="background:red;color:white;">Zona de peligro: '.$extraerMEta['zp'].' </font><br>';
                                                        }
                                                      }
                                                  }
                                                  
                                                  
                                                  //// END
                                                  
                                                  
                                                  
                                                  
                                                  
                                                  
                                                    
                                                  
                                                  ?>
                    
                    
                    <!-- finaliza calculadora más completa -->
                    
                </div>
                <!-- /.card-body -->

               
          
            </div>
            </div>    

        <div class="col">
            </div>
            
           
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
  </div>
  <!-- /.content-wrapper -->
<?php echo require_once'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>

<script>
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
</script>
<!-- Select2 -->
<script src="../plugins/select2/js/select2.full.min.js"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoRI').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
        $('#rad_usuarioRI').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoRI").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoC').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
        $('#rad_usuarioC').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoC").html(data);
            }); 
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#rad_cargoAut').click(function(){
            rad_cargo = "cargo";
            $.post("selectDocumentos2.php", { rad_cargo: rad_cargo }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
        $('#rad_usuarioAut').click(function(){
            rad_usuario = "usuario";
            $.post("selectDocumentos2.php", { rad_usuario: rad_usuario }, function(data){
                $("#select_encargadoAut").html(data);
            }); 
        });
    });
</script>

<script type="text/javascript">
$(document).ready(function () {
   
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
   
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>

<script src="../plugins/chart.js/Chart.min.js"></script>
<script src="../dist/js/pages/dashboard3.js"></script>
</body>
</html>
<?php
}
?>