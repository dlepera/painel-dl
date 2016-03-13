/**
 * Created by dlepera on 16/09/15.
 */

/*global console, selecionarLinha, alternarPublicacao, $logout, $el, carregarForm, carregarHTML*/

// Funções ---------------------------------------------------------------------------------------------------------- //
/**
 * Pedir uma confirmação antes de executar uma ação
 *
 * @param {String} msg Mensagem que solicita a confirmação
 * @param {Function} acao Função a ser executada em caso de confirmação positiva
 * @param {String} titulo Título a ser exibido na tela de confirmação
 * @returns {*}
 */
function executarConfirm(msg, acao, titulo) {
    $('body').msgConfirmacao({
        titulo: titulo || 'Confirmação',
        mensagem: msg,
        botao_sim: {
            texto: 'Sim', classe: '-sim', funcao: function () {
                return acao();
            }
        },
        botao_nao: {
            texto: 'Não', classe: '-nao', funcao: function () {
                return false;
            }, padrao: true
        }
    });

    return true;
} // Fim executarComfirm


function verificarAlteracao(campo) {
    var $th = $(campo);
    var vlr_original = $th.attr('value');
    var vlr_atual = $th.val();

    $th.attr('data-alterado', (vlr_original !== vlr_atual) + 0);
} // Fim verificarAlteracao


function fazerLogout () {
    $.ajax({
        url: 'login/fazer-logout',
        dataType: 'json',
        success: function (retorno) {
            var qtde_msgs = retorno.length;
            var botoes = {
                '-sucesso': [
                    {
                        texto: 'Atualizar a página',
                        classe: '-com-destaque',
                        funcao: function () { window.location = $('base').attr('href'); },
                        padrao: true
                    }
                ]
            };

            retorno = qtde_msgs > 0 ? retorno[retorno.length - 1] : retorno;

            $('body').mostrarMsg({
                mensagem: retorno.mensagem,
                tipo: ['-alerta', retorno.tipo],
                botoes: botoes[retorno.tipo]
            }, false);
        }
    });
}


function albumModal(album, pg_mestra) {
    $.ajax({
        url: album + '/' + (pg_mestra || 'conteudo'),
        dataType: 'html',
        async: false, // Essa requisição precisa ser SÍNCRONA para impedir que a função retorne o jQuery sem o
                      // conteúdo HTML
        success: function (html) {
            // Carregar o conteúdo HTML
            $('body').append(html);
        }
    });
} // Fim function albumModal()


// Publicar ou ocultar um registro ---------------------------------------------------------------------------------- //
$('[data-acao="publicar-registro"], [data-acao="ocultar-registro"]').on('click.__acao', function(){
		var $th = $(this);

		// Selecionar a linha atual
		selecionarLinha(this, true);
		alternarPublicacao($th.data('acao-param-dir'));
});


// Excluir um registro ---------------------------------------------------------------------------------------------- //
$('[data-acao="excluir-registro"]').on('click.__acao', function () {
	var obj = this;
    var $this = $(this);
	var form = $this.data('acao-param-form');
	var executar = $this.data('acao-param-executar');
    var $form = typeof $el === 'undefined' ? $(form) : $el;

	return executarConfirm('Deseja realmente excluir esse(s) registro(s)?', function () {
		// Selecionar a linha atual
		selecionarLinha(obj, true);
		executar === undefined ? $form.submit()
            : $form.executar(
				executar, null, {
					'-sucesso': [
                        {
                            texto: 'Fechar',
                            classe: '-com-destaque',
                            funcao: function () { window.location.reload(); },
                            padrao: true
                        }
                    ]
				}
			);
	}, 'Confirmar exclusão');
});


// Testar configuração de e-mail ------------------------------------------------------------------------------------ //
$('[data-acao="testar-email"]').on('click.__acao', function(){
	var $th = $(this);
	$el.executar($th.data('acao-param-dir'), null, function(){ return null; });
});


// Bloquear / Desbloquear usuários ---------------------------------------------------------------------------------- //
$('[data-acao="bloquear-usuarios"], [data-acao="desbloquear-usuarios"]').on('click', function(){
	var $th = $(this);

	// Selecionar a linha atual
	selecionarLinha(this, true);
	$el.executar($th.data('acao-param-dir'), null, function(){ window.location.reload(); }, false);
});



// Carregar conteúdo HTML ------------------------------------------------------------------------------------------- //
$('[data-acao="carregar-html"]').on('click.__acao', function(){
	var $th = $(this);

	carregarHTML($th.data('acao-param-html'), 'html', $th.data('acao-param-pgmestra'));
});

$('[data-acao="carregar-form"]').on('click.__acao', function(){
	var $th = $(this);
	var func = $th.data('acao-param-func') || 'window.location.reload()';

	carregarForm($th.data('acao-param-html'), 'form', function(){ eval('(' + func + ')'); });
});



// Verificar a alteração dos campos --------------------------------------------------------------------------------- //
$('[data-verificar-alteracao="1"]').on('change.__acao', function(){
	verificarAlteracao(this);
});



// Solicitar confirmação para submeter um formulário ---------------------------------------------------------------- //
function confirmarSubmit(dom, evt, mensagem){
	var $th = $(dom);
	var $form = $th.parents('form');
	var msg = $th.data('acao-param-msg') || mensagem;

	if( $form[0].checkValidity() ){
		evt.stopPropagation();
		evt.preventDefault();

		executarConfirm(msg, function(){
			$form.find(':submit').off('.__acao').trigger('click')
				.on('click.__acao', function(evt){ confirmarSubmit(this, evt); });
		}, 'Confirmar ação');
	} // Fim if
} // Fim function confirmarSubmit

$('[data-acao="confirmar-submit"]').on('click.__acao', function(evt){ confirmarSubmit(this, evt); });


// Aplicar máscaras automaticamente --------------------------------------------------------------------------------- //
$('[data-mask]').each(function(){
	var $th = $(this);
	$th.mascara($th.data('mask'));
});


// Criar funcionalidades padrão no módulo de módulos ---------------------------------------------------------------- //
$('[data-acao="criar-funcionalidades"]').on('click.__acao', function(){
	var $th = $(this);
	var pk = $th.data('acao-param-pk');

	$.ajax({
		url: 'desenvolvedor/modulos/editar/' + pk + '/criar-funcionalidades-padrao',
		dataType: 'json',
		success: function(retorno){
			retorno = retorno[retorno.length - 1];

			$('body').mostrarMsg({
				mensagem: retorno.mensagem,
				tipo: ['-alerta', retorno.tipo],
				botoes: [ { funcao: function(){ window.location.reload(); } } ]
			}, true);
		}
	});
});


// Fazer logout ----------------------------------------------------------------------------------------------------- //
$('[data-acao="fazer-logout"]').on('click.__acao', fazerLogout);


// Álbum de fotos 'modal' ------------------------------------------------------------------------------------------- //
$('[data-acao="album-modal"]').on('click.__acao', function () {
    var $this = $(this);
    albumModal($this.data('acao-param-html'), $this.data('acao-param-pgmestra'));
});