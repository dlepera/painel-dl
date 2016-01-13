<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 17:11:54
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class GoogleAnalytics extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\GoogleAnalytics(), 'website', TXT_MODELO_GOOGLEANALYTICS);
        $this->carregarPost([
            'id' => FILTER_VALIDATE_INT,
            'apelido' => FILTER_SANITIZE_STRING,
            'usuario' => FILTER_SANITIZE_STRING,
            'perfil_id' => FILTER_VALIDATE_INT,
            'codigo_ua' => FILTER_SANITIZE_STRING,
            'principal' => FILTER_VALIDATE_BOOLEAN,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar lista de registros
	 */
    protected function mostrarLista(){
        $this->listaPadrao('ga_id AS ' . TXT_LISTA_TITULO_ID . ', ga_apelido AS ' . TXT_LISTA_TITULO_APELIDO . ','
            . ' ga_usuario AS ' . TXT_LISTA_TITULO_USUARIO . ", ga_perfil_id AS '" . TXT_LISTA_TITULO_PERFIL . "',"
            . " ( CASE ga_principal  WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PRINCIPAL . "',"
	        . " ( CASE ga_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
	        'ga_perfil_id', null);

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('msg_ga');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONFIGURACOES_GA);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/google-analytics/');
        $this->visao->adParam('form-acao', 'website/google-analytics/excluir-configuracao');
        $this->visao->adParam('campos', [
            ['valor' => 'ga_usuario', 'texto' => TXT_ROTULO_USUARIO],
            ['valor' => 'ga_perfil_id', 'texto' => TXT_ROTULO_PERFIL]
        ]);
    } // Fim do método mostrarLista




	/**
	 * Mostrar formulário de inclusão e edição do registro
	 *
	 * @param int $pk Valor da PK do registro a ser selecionado
	 */
    protected function mostrarForm($pk = null){
        $this->formPadrao('ga', 'google-analytics/salvar', 'google-analytics/salvar', 'website/google-analytics', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_ga');
    } // Fim do método mostrarForm
} // Fim do Controle GoogleAnalytics