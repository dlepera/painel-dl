<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 10/01/2015 12:08:58
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \Geral\Modelo as GeralM;
use \WebSite\Modelo as WebM;

class ContatoSite extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new WebM\ContatoSite(), 'website', TXT_MODELO_CONTATOSITE);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'contato_site_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'log_registro_data', TXT_LISTA_TITULO_DATA) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, "( CASE COALESCE(contato_site_assunto, 0) WHEN 0 THEN 'Não informado' ELSE CONCAT('<span style=\"color: ', assunto_contato_cor, '\">', assunto_contato_descr, '</span>') END )", TXT_LISTA_TITULO_ASSUNTO) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'contato_site_nome', TXT_LISTA_TITULO_NOME) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'contato_site_email', TXT_LISTA_TITULO_EMAIL),
            'log_registro_data DESC', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONTATOS_RECEBIDOS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/contatos-recebidos/');
        $this->visao->adParam('form-acao', 'website/contatos-recebidos/apagar-contato');
        $this->visao->adParam('campos', [
            ['valor' => 'contato_site_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'contato_site_email', 'texto' => TXT_ROTULO_EMAIL],
            ['valor' => 'assunto_contato_descr', 'texto' => TXT_ROTULO_ASSUNTO],
            ['valor' => 'log_registro_data_criacao', 'texto' => TXT_ROTULO_DATA]
        ]);
        $this->visao->adParam('perm-detalhes?', \DL3::$autent->verificarPerm(get_called_class(), 'mostrarDetalhes'));
    } // Fim do método mostrarLista


    /**
     * Mostrar detalhes do registro
     *
     * @param int $pk Valor da PK do registro a ser selecionado
     *
     * @throws \DL3Exception
     */
    protected function mostrarDetalhes($pk) {
        $this->modelo->selecionarPK($pk);

        if ($this->modelo->reg_vazio) {
            throw new \DL3Exception(ERRO_CONTATOSITE_MOSTRADETALHES_NAO_ENCONTRADO, 1404);
        } // Fim if

        # Visão
        // $this->carregarHTML('comum/visoes/menu_acao_registro');
        $this->carregarHTML('det_contato');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_DETALHES_CONTATO);

        # Assunto do contato
        if ($this->modelo->assunto > 0) {
            $ma = new WebM\AssuntoContato($this->modelo->assunto);

            $this->visao->adParam('assunto-descr', $ma->getDescr());
            $this->visao->adParam('assunto-cor', $ma->getCor());
        } // Fim if

        # Registrar a leitura desse contato e obter a lista de quem já leu
        $mlc = new WebM\LeituraContato();
        $mlc->setLeituraContato($pk);
        $mlc->setUsuario($_SESSION['usuario_id']);
        $mlc->salvar();
        $llc = $mlc->listar("leitura_contato = {$this->modelo->id}", 'leitura_contato_data DESC', "leitura_contato_data, COALESCE(usuario_info_nome, 'Super Admin') AS USUARIO");

        # Parâmetro
        $this->visao->adParam('modelo', $this->modelo);
        $this->visao->adParam('log-email', new GeralM\LogEmail($this->modelo->getBdTabela(), $pk));
        $this->visao->adParam('leituras', $llc);
    } // Fim do método mostrarDetalhes
} // Fim do Controle ContatoSite