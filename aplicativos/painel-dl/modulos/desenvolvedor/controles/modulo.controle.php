<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 07/01/2015 16:37:18
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class Modulo extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new DevM\Modulo(), 'desenvolvedor', TXT_MODELO_MODULO);
        $this->carregarPost([
            'id'       => FILTER_VALIDATE_INT,
            'pai'      => FILTER_VALIDATE_INT,
            'nome'     => FILTER_SANITIZE_STRING,
            'descr'    => FILTER_DEFAULT,
            'menu'     => FILTER_VALIDATE_BOOLEAN,
            'link'     => FILTER_SANITIZE_STRING,
            'ordem'    => FILTER_VALIDATE_INT,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'M.modulo_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, "CONCAT(M.modulo_nome, '<br/>', COALESCE(S.modulo_nome, ''))", TXT_LISTA_TITULO_NOME) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'M.modulo_link', TXT_LISTA_TITULO_LINK) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'M.modulo_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'S.modulo_nome, M.modulo_nome', null
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_MODULOS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'desenvolvedor/modulos/');
        $this->visao->adParam('form-acao', 'desenvolvedor/modulos/desinstalar-modulo');
        $this->visao->adParam('campos', [
            ['valor' => 'M.modulo_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'M.modulo_link', 'texto' => TXT_ROTULO_LINK]
        ]);
    } // Fim do método mostrarLista


    /**
     * Mostrar o formulário de inclusão e edição do registro
     *
     * @param int $pk PK do registro a ser selecionado
     */
    protected function mostrarForm($pk = null) {
        $inc = $this->formPadrao('modulo', 'modulos/instalar-modulo', 'modulos/atualizar-modulo', 'desenvolvedor/modulos', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_modulo');

        # Lista de módulos 'pai'
        $l_mp = $this->modelo->listar('M.modulo_pai IS NULL' .
            (!$inc && $this->modelo->pai === 0 ? " AND M.modulo_id <> {$this->modelo->id}" : ''),
            'M.modulo_nome', 'M.modulo_id AS VALOR, M.modulo_nome AS TEXTO');

        # Parâmetros
        $this->visao->adParam('modulos-pai', $l_mp);

        if (!$inc) {
            # Funcionalidades
            $m_mf = new DevM\ModuloFunc();
            $l_mf = $m_mf->listar(
                "func_modulo = {$this->modelo->id}", 'func_modulo_classe, func_modulo_descr',
                'func_modulo_id AS ' . TXT_LISTA_TITULO_ID . ',' .
                " CONCAT(func_modulo_descr, '<br/>', func_modulo_classe) AS '" . TXT_LISTA_TITULO_DESCR . "'"
            );

            if ($this->modelo->pai > 0) {
                $this->carregarHTML('lista_funcs');
            } // Fim if

            $this->visao->adParam('lista', $l_mf);
        } // Fim if
    } // Fim do método mostrarForm


    /**
     * Filtrar menu
     *
     * @param string  $bm Termo a ser buscado no cadastro de modulos
     * @param boolean $e  Define se a pesquisa retornada será escrita ou será retornada
     *
     * @return array
     */
    public function filtroMenu($bm, $e = true) {
        $r = json_encode($this->modelo->listarMenu("M.modulo_nome LIKE '%{$bm}%' OR M.modulo_descr LIKE '%{$bm}%'", 'M.modulo_nome', 'M.modulo_nome, M.modulo_descr'));

        if ($e) {
            print($r);
        } // Fim if

        return $r;
    } // Fim do método filtroMenu


    /**
     * Criar as funcionalidades padrão para edição de qualquer registro
     *
     * @param int $pk ID do módulo
     */
    protected function criarFuncionalidadesPadrao($pk) {
        $this->modelo->selecionarPK($pk);
        $retorno = [
            0 => ['mensagem' => ERRO_MODULO_CRIARFUNCIONALIDADESPADRAO, 'tipo' => '-erro'],
            1 => ['mensagem' => SUCESSO_MODULO_CRIARFUNCIONALIDADESPADRAO, 'tipo' => '-sucesso']
        ];
        $criar = (int)$this->modelo->criarFuncionalidadesPadrao();

        \Funcoes::mostrarMsg($retorno[$criar]['mensagem'], $retorno[$criar]['tipo']);
    } // Fim do método criarFuncionalidadesPadrao


    /**
     * Salvar um registro através do modelo
     */
    protected function salvar() {
        parent::salvar();

        if (filter_input(INPUT_POST, 'criar-funcs', FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]])) {
            $this->criarFuncionalidadesPadrao($this->modelo->id);
        } // Fim if

        \Funcoes::mostrarMsg(sprintf(SUCESSO_PADRAO_REGISTRO_SALVO, $this->nome), '-sucesso');
    } // Fim do método salvar
} // Fim do Controle Modulo