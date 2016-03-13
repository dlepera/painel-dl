<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 08/01/2015 18:20:35
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;

class Idioma extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new DevM\Idioma(), 'desenvolvedor', TXT_MODELO_IDIOMA);
        $this->carregarPost([
            'id'       => FILTER_VALIDATE_INT,
            'descr'    => FILTER_SANITIZE_STRING,
            'sigla'    => FILTER_SANITIZE_STRING,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'idioma_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'idioma_descr', TXT_LISTA_TITULO_DESCR) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'idioma_sigla', TXT_LISTA_TITULO_SIGLA) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'idioma_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'idioma_descr', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro', null, 1);
        $this->carregarHTML('comum/visoes/lista_padrao', null, 2);
        $this->visao->setTitulo(TXT_PAGINA_TITULO_IDIOMAS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'desenvolvedor/idiomas/');
        $this->visao->adParam('form-acao', 'desenvolvedor/idiomas/remover-idioma');
        $this->visao->adParam('campos', [
            ['valor' => 'idioma_descr', 'texto' => TXT_ROTULO_DESCRICAO],
            ['valor' => 'idioma_sigla', 'texto' => TXT_ROTULO_SIGLA]
        ]);
    } // Fim do método mostrarLista


    /**
     * Mostrar o formulário de inclusão e edição
     *
     * @param int    $pk  PK do registro a ser selecionado
     * @param string $mst Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pk = null, $mst = 'padrao') {
        $this->formPadrao('idioma', 'idiomas/salvar', 'idiomas/salvar', 'desenvolvedor/idiomas', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_idioma', $mst);
    } // Fim do método mostrarForm
} // Fim do Controle Tema