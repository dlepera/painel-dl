<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 11/01/2015 20:35:31
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class DadoContato extends GeralC\PainelDL {
    public function __construct() {
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
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'dado_contato_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'dado_contato_descr', TXT_LISTA_TITULO_DESCR) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'tipo_dado_nome', TXT_LISTA_TITULO_TIPO) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'dado_contato_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'tipo_dado_rede_social, tipo_dado_nome, dado_contato_descr', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_DADOS_CONTATO);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/dados-para-contato/');
        $this->visao->adParam('form-acao', 'website/dados-para-contato/excluir-dados');
        $this->visao->adParam('campos', [
            ['valor' => 'dado_contato_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'tipo_dado_nome', 'texto' => TXT_ROTULO_TIPO]
        ]);
        $this->visao->adParam('outros-links', [
            [
                'tipo'           => 'lista',
                'link'           => 'website/tipos-de-dados',
                'texto'          => TXT_LINK_TIPOS_DADOS,
                'title'          => null,
                'mostrar-texto?' => true,
                'atributos'      => []
            ]
        ]);
    } // Fim do método mostrarLista


    /**
     * Mostrar formulário de inclusão e edição do registro
     *
     * @param int    $pk        Valor da PK do registro a ser selecionado
     * @param string $pg_mestra Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pk = null, $pg_mestra = null) {
        $this->formPadrao('dado', 'dados-para-contato/salvar', 'dados-para-contato/salvar', 'website/dados-para-contato', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_dado', $pg_mestra);

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