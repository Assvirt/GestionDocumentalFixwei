
        $(document).on('click', '#js-enviar', function(e){
          e.preventDefault();
         

          /* capturo los id de cada input y select*/
          var reg1 = $('#numero1').val(), 
              reg2 = $('#numero2').val(),
              reg3 = $('#opcion').val();
          
          $.ajax({
              url: '../controllers/calculadora.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar por el metodo post
              method: 'POST',
              data: { reg1: reg1, reg2: reg2, reg3: reg3 },
              beforeSend: function(){
                  //$('#mostrarDatos').css('display','block');
              },
              success: function(r){
                  if (r == 'vacio' ) { // si la respuesta es igual a 0, se activa la validación de campos obligatorios
                      $('#estado').html('<hr><font color="red">Todos los campos son obligatorios.</font><hr>');
                       /*habilitamos el div de estado para mostrar el error en caso que se divida en 0 o valide campos obligatorios*/
                      document.getElementById('estado').style.display = '';
                  } else {
                      if(r == 'error'){
                          $('#estado').html('<hr><font color="red">No se puede dividir en 0.</font><hr>');
                          /*habilitamos el div de estado para mostrar el error en caso que se divida en 0 o valide campos obligatorios*/
                          document.getElementById('estado').style.display = '';
                      }else{
                          document.getElementById('resultado').value = r; /// capturo el resuldao y lo envio al input
                          /*ocultamos el div de estado para no mostrar el error en caso que se divida en 0 o valide campos obligatorios*/
                          document.getElementById('estado').style.display = 'none';
                      }
                      
                  }
              }
          });
      });

      /*Al momento de limpiar también nos oculta la alerta*/
      $(document).ready(function(){
          $('#limpiar').click(function(){
              document.getElementById('estado').style.display = 'none';
          });
      });


      // traemos los datos de la consulta, después de hacer click en el modal
      $(document).on('click', '#js-consulta', function(e){
          e.preventDefault();
        
          $.ajax({
            url: '../view/registroCalculadoraJs.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
            method: 'POST',
            
            beforeSend: function(){
              $('#mostrarDatos').css('display','block');
              
            },
            success: function(lista){
                $('#mostrarDatos').html(lista);
            }
          });
      });
    