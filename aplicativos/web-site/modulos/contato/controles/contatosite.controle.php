<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 17:12:57
 */

namespace Contato\Controle;

use \Geral\Controle as GeralC;
use \Geral\Modelo as GeralM;
use \Contato\Modelo as ContatoM;

class ContatoSite extends GeralC\WebSite{
    public function __construct(){
        parent::__construct(new ContatoM\ContatoSite(), 'contato', TXT_MODELO_CONTATOSITE);
	    $this->carregarPost([
		    'nome'     => FILTER_SANITIZE_STRING,
		    'email'    => FILTER_VALIDATE_EMAIL,
		    'telefone' => FILTER_SANITIZE_STRING,
		    'assunto'  => FILTER_VALIDATE_INT,
		    'mensagem' => FILTER_DEFAULT
	    ]);
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de contato
	 */
    public function mostrarForm(){
        $this->formPadrao('contato', 'enviar', null, 'contato', null);

        # Visões
        $this->carregarHTML('formulario');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONTATO);

        # Selecionar os assuntos de contatos
        $ma = new ContatoM\AssuntoContato();
        $la = $ma->carregarSelect('assunto_contato_publicar = 1', false);

        # Parâmetros
        $this->visao->adParam('mostrar-assunto?', (bool)$la);
        $this->visao->adParam('assuntos', $la);
        $this->visao->adParam('usar-recaptcha?', !empty(\DL3::$recaptcha_chave_site) && !empty(\DL3::$recaptcha_chave_secreta));
    } // Fim do método mostrarForm




	/**
	 * Salvar e enviar o registro de contato
	 */
    public function enviar(){
        $this->salvar();

        # Enviar por e-mail
	    if (class_exists('Email')) {
		    if ($this->modelo->assunto > 0) {
		        $ma = new ContatoM\AssuntoContato();
		        $la = end($ma->listar("assunto_contato_id = {$this->modelo->assunto}", null, 'assunto_contato_descr, assunto_contato_email'));
		        $as = $la['assunto_contato_descr'];
		        $pa = $la['assunto_contato_email'];
	        } else {
		        $as = MSG_NAO_INFORMADO;
		        $pa = 'contato@diegolepera.xyz';
	        } // Fim if( class_exists('Email') )

		    # Montar o assunto e o corpo do e-mail
	        $assunto = sprintf(TXT_EMAIL_ASSUNTO_CONTATOSITE, ($h = filter_input(INPUT_SERVER, 'HTTP_HOST')), $as);
	        $corpo = sprintf(TXT_EMAIL_CONTEUDO_CONTATOSITE, $h, $this->modelo->nome, $this->modelo->email, $this->modelo->telefone, $as, nl2br($this->modelo->mensagem));

            /*
             * Enviar o e-mail utilizando a configuração feita pelo Painel-DL
             */
            $conf_site = new GeralM\ConfiguracaoSite();

	        $om = new \Email();
	        $e = $om->enviar($pa, $assunto, $corpo, $conf_site->getEmail());
	        $om->gravarLog(__CLASS__, $this->modelo->bd_tabela, $this->modelo->id);

		    if (!$e) {
		        throw new \DL3Exception(sprintf(ERRO_CONTATOSITE_ENVIO_EMAIL, $om->exibirLog()), 1500);
	        } // Fim if
        } // if

        \Funcoes::mostrarMsg(SUCESSO_CONTATOSITE_ENVIADO, '__msg-sucesso');
    } // Fim do método enviar
} // Fim do Controle ContatoSite