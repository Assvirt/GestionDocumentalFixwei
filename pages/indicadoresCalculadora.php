 <center><h4>Calculadora</h4></center>
                                    <style>
                                    *{
                                        padding: 0px;
                                        margin: 0px;
                                        /*font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;*/
                                    }
                                    
                                    .contenidoCalculadora{
                                        background-color: #ededed;
                                        width: fit-content;
                                        margin: auto;
                                        margin-top: 30px;
                                    }
                                    
                                    .teclas{
                                        display: flex;
                                    }
                                    
                                    .pantalla{
                                        padding: 18px 18px 0px 18px;
                                    }
                                    
                                    #resultado{
                                        background-color: #666;
                                        padding: 9px;
                                        color: white;
                                    }
                                    
                                    .operaciones{
                                        padding: 18px; 18px 18px 9px;
                                    }
                                    .operaciones button{
                                        display: block;
                                        width: 54px;
                                        height: 54px;
                                        padding: 9px 15px;
                                        background-color: #000;/*rgba(30,60,160,0.12);*/
                                        color: #fff;
                                        border: none;
                                    }
                                    
                                    .numeros {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .numeros div{
                                        text-align: center;
                                    }
                                    .numeros button{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                    }
                                    .numeros button:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    .variables {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .variables div{
                                        text-align: center;
                                    }
                                    .variables a{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                        /*height: 15px;*/
                                        width: 70px;
                                        font-size: 15px;
                                    }
                                    .variables a:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    button{
                                        margin: 2px 0px;
                                        padding: 15px;
                                        font-size: 19px;
                                    }
                                    
                                    .sr{
                                        padding: 0px 18px; 18px; 18px;
                                    }
                                    
                                    .sr button{
                                        width: 100%;
                                        background-color: white;/*#48c;*/
                                        color: white;
                                        columns: #fff;
                                        border: none;
                                        font-size: 50px;
                                        padding: 0px;
                                    }
                                    
                                </style>
                                <div class="contenidoCalculadora">
                                    <div class="pantalla">
                                        <div id="resultado"></div>
                                        <div>
                                            <?php
                                                if(isset($_POST['aplicarVariable'])){
                                                    $ecuacion=$_POST['ecuacion'];
                                                }
                                            ?>
                                            <!-- 
                                            <form action="" method="POST">
                                                <input type='hidden' name='quienCrea' value="<?php //echo $quienCrea; ?>" >
                                                <input type='hidden' name='calculadoraMostrar' value="TRUE" >
                                                <input type='hidden' name='variablesIdPrincipal' value="<?php //echo $variablesIdPrincipal; ?>" >
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <button type="submit" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Aceptar</button>
                                            </form>
                                            -->
                                            
                                              
                                                <!-- enviamos por javascript al input por el boton aceptar o submit-->
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <button onclick="funcionFormula()" type="submit" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Aceptar</button>

                                        </div>
                                    </div>
                                    <div class="teclas">
                                       
                                            <!--<div class="">
                                                <?php /*
                                                //// se agrega tabla para las variables asociadas al indicador
                                                $variables=$mysqli->query("SELECT * FROM indicadoresVariablesAsociadas WHERE idIndicador='$variablesIdPrincipal' ORDER BY id ");
                                                $contador=1;
                                                while($extraerVariable= $variables->fetch_array()){
                                                    ////// se realiza subconsulta para traer el nombre del IdVariable
                                                    $nombreVariable=$extraerVariable['idVariable'];
                                                    $idVariable=$mysqli->query("SELECT * FROM indicadoresVariables WHERE id='$nombreVariable' ");
                                                    $extraerIdVariable=$idVariable->fetch_array(MYSQLI_ASSOC);
                                                    
                                                ?>
                                                    <button id="v<?php echo $contador++; ?>"><?php echo $extraerIdVariable['simbolo']; ?></button><br>
                                                        <form action="controlador/indicadores/controller" method="POST">
                                                            <input type="hidden" name='quienCrea' value="<?php echo $quienCrea; ?>" >
                                                            <input type="hidden" name='calculadoraMostrar' value="TRUE" >
                                                            <input type="hidden" name='variablesIdPrincipal' value="<?php echo $variablesIdPrincipal; ?>" >
                                                            <input value="<?php echo $extraerVariable['id']; ?>" name="desaplicar" type="hidden" readonly>  
                                                            <td><button   type='submit' name='AgregarVariablesDesaplicar'style='color:white;background:#ffc107;' class='btn btn-block btn-warning btn-sm'><i class=''></i> Desaplicar</button></td>
                                                        </form>
                                                <?php 
                                                } */
                                                //// END
                                                ?>
                                                </div>-->
                                       
                                        <div class="numeros">
                                            <div>
                                                <button id="n1">1</button>
                                                <button id="n2">2</button>
                                                <button id="n3">3</button>
                                                <button id="nCa">^</button>
                                                
                                            </div>
                                            <div>
                                                <button id="n4">4</button>
                                                <button id="n5">5</button>
                                                <button id="n6">6</button>
                                                <button id="nP1">(</button>
                                                
                                            </div>
                                            <div>
                                                <button id="n7">7</button>
                                                <button id="n8">8</button>
                                                <button id="n9">9</button>
                                                <button id="nP2">)</button>
                                            </div>
                                            <div>
                                                <button id="nC">,</button>
                                                <button id="n0">0</button>
                                                <button id="nP">.</button>
                                                <button id="nMYMN">+/-</button>
                                            </div>
                                            
                                        </div>
                                        <div class="operaciones">
                                            <button id="s">+</button>
                                            <button id="r">-</button>
                                            <button id="d">/</button>
                                            <button id="m">x</button>
                                            <button id="BT">C</button>
                                        </div>
                                    </div>
                                    <div class="variables">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v1" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v2" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v3" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v4" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v5" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v6" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v7" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v8" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v9" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v10" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v11" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v12" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v13" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v14" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v15" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v16" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v17" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v18" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v19" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v20" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v21" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v22" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v23" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v24" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v25" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v26" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v27" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v28" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v29" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v30" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="sr">
                                            <button id="sr"></button>
                                    </div>
                                </div>
                            
                                <script>
                                
                                 /*función para retroceso*/
                                    document.getElementById("BT").addEventListener("click",borradoTotal);
                                 
                                    function borradoTotal() {
                                     document.getElementById("resultado").value= resultado.innerHTML=0; //poner pantalla a 0
                                     document.getElementById("capturaVariable").value= resultado.innerHTML=''; //poner pantalla a 0
                                    }
                                
                                
                                 /*Operaciones*/
                                    document.getElementById("s").addEventListener("click",operaciones1);
                                    document.getElementById("r").addEventListener("click",operaciones2);
                                    document.getElementById("d").addEventListener("click",operaciones3);
                                    document.getElementById("m").addEventListener("click",operaciones4);
                                    document.getElementById("sr").addEventListener("click",showResult);
                                   
                                    function operaciones1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("s").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("r").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("d").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("m").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function showResult(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let suma = actual.indexOf("+");
                                        let resta = actual.indexOf("-");
                                        let div = actual.indexOf("/");
                                        let mult = actual.indexOf("x");
                                        if(suma !== -1){
                                            arr = actual.split("+",2);
                                            res = parseInt(arr[0]) + parseInt(arr[1]);
                                            document.getElementById("resultado").innerHTML = res;
                                            /* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (resta !== -1){
                                            arr = actual.split("-",2);
                                            res = arr[0] - arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (div !== -1){
                                            arr = actual.split("/",2);
                                            res = arr[0] / arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (mult !== -1){
                                            arr = actual.split("x",2);
                                            res = arr[0] * arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }
                                    }
                                    
                                
                                
                                /* script para los numeros*/
                                    document.getElementById("n1").addEventListener("click",n1);
                                    document.getElementById("n2").addEventListener("click",n2);
                                    document.getElementById("n3").addEventListener("click",n3);
                                    document.getElementById("n4").addEventListener("click",n4);
                                    document.getElementById("n5").addEventListener("click",n5);
                                    document.getElementById("n6").addEventListener("click",n6);
                                    document.getElementById("n7").addEventListener("click",n7);
                                    document.getElementById("n8").addEventListener("click",n8);
                                    document.getElementById("n9").addEventListener("click",n9);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("nP1").addEventListener("click",nP1);
                                    document.getElementById("nP2").addEventListener("click",nP2);
                                    document.getElementById("nCa").addEventListener("click",nCa);
                                    document.getElementById("nMYMN").addEventListener("click",nMYMN);
                                    
                                    
                                    
                                    
                                    function n1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n0(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n0").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nCa(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nCa").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nMYMN(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nMYMN").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    /*script para el (.) y la (,)*/
                                    
                                    document.getElementById("nC").addEventListener("click",nC);
                                    document.getElementById("nP").addEventListener("click",nP);
                                    function nC(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nC").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /*script para las variables que se elistan al costado izquierda de la calculadora*/
                                    
                                    document.getElementById("v1").addEventListener("click",v1);
                                    document.getElementById("v2").addEventListener("click",v2);
                                    document.getElementById("v3").addEventListener("click",v3);
                                    document.getElementById("v4").addEventListener("click",v4);
                                    document.getElementById("v5").addEventListener("click",v5);
                                    document.getElementById("v6").addEventListener("click",v6);
                                    document.getElementById("v7").addEventListener("click",v7);
                                    document.getElementById("v8").addEventListener("click",v8);
                                    document.getElementById("v9").addEventListener("click",v9);
                                    document.getElementById("v10").addEventListener("click",v10);
                                    
                                    document.getElementById("v11").addEventListener("click",v11);
                                    document.getElementById("v12").addEventListener("click",v12);
                                    document.getElementById("v13").addEventListener("click",v13);
                                    document.getElementById("v14").addEventListener("click",v14);
                                    document.getElementById("v15").addEventListener("click",v15);
                                    document.getElementById("v16").addEventListener("click",v16);
                                    document.getElementById("v17").addEventListener("click",v17);
                                    document.getElementById("v18").addEventListener("click",v18);
                                    document.getElementById("v19").addEventListener("click",v19);
                                    document.getElementById("v20").addEventListener("click",v20);
                                    
                                    document.getElementById("v21").addEventListener("click",v21);
                                    document.getElementById("v22").addEventListener("click",v22);
                                    document.getElementById("v23").addEventListener("click",v23);
                                    document.getElementById("v24").addEventListener("click",v24);
                                    document.getElementById("v25").addEventListener("click",v25);
                                    document.getElementById("v26").addEventListener("click",v26);
                                    document.getElementById("v27").addEventListener("click",v27);
                                    document.getElementById("v28").addEventListener("click",v28);
                                    document.getElementById("v29").addEventListener("click",v29);
                                    document.getElementById("v30").addEventListener("click",v30);
                                    
                                     
                                     function v1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v10(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v10").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v11(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v11").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v12(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v12").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v13(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v13").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v14(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v14").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v15(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v15").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v16(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v16").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v17(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v17").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v18(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v18").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v19(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v19").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v20(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v20").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v21(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v21").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v22(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v22").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v23(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v23").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v24(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v24").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v25(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v25").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v26(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v26").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v27(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v27").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v28(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v28").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v29(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v29").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v30(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v30").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    
                                    /* envia los simbolos creados para aplicarlos en la calculadora*/
                                     document.getElementById("enviarVariable1").addEventListener("click",enviarVariable1);
                                     document.getElementById("enviarVariable2").addEventListener("click",enviarVariable2);
                                     document.getElementById("enviarVariable3").addEventListener("click",enviarVariable3);
                                     document.getElementById("enviarVariable4").addEventListener("click",enviarVariable4);
                                     document.getElementById("enviarVariable5").addEventListener("click",enviarVariable5);
                                     document.getElementById("enviarVariable6").addEventListener("click",enviarVariable6);
                                     document.getElementById("enviarVariable7").addEventListener("click",enviarVariable7);
                                     document.getElementById("enviarVariable8").addEventListener("click",enviarVariable8);
                                     document.getElementById("enviarVariable9").addEventListener("click",enviarVariable9);
                                     document.getElementById("enviarVariable10").addEventListener("click",enviarVariable10);
                                     
                                     document.getElementById("enviarVariable11").addEventListener("click",enviarVariable11);
                                     document.getElementById("enviarVariable12").addEventListener("click",enviarVariable12);
                                     document.getElementById("enviarVariable13").addEventListener("click",enviarVariable13);
                                     document.getElementById("enviarVariable14").addEventListener("click",enviarVariable14);
                                     document.getElementById("enviarVariable15").addEventListener("click",enviarVariable15);
                                     document.getElementById("enviarVariable16").addEventListener("click",enviarVariable16);
                                     document.getElementById("enviarVariable17").addEventListener("click",enviarVariable17);
                                     document.getElementById("enviarVariable18").addEventListener("click",enviarVariable18);
                                     document.getElementById("enviarVariable19").addEventListener("click",enviarVariable19);
                                     document.getElementById("enviarVariable20").addEventListener("click",enviarVariable20);
                                     
                                     document.getElementById("enviarVariable21").addEventListener("click",enviarVariable21);
                                     document.getElementById("enviarVariable22").addEventListener("click",enviarVariable22);
                                     document.getElementById("enviarVariable23").addEventListener("click",enviarVariable23);
                                     document.getElementById("enviarVariable24").addEventListener("click",enviarVariable24);
                                     document.getElementById("enviarVariable25").addEventListener("click",enviarVariable25);
                                     document.getElementById("enviarVariable26").addEventListener("click",enviarVariable26);
                                     document.getElementById("enviarVariable27").addEventListener("click",enviarVariable27);
                                     document.getElementById("enviarVariable28").addEventListener("click",enviarVariable28);
                                     document.getElementById("enviarVariable29").addEventListener("click",enviarVariable29);
                                     document.getElementById("enviarVariable30").addEventListener("click",enviarVariable30);
                                    
                                     
                                    function enviarVariable1(){
                                        
                                        let enviar = document.getElementById("enviarVariable1").innerHTML;
                                        document.getElementById('v1').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable2(){
                                        
                                        let enviar = document.getElementById("enviarVariable2").innerHTML;
                                        document.getElementById('v2').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable3(){
                                        
                                        let enviar = document.getElementById("enviarVariable3").innerHTML;
                                        document.getElementById('v3').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable4(){
                                        
                                        let enviar = document.getElementById("enviarVariable4").innerHTML;
                                        document.getElementById('v4').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable5(){
                                        
                                        let enviar = document.getElementById("enviarVariable5").innerHTML;
                                        document.getElementById('v5').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable6(){
                                        
                                        let enviar = document.getElementById("enviarVariable6").innerHTML;
                                        document.getElementById('v6').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable7(){
                                        
                                        let enviar = document.getElementById("enviarVariable7").innerHTML;
                                        document.getElementById('v7').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable8(){
                                        
                                        let enviar = document.getElementById("enviarVariable8").innerHTML;
                                        document.getElementById('v8').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable9(){
                                        
                                        let enviar = document.getElementById("enviarVariable9").innerHTML;
                                        document.getElementById('v9').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable10(){
                                        
                                        let enviar = document.getElementById("enviarVariable10").innerHTML;
                                        document.getElementById('v10').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable11(){
                                        
                                        let enviar = document.getElementById("enviarVariable11").innerHTML;
                                        document.getElementById('v11').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable12(){
                                        
                                        let enviar = document.getElementById("enviarVariable12").innerHTML;
                                        document.getElementById('v12').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable13(){
                                        
                                        let enviar = document.getElementById("enviarVariable13").innerHTML;
                                        document.getElementById('v13').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable14(){
                                        
                                        let enviar = document.getElementById("enviarVariable14").innerHTML;
                                        document.getElementById('v14').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable15(){
                                        
                                        let enviar = document.getElementById("enviarVariable15").innerHTML;
                                        document.getElementById('v15').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable16(){
                                        
                                        let enviar = document.getElementById("enviarVariable16").innerHTML;
                                        document.getElementById('v16').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable17(){
                                        
                                        let enviar = document.getElementById("enviarVariable17").innerHTML;
                                        document.getElementById('v17').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable18(){
                                        
                                        let enviar = document.getElementById("enviarVariable18").innerHTML;
                                        document.getElementById('v18').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable19(){
                                        
                                        let enviar = document.getElementById("enviarVariable19").innerHTML;
                                        document.getElementById('v19').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable20(){
                                        
                                        let enviar = document.getElementById("enviarVariable20").innerHTML;
                                        document.getElementById('v20').innerHTML = enviar
                                        
                                    }
                                    
                                    function enviarVariable21(){
                                        
                                        let enviar = document.getElementById("enviarVariable21").innerHTML;
                                        document.getElementById('v21').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable22(){
                                        
                                        let enviar = document.getElementById("enviarVariable22").innerHTML;
                                        document.getElementById('v22').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable23(){
                                        
                                        let enviar = document.getElementById("enviarVariable23").innerHTML;
                                        document.getElementById('v23').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable24(){
                                        
                                        let enviar = document.getElementById("enviarVariable24").innerHTML;
                                        document.getElementById('v24').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable25(){
                                        
                                        let enviar = document.getElementById("enviarVariable25").innerHTML;
                                        document.getElementById('v25').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable26(){
                                        
                                        let enviar = document.getElementById("enviarVariable26").innerHTML;
                                        document.getElementById('v26').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable27(){
                                        
                                        let enviar = document.getElementById("enviarVariable27").innerHTML;
                                        document.getElementById('v27').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable28(){
                                        
                                        let enviar = document.getElementById("enviarVariable28").innerHTML;
                                        document.getElementById('v28').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable29(){
                                        
                                        let enviar = document.getElementById("enviarVariable29").innerHTML;
                                        document.getElementById('v29').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable30(){
                                        
                                        let enviar = document.getElementById("enviarVariable30").innerHTML;
                                        document.getElementById('v30').innerHTML = enviar
                                        
                                    }
                                    
                                    /* end envia los simbolos creados para aplicarlos en la calculadora*/
                                    
                                    
                                /* 303 líneas de código para la calculadora, atrapar la variable al aplicar y desaplicar y eviarla a una variable*/
                                </script>
                                
                                
<!-- Calculadora en el editar -->
<center><h4>Calculadora</h4></center>
                                <style>
                                    *{
                                        padding: 0px;
                                        margin: 0px;
                                        /*font-family: Century Gothic,CenturyGothic,AppleGothic,sans-serif;*/
                                    }
                                    
                                    .contenidoCalculadora{
                                        background-color: #ededed;
                                        width: fit-content;
                                        margin: auto;
                                        margin-top: 30px;
                                    }
                                    
                                    .teclas{
                                        display: flex;
                                    }
                                    
                                    .pantalla{
                                        padding: 18px 18px 0px 18px;
                                    }
                                    
                                    #resultado{
                                        background-color: #666;
                                        padding: 9px;
                                        color: white;
                                    }
                                    
                                    .operaciones{
                                        padding: 18px; 18px 18px 9px;
                                    }
                                    .operaciones a{
                                        display: block;
                                        width: 54px;
                                        height: 54px;
                                        padding: 9px 15px;
                                        background-color: #000;/*rgba(30,60,160,0.12);*/
                                        color: #fff;
                                        border: none;
                                    }
                                    
                                    .numeros {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .numeros div{
                                        text-align: center;
                                    }
                                    .numeros a{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                    }
                                    .numeros a:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    .variables {
                                        padding: 18px; 9px 18px 18px;
                                    }
                                    
                                    .variables div{
                                        text-align: center;
                                    }
                                    .variables a{
                                        border: 0px;
                                        background-color: #fff;
                                        transition: all 0.09s;
                                        /*height: 15px;*/
                                        width: 70px;
                                        font-size: 15px;
                                    }
                                    .variables a:hover{
                                        box-shadow: 0px 0px 12px; #aaa;
                                    }
                                    
                                    
                                    a{
                                        margin: 2px 0px;
                                        /*padding: 15px;
                                        font-size: 19px;*/
                                    }
                                    
                                    .sr{
                                        padding: 0px 18px; 18px; 18px;
                                    }
                                    
                                    .sr a{
                                        width: 100%;
                                        background-color: #48c;
                                        color: white;
                                        columns: #fff;
                                        border: none;
                                        font-size: 50px;
                                        padding: 0px;
                                    }
                                    
                                </style>
                                <div class="contenidoCalculadora">
                                    <div class="pantalla">
                                        <div id="resultado"></div>
                                        <div>
                                            <?php
                                            /*
                                                if(isset($_POST['aplicarVariable'])){
                                                    $ecuacion=$_POST['ecuacion'];
                                                }*/
                                            ?>
                                                <!-- enviamos por javascript al input por el boton aceptar o submit-->
                                                <input style="background:#666;color:white;padding:9px;width:100%;" type="hidden" readonly size="36px" id="capturaVariable" name="ecuacion"><br>
                                                <a onclick="funcionFormula()" class="btn btn-success" name="aplicarVariable"  style="background:black;color:white;border-color:black;">Aceptar</a>

                                        </div>
                                    </div>
                                    <div class="teclas">
                                       
                                            
                                       
                                        <div class="numeros">
                                            <div>
                                                <a class="numeros" id="n1">1</a>
                                                <a class="numeros" id="n2">2</a>
                                                <a class="numeros" id="n3">3</a>
                                                <a class="numeros" id="nCa">^</a>
                                                
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="n4">4</a>
                                                <a class="numeros" id="n5">5</a>
                                                <a class="numeros" id="n6">6</a>
                                                <a class="numeros" id="nP1">(</a>
                                                
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="n7">7</a>
                                                <a class="numeros" id="n8">8</a>
                                                <a class="numeros" id="n9">9</a>
                                                <a class="numeros" id="nP2">)</a>
                                            </div>
                                            <br><br>
                                            <div>
                                                <a class="numeros" id="nC">,</a>
                                                <a class="numeros" id="n0">0</a>
                                                <a class="numeros" id="nP">.</a>
                                                <a class="numeros" id="nMYMN">+/-</a>
                                            </div>
                                            
                                        </div>
                                        <div class="operaciones">
                                            <a class="operaciones" id="s" style="color:white;">+</a>
                                            <a class="operaciones" id="r" style="color:white;">-</a>
                                            <a class="operaciones" id="d" style="color:white;">/</a>
                                            <a class="operaciones" id="m" style="color:white;">x</a>
                                            <a class="operaciones" id="BT" style="color:white;">C</a>
                                        </div>
                                    </div>
                                    <div class="sr">
                                            <a class="sr" id="sr"></a>
                                    </div>
                                    <div class="variables">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v1" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v2" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v3" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v4" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v5" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                         
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v6" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v7" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v8" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v9" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v10" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v11" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v12" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v13" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v14" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v15" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                   
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v16" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v17" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v18" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v19" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v20" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v21" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v22" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v23" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v24" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v25" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <td><a id="v26" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v27" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v28" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v29" style="font-size:30px;"></a></td>
                                                    <td><font color="white">--</font></td>
                                                    <td><a id="v30" style="font-size:30px;"></a></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            
                                <script>
                                 /*función para retroceso*/
                                    document.getElementById("BT").addEventListener("click",borradoTotal);
                                 
                                    function borradoTotal() {
                                     document.getElementById("resultado").value= resultado.innerHTML=0; //poner pantalla a 0
                                     document.getElementById("capturaVariable").value= resultado.innerHTML=''; //poner pantalla a 0
                                    }
                                
                                
                                 /*Operaciones*/
                                    document.getElementById("s").addEventListener("click",operaciones1);
                                    document.getElementById("r").addEventListener("click",operaciones2);
                                    document.getElementById("d").addEventListener("click",operaciones3);
                                    document.getElementById("m").addEventListener("click",operaciones4);
                                    document.getElementById("sr").addEventListener("click",showResult);
                                   
                                    function operaciones1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("s").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("r").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("d").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function operaciones4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("m").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual +  sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function showResult(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let suma = actual.indexOf("+");
                                        let resta = actual.indexOf("-");
                                        let div = actual.indexOf("/");
                                        let mult = actual.indexOf("x");
                                        if(suma !== -1){
                                            arr = actual.split("+",2);
                                            res = parseInt(arr[0]) + parseInt(arr[1]);
                                            document.getElementById("resultado").innerHTML = res;
                                            /* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (resta !== -1){
                                            arr = actual.split("-",2);
                                            res = arr[0] - arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (div !== -1){
                                            arr = actual.split("/",2);
                                            res = arr[0] / arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }else if (mult !== -1){
                                            arr = actual.split("x",2);
                                            res = arr[0] * arr[1];
                                            document.getElementById("resultado").innerHTML = res;/* enviamos al input donde capturamos la variable de la función*/
                                            document.getElementById("capturaVariable").value = res;
                                        }
                                    }
                                    
                                
                                
                                /* script para los numeros*/
                                    document.getElementById("n1").addEventListener("click",n1);
                                    document.getElementById("n2").addEventListener("click",n2);
                                    document.getElementById("n3").addEventListener("click",n3);
                                    document.getElementById("n4").addEventListener("click",n4);
                                    document.getElementById("n5").addEventListener("click",n5);
                                    document.getElementById("n6").addEventListener("click",n6);
                                    document.getElementById("n7").addEventListener("click",n7);
                                    document.getElementById("n8").addEventListener("click",n8);
                                    document.getElementById("n9").addEventListener("click",n9);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("n0").addEventListener("click",n0);
                                    document.getElementById("nP1").addEventListener("click",nP1);
                                    document.getElementById("nP2").addEventListener("click",nP2);
                                    document.getElementById("nCa").addEventListener("click",nCa);
                                    document.getElementById("nMYMN").addEventListener("click",nMYMN);
                                    
                                    
                                    
                                    
                                    function n1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function n0(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("n0").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nCa(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nCa").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nMYMN(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nMYMN").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    /*script para el (.) y la (,)*/
                                    
                                    document.getElementById("nC").addEventListener("click",nC);
                                    document.getElementById("nP").addEventListener("click",nP);
                                    function nC(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nC").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    function nP(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("nP").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /*script para las variables que se elistan al costado izquierda de la calculadora*/
                                    
                                    document.getElementById("v1").addEventListener("click",v1);
                                    document.getElementById("v2").addEventListener("click",v2);
                                    document.getElementById("v3").addEventListener("click",v3);
                                    document.getElementById("v4").addEventListener("click",v4);
                                    document.getElementById("v5").addEventListener("click",v5);
                                    document.getElementById("v6").addEventListener("click",v6);
                                    document.getElementById("v7").addEventListener("click",v7);
                                    document.getElementById("v8").addEventListener("click",v8);
                                    document.getElementById("v9").addEventListener("click",v9);
                                    document.getElementById("v10").addEventListener("click",v10);
                                    
                                     document.getElementById("v11").addEventListener("click",v11);
                                    document.getElementById("v12").addEventListener("click",v12);
                                    document.getElementById("v13").addEventListener("click",v13);
                                    document.getElementById("v14").addEventListener("click",v14);
                                    document.getElementById("v15").addEventListener("click",v15);
                                    document.getElementById("v16").addEventListener("click",v16);
                                    document.getElementById("v17").addEventListener("click",v17);
                                    document.getElementById("v18").addEventListener("click",v18);
                                    document.getElementById("v19").addEventListener("click",v19);
                                    document.getElementById("v20").addEventListener("click",v20);
                                    
                                    document.getElementById("v21").addEventListener("click",v21);
                                    document.getElementById("v22").addEventListener("click",v22);
                                    document.getElementById("v23").addEventListener("click",v23);
                                    document.getElementById("v24").addEventListener("click",v24);
                                    document.getElementById("v25").addEventListener("click",v25);
                                    document.getElementById("v26").addEventListener("click",v26);
                                    document.getElementById("v27").addEventListener("click",v27);
                                    document.getElementById("v28").addEventListener("click",v28);
                                    document.getElementById("v29").addEventListener("click",v29);
                                    document.getElementById("v30").addEventListener("click",v30);
                                     
                                     function v1(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v1").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v2(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v2").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v3(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v3").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v4(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v4").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v5(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v5").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v6(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v6").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v7(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v7").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v8(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v8").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v9(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v9").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v10(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v10").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v11(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v11").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v12(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v12").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v13(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v13").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v14(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v14").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v15(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v15").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v16(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v16").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v17(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v17").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v18(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v18").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v19(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v19").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v20(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v20").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v21(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v21").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    function v22(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v22").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v23(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v23").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v24(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v24").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v25(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v25").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v26(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v26").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v27(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v27").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v28(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v28").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v29(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v29").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                     
                                     function v30(){
                                        let actual = document.getElementById('resultado').innerHTML;
                                        let sumado = document.getElementById("v30").innerHTML;
                                        document.getElementById('resultado').innerHTML = actual + sumado
                                        /* enviamos al input donde capturamos la variable de la función*/
                                        document.getElementById("capturaVariable").value = actual + sumado;
                                    }
                                    
                                    
                                    /* envia los simbolos creados para aplicarlos en la calculadora*/
                                     document.getElementById("enviarVariable1").addEventListener("click",enviarVariable1);
                                     document.getElementById("enviarVariable2").addEventListener("click",enviarVariable2);
                                     document.getElementById("enviarVariable3").addEventListener("click",enviarVariable3);
                                     document.getElementById("enviarVariable4").addEventListener("click",enviarVariable4);
                                     document.getElementById("enviarVariable5").addEventListener("click",enviarVariable5);
                                     document.getElementById("enviarVariable6").addEventListener("click",enviarVariable6);
                                     document.getElementById("enviarVariable7").addEventListener("click",enviarVariable7);
                                     document.getElementById("enviarVariable8").addEventListener("click",enviarVariable8);
                                     document.getElementById("enviarVariable9").addEventListener("click",enviarVariable9);
                                     document.getElementById("enviarVariable10").addEventListener("click",enviarVariable10);
                                    
                                     document.getElementById("enviarVariable11").addEventListener("click",enviarVariable11);
                                     document.getElementById("enviarVariable12").addEventListener("click",enviarVariable12);
                                     document.getElementById("enviarVariable13").addEventListener("click",enviarVariable13);
                                     document.getElementById("enviarVariable14").addEventListener("click",enviarVariable14);
                                     document.getElementById("enviarVariable15").addEventListener("click",enviarVariable15);
                                     document.getElementById("enviarVariable16").addEventListener("click",enviarVariable16);
                                     document.getElementById("enviarVariable17").addEventListener("click",enviarVariable17);
                                     document.getElementById("enviarVariable18").addEventListener("click",enviarVariable18);
                                     document.getElementById("enviarVariable19").addEventListener("click",enviarVariable19);
                                     document.getElementById("enviarVariable20").addEventListener("click",enviarVariable20);
                                     
                                     document.getElementById("enviarVariable21").addEventListener("click",enviarVariable21);
                                     document.getElementById("enviarVariable22").addEventListener("click",enviarVariable22);
                                     document.getElementById("enviarVariable23").addEventListener("click",enviarVariable23);
                                     document.getElementById("enviarVariable24").addEventListener("click",enviarVariable24);
                                     document.getElementById("enviarVariable25").addEventListener("click",enviarVariable25);
                                     document.getElementById("enviarVariable26").addEventListener("click",enviarVariable26);
                                     document.getElementById("enviarVariable27").addEventListener("click",enviarVariable27);
                                     document.getElementById("enviarVariable28").addEventListener("click",enviarVariable28);
                                     document.getElementById("enviarVariable29").addEventListener("click",enviarVariable29);
                                     document.getElementById("enviarVariable30").addEventListener("click",enviarVariable30);
                                     
                                     
                                    function enviarVariable1(){
                                        
                                        let enviar = document.getElementById("enviarVariable1").innerHTML;
                                        document.getElementById('v1').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable2(){
                                        
                                        let enviar = document.getElementById("enviarVariable2").innerHTML;
                                        document.getElementById('v2').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable3(){
                                        
                                        let enviar = document.getElementById("enviarVariable3").innerHTML;
                                        document.getElementById('v3').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable4(){
                                        
                                        let enviar = document.getElementById("enviarVariable4").innerHTML;
                                        document.getElementById('v4').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable5(){
                                        
                                        let enviar = document.getElementById("enviarVariable5").innerHTML;
                                        document.getElementById('v5').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable6(){
                                        
                                        let enviar = document.getElementById("enviarVariable6").innerHTML;
                                        document.getElementById('v6').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable7(){
                                        
                                        let enviar = document.getElementById("enviarVariable7").innerHTML;
                                        document.getElementById('v7').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable8(){
                                        
                                        let enviar = document.getElementById("enviarVariable8").innerHTML;
                                        document.getElementById('v8').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable9(){
                                        
                                        let enviar = document.getElementById("enviarVariable9").innerHTML;
                                        document.getElementById('v9').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable10(){
                                        
                                        let enviar = document.getElementById("enviarVariable10").innerHTML;
                                        document.getElementById('v10').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable11(){
                                        
                                        let enviar = document.getElementById("enviarVariable11").innerHTML;
                                        document.getElementById('v11').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable12(){
                                        
                                        let enviar = document.getElementById("enviarVariable12").innerHTML;
                                        document.getElementById('v12').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable13(){
                                        
                                        let enviar = document.getElementById("enviarVariable13").innerHTML;
                                        document.getElementById('v13').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable14(){
                                        
                                        let enviar = document.getElementById("enviarVariable14").innerHTML;
                                        document.getElementById('v14').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable15(){
                                        
                                        let enviar = document.getElementById("enviarVariable15").innerHTML;
                                        document.getElementById('v15').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable16(){
                                        
                                        let enviar = document.getElementById("enviarVariable16").innerHTML;
                                        document.getElementById('v16').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable17(){
                                        
                                        let enviar = document.getElementById("enviarVariable17").innerHTML;
                                        document.getElementById('v17').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable18(){
                                        
                                        let enviar = document.getElementById("enviarVariable18").innerHTML;
                                        document.getElementById('v18').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable19(){
                                        
                                        let enviar = document.getElementById("enviarVariable19").innerHTML;
                                        document.getElementById('v19').innerHTML = enviar
                                        
                                    }
                                     
                                    function enviarVariable20(){
                                        
                                        let enviar = document.getElementById("enviarVariable20").innerHTML;
                                        document.getElementById('v20').innerHTML = enviar
                                        
                                    }
                                    
                                    function enviarVariable21(){
                                        
                                        let enviar = document.getElementById("enviarVariable21").innerHTML;
                                        document.getElementById('v21').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable22(){
                                        
                                        let enviar = document.getElementById("enviarVariable22").innerHTML;
                                        document.getElementById('v22').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable23(){
                                        
                                        let enviar = document.getElementById("enviarVariable23").innerHTML;
                                        document.getElementById('v23').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable24(){
                                        
                                        let enviar = document.getElementById("enviarVariable24").innerHTML;
                                        document.getElementById('v24').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable25(){
                                        
                                        let enviar = document.getElementById("enviarVariable25").innerHTML;
                                        document.getElementById('v25').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable26(){
                                        
                                        let enviar = document.getElementById("enviarVariable26").innerHTML;
                                        document.getElementById('v26').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable27(){
                                        
                                        let enviar = document.getElementById("enviarVariable27").innerHTML;
                                        document.getElementById('v27').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable28(){
                                        
                                        let enviar = document.getElementById("enviarVariable28").innerHTML;
                                        document.getElementById('v28').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable29(){
                                        
                                        let enviar = document.getElementById("enviarVariable29").innerHTML;
                                        document.getElementById('v29').innerHTML = enviar
                                        
                                    }
                                    function enviarVariable30(){
                                        
                                        let enviar = document.getElementById("enviarVariable30").innerHTML;
                                        document.getElementById('v30').innerHTML = enviar
                                        
                                    }
                                    
                                    /* end envia los simbolos creados para aplicarlos en la calculadora*/
                                    
                                    
                                /* 303 líneas de código para la calculadora, atrapar la variable al aplicar y desaplicar y eviarla a una variable*/
                                </script>