jQuery(function(){
	var userOnline = Number(jQuery('span.user_online').attr('id'));
	var clicou = [];

	function in_array(valor, array){
		for(var i =0; i<array.length;i++){
			if(array[i] == valor){
				return true;
			}
		}

		return false;
	}

	function add_janela(id, nome, status){
		var janelas = Number(jQuery('#chats .window').length);
		var pixels = (270+5)*janelas;
		var style = 'float:none; position:absolute; bottom:0; left:'+pixels+'px';

		var splitDados = id.split(':');
		var id_user = Number(splitDados[1]);


		var janela = '<div class="card window" id="janela_'+id_user+'" style="'+style+'">';
		janela += '<div style="background-color:;border-bottom: 1px solid rgba(0,0,0,.125);padding: .75rem 1.25rem;position: relative;border-top-left-radius: .25rem;border-top-right-radius: .25rem;" class="header_window"><a href="#" style="color:black;" class="close"><li class="fas fa-times"></li></a> <span class="name" style="color:black;">'+nome+'</span>  <span id="'+id_user+'" class="'+status+'"></span></div>';
		janela += '<div class="body"><div class="mensagens" style="background:white;"><ul></ul></div>';
		janela += '<div class="send_message card-footer" id="'+id+'" style="padding:.75rem 1.25rem;background-color:;"><input style="border-radius:3px;border-color:#C7C6CD;" cols="28" rows="2" type="text" name="mensagem" placeholder="Escribir mensaje..." class="msg" id="'+id+'" ></div></div></div>';

		jQuery('#chats').append(janela);
	}



	function retorna_historico(id_conversa){
		jQuery.ajax({
			type: 'POST',
			url: 'sys/historico.php',
			data: {conversacom: id_conversa, online: userOnline},
			dataType: 'json',
			success: function(retorno){
				jQuery.each(retorno, function(i, msg){
					if(jQuery('#janela_'+msg.janela_de).length > 0){
						if(userOnline == msg.id_de){
							jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li style="background: #d2d6de;border-color:#d2d6de;" id="'+msg.id+'" class="eu"><p style="color:black;">'+msg.mensagem+'</p></li>');
						}else{
							jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li style="background:#007bff;border-color:#007bff;" id="'+msg.id+'"><div class="imgSmall"><img src="fotos/'+msg.fotoUser+'" /></div><p style="color:white;">'+msg.mensagem+'</p></li>');
						}
					}
				});
				[].reverse.call(jQuery('#janela_'+id_conversa+' .mensagens li')).appendTo(jQuery('#janela_'+id_conversa+' .mensagens ul'));
				jQuery('#janela_'+id_conversa+' .mensagens').animate({scrollTop: 230}, '500');
			}
		});
	}

	jQuery('body').on('click', '#users_online a', function(){
		var id = jQuery(this).attr('id');
		jQuery(this).removeClass('comecar');

		var status = jQuery(this).next().attr('class');
		var splitIds = id.split(':');
		var idJanela = Number(splitIds[1]);
	
		if(jQuery('#janela_'+idJanela).length == 0){
			var nome = jQuery(this).text();
			add_janela(id, nome, status);
			retorna_historico(idJanela);
		}else{
			jQuery(this).removeClass('comecar');
		}
	});

	jQuery('body').on('click', '.header_window', function(){
		var next = jQuery(this).next();
		next.toggle(100);
	});

	jQuery('body').on('click', '.close', function(){
		var parent = jQuery(this).parent().parent();
		var idParent = parent.attr('id');
		var splitParent = idParent.split('_');
		var idJanelaFechada = Number(splitParent[1]);

		var contagem = Number(jQuery('.window').length)-1;
		var indice = Number(jQuery('.close').index(this));
		var restamAfrente = contagem-indice;

		for(var i = 1; i <= restamAfrente; i++){
			jQuery('.window:eq('+(indice+i)+')').animate({left:"-=275"}, 200);
		}
		parent.remove();
		jQuery('#users_online li#'+idJanelaFechada+' a').addClass('comecar');
	});

	jQuery('body').on('keyup', '.msg', function(e){
		if(e.which == 13){
			var texto = jQuery(this).val();
			var id = jQuery(this).attr('id');
			var split = id.split(':');
			var para = Number(split[1]);

			jQuery.ajax({
				type: 'POST',
				url: 'sys/submit.php',
				data: {mensagem: texto, de: userOnline, para: para},
				success: function(retorno){
					if(retorno == 'ok'){
						jQuery('.msg').val('');
					}else{
						alert("Ups, el texto es demasiado largo para ser enviado !");
					}
				}
			});
		}
	});

	jQuery('body').on('click', '.mensagens', function(){
		var janela = jQuery(this).parent().parent();
		var janelaId = janela.attr('id');
		var idConversa = janelaId.split('_');
		idConversa = Number(idConversa[1]);

		jQuery.ajax({
			url: 'sys/ler.php',
			type: 'POST',
			data: {ler: 'sim', online: userOnline, user: idConversa},
			success: function(retorno){}
		});
	});

	function verifica(timestamp, lastid, user){
		var t;
		jQuery.ajax({
			url: 'sys/stream.php',
			type: 'GET',
			data: 'timestamp='+timestamp+'&lastid='+lastid+'&user='+user,
			dataType: 'json',
			success: function(retorno){
				clearInterval(t);
				if(retorno.status == 'resultados' || retorno.status == 'vazio'){
					t =setTimeout(function(){
						verifica(retorno.timestamp, retorno.lastid, userOnline);
					},1000);

					if(retorno.status == 'resultados'){
						jQuery.each(retorno.dados, function(i, msg){
							if(msg.id_para == userOnline){
								jQuery.playSound('sys/effect');
							}

							if(jQuery('#janela_'+msg.janela_de).length == 0){
								jQuery('#users_online #'+msg.janela_de+' .comecar').click();
								clicou.push(msg.janela_de);
							}

							if(!in_array(msg.janela_de, clicou)){
								if(jQuery('.mensagens ul li#'+msg.id).length == 0 && msg.janela_de > 0){
									if(userOnline == msg.id_de){
										jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li class="eu" id="'+msg.id+'"><p style="color:black;">'+msg.mensagem+'</p></li>');
									}else{
										jQuery('#janela_'+msg.janela_de+' .mensagens ul').append('<li id="'+msg.id+'"><div class="imgSmall"><img src="fotos/'+msg.fotoUser+'" border="0"/></div><p style="color:white;">'+msg.mensagem+'</p></li>');
									}
								}
							}
						});
						jQuery('.mensagens').animate({scrollTop: 230}, '500');
						console.log(clicou);
					}
					clicou = [];
					jQuery('#users_online ul').html('');
					jQuery.each(retorno.users, function(i, user){
						var incluir = '<li id="'+user.id+'"><div class="imgSmall"><img src="fotos/'+user.foto+'" border="0"/></div>';
						incluir += '<a href="#" id="'+userOnline+':'+user.id+'" class="comecar">'+user.nome+'</a>';
						incluir += '<span id="'+user.id+'" class="status '+user.status+'"></span></li>';
						jQuery('span#'+user.id).attr('class', 'status '+user.status);
						jQuery('#users_online ul').append(incluir);
					});
				}else if(retorno.status == 'erro'){
					alert('Actualice la página');
				}
			},
			error: function(){
				clearInterval(t);
				t=setTimeout(function(){
					verifica(retorno.timestamp, retorno.lastid, userOnline);
				},15000);
			}
		});
	}

	verifica(0,0,userOnline);
});