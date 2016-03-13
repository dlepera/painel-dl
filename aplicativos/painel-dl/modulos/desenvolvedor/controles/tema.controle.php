<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 08/01/2015 13:30:33
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;

class Tema extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new DevM\Tema(), 'desenvolvedor', TXT_MODELO_TEMA);
        $this->carregarPost([
            'id'            => FILTER_VALIDATE_INT,
            'descr'         => FILTER_SANITIZE_STRING,
            'diretorio'     => FILTER_SANITIZE_STRING,
            'pagina_mestra' => FILTER_SANITIZE_STRING,
            'padrao'        => FILTER_VALIDATE_BOOLEAN,
            'publicar'      => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de temas
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'tema_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, "CONCAT(tema_descr, '<br/>', tema_diretorio)", TXT_LISTA_TITULO_DESCR) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'tema_padrao', TXT_LISTA_TITULO_PADRAO) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'tema_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'tema_descr', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_TEMAS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'desenvolvedor/temas/');
        $this->visao->adParam('form-acao', 'desenvolvedor/temas/desinstalar-tema');
        $this->visao->adParam('campos', [
            ['valor' => 'tema_descr', 'texto' => TXT_ROTULO_DESCRICAO],
            ['valor' => 'tema_diretorio', 'texto' => TXT_ROTULO_DIRETORIO]
        ]);
    } // Fim do método _mostrartemas


    /**
     * Formulário de inclusão e edição do tema
     *
     * @param int  $pk  PK do registro a ser selecionado
     * @param bool $mst Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pk = null, $mst = null) {
        $this->formPadrao('tema', 'temas/instalar-tema', 'temas/atualizar-tema', 'desenvolvedor/temas', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_tema', $mst);

        # Parâmetros
        $this->visao->adParam('tema-dir-valido?', $this->modelo->verificarDiretorio());
    } // Fim di método mostrarForm
} // Fim do Controle Tema