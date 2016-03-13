<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 11/01/2015 15:14:07
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class TipoDadoContato extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new WebM\TipoDadoContato(), 'website', TXT_MODELO_TIPODADOCONTATO);
        $this->carregarPost([
            'id'          => FILTER_VALIDATE_INT,
            'nome'        => FILTER_SANITIZE_STRING,
            'exibicao'    => FILTER_SANITIZE_STRING,
            'rede_social' => FILTER_VALIDATE_BOOLEAN,
            'mascara'     => FILTER_DEFAULT,
            'expreg'      => FILTER_DEFAULT,
            'exemplo'     => FILTER_DEFAULT,
            'publicar'    => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'tipo_dado_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_IMAGEM_HTML, \DL3::$dir_relativo, 'tipo_dado_icone', TXT_LISTA_TITULO_ICONE) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, "CONCAT(tipo_dado_nome, '<br/>', tipo_dado_exibicao)", TXT_LISTA_TITULO_DESCR) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'tipo_dado_rede_social', TXT_LISTA_TITULO_REDE_SOCIAL) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'tipo_dado_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'tipo_dado_rede_social, tipo_dado_nome', null);

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_TIPOS_DADO_CONTATO);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/tipos-de-dados/');
        $this->visao->adParam('form-acao', 'website/tipos-de-dados/remover-tipo-de-dado');
        $this->visao->adParam('campos', [
            ['valor' => 'tipo_dado_nome', 'texto' => TXT_ROTULO_DESCR]
        ]);
        $this->visao->adParam('outros-links', [
            [
                'tipo'           => 'lista',
                'link'           => 'website/dados-para-contato',
                'texto'          => TXT_LINK_DADOS_PARA_CONTATO,
                'title'          => null,
                'mostrar-texto?' => true,
                'atributos'      => []
            ]
        ]);
    } // Fim do método mostrarLista


    /**
     * Mostrar formulário de inclusão e edição do registro
     *
     * @param int    $pk        PK do registro a ser selecionado
     * @param string $pg_mestra Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pk = null, $pg_mestra = null) {
        $this->formPadrao('tipo-dado', 'tipos-de-dados/salvar', 'tipos-de-dados/salvar', 'website/tipos-de-dados', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_tipo_dado', $pg_mestra);
    } // Fim do método mostrarForm


    /**
     * Obter as opções avançadas desse tipo de dado
     */
    public function opcoesAvancadas() {
        $this->modelo->selecionarPK(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));

        echo json_encode([
            'mascara' => (string)$this->modelo->mascara,
            'expreg'  => (string)$this->modelo->expreg,
            'exemplo' => (string)$this->modelo->exemplo
        ]);
    } // Fim do método opcoesAvancadas


    /**
     * Selecionar dados para carregar um campo select
     *
     * @param string $f Filtro a ser aplicado
     * @param bool   $e Define se o resultado da consulta será escrito ou retornado pela função
     */
    public function carregarSelect($f = null, $e = true) {
        return $this->modelo->carregarSelect($f, $e, 'id', 'nome');
    } // Fim do método carregarSelect
} // Fim do Controle TipoDadoContato