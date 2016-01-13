<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 20:35:31
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class DadoContato extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\DadoContato(), 'website', TXT_MODELO_DADOCONTATO);
        $this->carregarPost([
            'id'       => FILTER_VALIDATE_INT,
            'tipo'     => FILTER_VALIDATE_INT,
            'descr'    => FILTER_SANITIZE_STRING,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function mostrarLista(){
        $this->listaPadrao('dado_contato_id AS ' . TXT_LISTA_TITULO_ID . ', dado_contato_descr AS ' . TXT_LISTA_TITULO_DESCR . ','
            . ' tipo_dado_nome AS ' . TXT_LISTA_TITULO_TIPO . ','
            . " ( CASE dado_contato_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'tipo_dado_nome, dado_contato_descr', null);

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('lista_dados');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_DADOS_CONTATO);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/dados-para-contato/');
        $this->visao->adParam('form-acao', 'website/dados-para-contato/excluir-dados');
        $this->visao->adParam('campos', [
            ['valor' => 'dado_contato_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'tipo_dado_descr', 'texto' => TXT_ROTULO_TIPO]
        ]);
    } // Fim do método mostrarLista




    /**
     * Mostrar formulário de inclusão e edição do registro
     *
     * @param int    $pk  Valor da PK do registro a ser selecionado
     * @param string $mst Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pk = null, $mst = null){
        $this->formPadrao('dado', 'dados-para-contato/salvar', 'dados-para-contato/salvar', 'website/dados-para-contato', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_dado', $mst);

        $m_td = new WebM\TipoDadoContato();
        $l_td = $m_td->carregarSelect('tipo_dado_publicar = 1', false, 'id', 'nome');

        if (!$this->modelo->reg_vazio) {
	        $m_td->selecionarPK($this->modelo->tipo);
	        $this->visao->adParam('macara', $m_td->getMascara());
	        $this->visao->adParam('expreg', $m_td->getExpreg());
	        $this->visao->adParam('exemplo', $m_td->getExemplo());
        } // Fim if

        # Parâmetros
        $this->visao->adParam('tipos', $l_td);
        $this->visao->adParam('novo-tipo?', \DL3::$autent->verificarPerm('WebSite\Controle\TipoDadoContato', 'mostrarForm'));
    } // Fim do método mostrarForm
} // Fim do Controle DadoContato