/**
 * Created by dlepera on 21/10/15.
 */

/* global plugin_formulario_tema, carregarCSS */

(function($){
	// Variáveis ---------------------------------------------------------------------------------------------------- //
	/**
	 * Armazenar as contagens de tempos das mensagens
	 * @type {Object}
	 */
	var msg_c = {};
    var __plugin = '__jQuery-mostrarMsg';

	// Funções ------------------------------------------------------------------------------------------------------ //
	function esconderMsg(botao, funcao){
		var retorno = null;

		$(botao).parents('.' + __plugin).fadeOut('fast', function(){
			$(this).remove();
			if( typeof funcao === 'function' ){ retorno = funcao(); }
		});

		return retorno;
	} // Fim function esconderMsg(botao)

    /**
     * Mostrar mensagens para o usuário
     *
     * @param {object} opcoes Objeto com as configurações desejadas para aplicar
     * @param {boolean} mesclar Define se as opções serã mescladas ou substituídas totalmente
     * @returns {*}
     */
	$.fn.mostrarMsg = function(opcoes, mesclar){
		var $th = $(this);

		// Opções padrão
		var padrao = {
			// Mensagem a ser mostrada
			mensagem: 'Português: Mensagem padrão!\nEnglish: Default menssage!',

			// Tipo de mensagem a ser mostrada
			// Obs: Também pode interferir na aparência da mensagem
			tipo: ['-alerta', '-atencao'],

            // Define se o sistema continuará com a execução mesmo em caso de mensagens que não sejam de sucesso
			exec_depois: false,

			// Tempo que a mensagem deverá ser exibida em ms
			// @option int num - qntd de tempo em ms
			// @option bool exibir - define se será mostrado o tempo restante
			// para fechar a mensagem
			tempo: { num: 10000, exibir: true },

			// Botões adicionais
			// {
			// 	tipo: Tipo do botão: BUTTON, RESET, SUBMIT,
			//  texto: Texto a ser exibido no botão,
			// 	classe: Classe para definir o visual do botão,
			//  funcao: Função a ser executada pelo clique do botão
			// }
            botoes: [{
                texto: 'Ok', classe: 'btn-principal', funcao: function () {
                    return true;
                },
                padrao: false
            }],

			// Aparência
			aparencia: { tema: plugin_formulario_tema || 'dl-formulario', estilo: 'mostrarmsg.tema' }
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend(mesclar === true, {}, padrao, opcoes);

		// Carregar o tema para o formulário e seus elementos
		if( typeof(carregarCSS) === 'function' ){
			carregarCSS('web/js/min/dl-formulario/temas/' + opcoes.aparencia.tema + '/css/' + opcoes.aparencia.estilo + '.css');
		} // Fim if

		/**
		 * @var string evt_ns Nome do NAMESPACE a ser utilizado nos eventos
		 */
		var evt_ns = '__msg';


		// Criar os elementos da mensagem --------------------------------------------------------------------------- //
		// Recipiente da mensagem
		var $div = $(document.createElement('div')).addClass(__plugin + ' ' + opcoes.aparencia.tema + ' ' + opcoes.tipo.join(' ')).appendTo($th);

		// Parágrafo que conterá a mensagem
		var $paragr = $(document.createElement('p')).addClass('paragr').appendTo($div);

		// Span que receberá o texto
		$(document.createElement('span')).addClass('texto').html(opcoes.mensagem).appendTo($paragr);

		// Recipiente de botões
		var $botoes = $(document.createElement('div')).addClass('botoes').appendTo($paragr);


		// Criar os botões ------------------------------------------------------------------------------------------ //
		var btn_qtde = opcoes.botoes.length, btn;
        var btn_funcao = function (evt) {
            esconderMsg(this, evt.data.funcao);
        };

        for (var i = 0; i < btn_qtde; i++) {
            btn = opcoes.botoes[i];

            $(document.createElement('button')).addClass('botao ' + (btn.classe || ''))
                .text(btn.texto).attr({
                    type: 'button',
                    'data-padrao': btn.padrao
                })
                .on('click.' + evt_ns, {funcao: btn.funcao}, btn_funcao).appendTo($botoes);
        } // Fim for


		// Tempo de exibição da mensagem ---------------------------------------------------------------------------- //
		// Configurar o tempo de exibição dessa mensagem
		setTimeout(function(){ $th.find(':button[data-padrao="true"]').trigger('click.' + evt_ns); }, opcoes.tempo.num);

		// Mostrar o tempo de exibição em contagem regressiva
		if (opcoes.tempo.exibir) {
			var $tmp = $(document.createElement('span')).addClass('tempo')
				.html('Esta mensagem sumirá automaticamente em <b>' + opcoes.tempo.num / 1000 + '</b> segundos')
				.appendTo($div);

			var tmp_i = msg_c.length + 1;

			msg_c[tmp_i] = window.setInterval(function () {
				var $b = $tmp.find('b');
				var na = parseInt($b.text());

				if (na === 1) {
					window.clearTimeout(msg_c[tmp_i]);
				} // Fim if

				$b.text(na - 1);
			}, 1000);
		} // Fim if

		// Configurar a tecla ESC ----------------------------------------------------------------------------------- //
        $(window).on('keyup.' + evt_ns, function (evt) {
            var kc = evt.keyCode || evt.charCode || evt.which;

            /*
             * CORRIGIR: Tecla ENTER não funciona da maneira adequada
             */
            if (/* kc === 13 || */kc === 27) {
                $th.find('[data-padrao="true"]').trigger('click.' + evt_ns);
            } // Fim if
        });

		return $div;
	};


	/**
	 * Exibir uma mensagem pedindo confirmação de uma ação
	 */
	$.fn.msgConfirmacao = function(opcoes){
		var $th = $(this);

		// Opções padrão
		var padrao = {
			// Título
			titulo: 'Confirmação',

			// Mensagem a ser mostrada
			mensagem: 'Português: Mensagem padrão!\nEnglish: Default menssage!',

			// Tipo de mensagem a ser mostrada
			// Obs: Também pode interferir na aparência da mensagem
			tipo: ['-confirmacao'],

			// Botão confirmar / sim
			botao_sim: { texto: 'Sim', classe: '-sim', funcao: function(){ return true; } },

			// Botão cancelar / não
			botao_nao: { texto: 'Não', classe: '-nao', funcao: function(){ return false; }, padrao: true },

			// Aparência
			aparencia: { tema: plugin_formulario_tema || 'dl-formulario', estilo: 'mostrarmsg.tema' }
		};

		// Carregar as opções e mesclá-las com as opções padrao
		opcoes = $.extend({}, padrao, opcoes);


		// Exibir a mensagem
		return $th.mostrarMsg({
			mensagem: '<span class="titulo">' + opcoes.titulo + '</span>' + opcoes.mensagem,
			tipo: opcoes.tipo,
			botoes: [ opcoes.botao_sim, opcoes.botao_nao ],
			tempo: { num: 9999999999, exibir: false },
			aparencia: opcoes.aparencia
		});
	};
})(jQuery);