<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 15:14:07
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class TipoDadoContato extends GeralC\PainelDL{
    public function __construct(){
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
    protected function mostrarLista(){
        $this->listaPadrao('tipo_dado_id AS ' . TXT_LISTA_TITULO_ID . ','
	        . " CONCAT('<img src=\"" . \DL3::$dir_relativo . "', tipo_dado_icone, '\" class=\"tbl-imagem\" alt/>') AS " . TXT_LISTA_TITULO_ICONE . ','
            . " CONCAT(tipo_dado_nome, '<br/>', tipo_dado_exibicao) AS '" . TXT_LISTA_TITULO_DESCR . "',"
            . " ( CASE tipo_dado_rede_social WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) '" . TXT_LISTA_TITULO_REDE_SOCIAL . "',"
            . " ( CASE tipo_dado_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
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
    } // Fim do método mostrarLista




	/**
	 * Mostrar formulário de inclusão e edição do registro
	 *
	 * @param int    $pk  PK do registro a ser selecionado
	 * @param string $mst Nome da página mestra a ser carregada
	 */
    protected function mostrarForm($pk = null, $mst = null){
        $this->formPadrao('tipo-dado', 'tipos-de-dados/salvar', 'tipos-de-dados/salvar', 'website/tipos-de-dados', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_tipo_dado', $mst);
    } // Fim do método mostrarForm




	/**
	 * Obter as opções avançadas desse tipo de dado
	 */
    public function opcoesAvancadas(){
        $this->modelo->selecionarPK(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));

        echo json_encode([
            'mascara' => (string)$this->modelo->mascara,
            'expreg'  => (string)$this->modelo->expreg,
            'exemplo' => (string)$this->modelo->exemplo
        ]);
    } // Fim do método opcoesAvancadas
} // Fim do Controle TipoDadoContato