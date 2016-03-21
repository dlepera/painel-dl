<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 09/01/2015 22:17:04
 */

namespace Admin\Controle;

use \Geral\Controle as GeralC;
use \Admin\Modelo as AdminM;

class ConfigEmail extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new AdminM\ConfigEmail(), 'admin', TXT_MODELO_CONFIGEMAIL);
        $this->carregarPost([
            'id'             => FILTER_VALIDATE_INT,
            'titulo'         => FILTER_SANITIZE_STRING,
            'host'           => FILTER_SANITIZE_STRING,
            'porta'          => FILTER_SANITIZE_NUMBER_INT,
            'autent'         => FILTER_VALIDATE_BOOLEAN,
            'cripto'         => FILTER_SANITIZE_STRING,
            'conta'          => FILTER_SANITIZE_STRING,
            'senha'          => FILTER_SANITIZE_STRING,
            'de_email'       => FILTER_VALIDATE_EMAIL,
            'de_nome'        => FILTER_SANITIZE_STRING,
            'responder_para' => FILTER_VALIDATE_EMAIL,
            'html'           => FILTER_VALIDATE_BOOLEAN,
            'principal'      => FILTER_VALIDATE_BOOLEAN,
            'debug'          => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'config_email_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'config_email_titulo', TXT_LISTA_TITULO) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'config_email_host', TXT_LISTA_TITULO_HOST) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'config_email_principal', TXT_LISTA_TITULO_PRINCIPAL),
            'config_email_titulo', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('lista_emails');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONFIGURACOES_ENVIO_EMAIL);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'admin/envio-de-emails/');
        $this->visao->adParam('form-acao', 'admin/envio-de-emails/excluir-configuracao');
        $this->visao->adParam('link-inserir', sprintf(TXT_LINK_NOVA, $this->nome));
        $this->visao->adParam('campos', [
            ['valor' => 'config_email_titulo', 'texto' => TXT_ROTULO_TITULO],
            ['valor' => 'config_email_host', 'texto' => TXT_ROTULO_HOST]
        ]);
        $this->visao->adParam('perm-testar?', \DL3::$autent->verificarPerm(get_called_class(), 'testar'));
    } // Fim do método mostrarLista


    /**
     * Mostrar formulário de inclusão e edição do registro
     *
     * @param int $pk PK do registro a ser selecionado
     */
    protected function mostrarForm($pk = null) {
        $inc = $this->formPadrao('email', 'envio-de-emails/salvar', 'envio-de-emails/salvar', 'admin/envio-de-emails', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_email');
        $this->visao->setTitulo($inc
            ? sprintf(TXT_PAGINA_TITULO_CADASTRAR_NOVA, $this->nome)
            : sprintf(TXT_PAGINA_TITULO_EDITAR_ESSA, $this->nome));

        # Parâmetros
        $this->visao->adParam('perm-testar?', \DL3::$autent->verificarPerm(get_called_class(), 'testar'));
    } // Fim do método mostrarForm


    /**
     * Testar uma determinada configuração de envio de e-mail]
     *
     * @param int $pk ID da configuração a ser testada
     *
     * @return mixed
     * @throws \DL3Exception
     */
    protected function testar($pk) {
        if (!class_exists('Email')) {
            throw new \DL3Exception(sprintf(ERRO_PADRAO_CLASSE_NAO_ENCONTRADA, 'Email'), 1500);
        } // Fim if

        $this->modelo->selecionarPK($pk);

        $corpo = sprintf(TXT_EMAIL_CONTEUDO_TESTE, $this->modelo->titulo, $this->modelo->host, $this->modelo->porta, filter_input(INPUT_SERVER, 'HTTP_HOST'));
        $para = session_status() === PHP_SESSION_ACTIVE ? $_SESSION['usuario_info_email'] : $this->modelo->responder_para;

        $oe = new \Email();
        $te = $oe->enviar($para, TXT_EMAIL_ASSUNTO_TESTE, $corpo, $pk);

        $oe->gravarLog(__CLASS__, $this->modelo->bd_tabela, $this->modelo->id, TXT_EMAIL_ASSUNTO_TESTE, $corpo, $para);

        if (!$te) {
            throw new \DL3Exception(sprintf(ERRO_CONFIGEMAIL_TESTAR, $oe->exibirLog()), 1500);
        } // Fim if

        \Funcoes::mostrarMsg(SUCESSO_CONFIGEMAIL_TESTAR, '-sucesso');
    } // Fim do método testar
} // Fim do Controle ConfigEmail