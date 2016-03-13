<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 07/01/2015 16:27:37
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class Modulo extends GeralM\EdicaoRegistro {
    protected $id;
    protected $pai;
    protected $nome;
    protected $descr;
    protected $menu = true;
    protected $link;
    protected $ordem = 0;
    protected $publicar = true;
    protected $delete = false;


    /**
     * @return int
     */
    public function getPai() {
        return $this->pai;
    }


    /**
     * @param int $pai
     */
    public function setPai($pai) {
        $this->pai = filter_var($pai, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }


    /**
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = $nome;
    }


    /**
     * @return string
     */
    public function getDescr() {
        return $this->descr;
    }


    /**
     * @param string $descr
     */
    public function setDescr($descr) {
        $this->descr = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return boolean
     */
    public function isMenu() {
        return (bool)$this->menu;
    }


    /**
     * @param boolean $menu
     */
    public function setMenu($menu) {
        $this->menu = filter_var($menu, FILTER_VALIDATE_BOOLEAN);
    }


    /**
     * @return mixed
     */
    public function getLink() {
        return $this->link;
    }


    /**
     * @param mixed $link
     */
    public function setLink($link) {
        $this->link = filter_var($link, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return int
     */
    public function getOrdem() {
        return $this->ordem;
    }


    /**
     * @param int $ordem
     */
    public function setOrdem($ordem) {
        $this->ordem = filter_var($ordem, FILTER_VALIDATE_INT, ['options' => ['default' => 0]]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_modulos', 'modulo_');

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS M'
            . " LEFT JOIN {$this->bd_tabela} AS S ON( S.{$this->bd_prefixo}id = M.{$this->bd_prefixo}pai )"
            . ' WHERE M.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct


    /**
     * Selecionar um registro através da chave primária (PK - Primary Key)
     *
     * @param string $v Valor a ser pesquisado na PK
     * @param string $a Alias da tabela principal configurado na consulta
     *
     * @return bool
     * @throws \DL3Exception
     */
    public function selecionarPK($v, $a = 'M') {
        return parent::selecionarPK($v, $a);
    } // Fim do método selecionarPK


    /**
     * Selecionar apenas os itens que devem aparecer no menu
     *
     * @param string $flt Parte do filtro a ser aplicado na consulta
     * @param string $ord Ordenação dos registros a ser aplicada na consulta
     * @param string $cmp Lista de campos a ser retornada
     * @param int    $pgn Número da página de registros
     * @param int    $qtd Quantidade de registros a serem exibidos na paginação
     *
     * @return array
     */
    public function listarMenu($flt = null, $ord = null, $cmp = '*', $pgn = 0, $qtd = 20) {
        $q = $this->bd_select;

        $this->bd_select = 'SELECT DISTINCT %s'
            . ' FROM dl_painel_grupos_funcs AS GF'
            . ' INNER JOIN dl_painel_modulos_funcs AS FM ON( FM.func_modulo_id = GF.func_modulo_id )'
            . " INNER JOIN %s AS M ON( M.{$this->bd_prefixo}id = FM.func_modulo )"
            . " INNER JOIN dl_painel_funcs_metodos AS MF ON( MF.metodo_func = FM.func_modulo_id AND (MF.metodo_func_descr = 'mostrarLista' OR MF.metodo_func_descr = 'mostrarMenu')  )"
            . " WHERE M.%sdelete = 0 AND M.{$this->bd_prefixo}menu = 1 AND GF.grupo_usuario_id = {$_SESSION['usuario_info_grupo']}";

        $l = $this->listar($flt, $ord, $cmp, $pgn, $qtd);

        $this->bd_select = $q;

        return $l;
    } // Fim do método listarMenu


    // Funcionalidades ---------------------------------------------------------------------------------------------- //
    /**
     * Tentar identificar automaticamente o nome da classe
     *
     * @return string
     */
    public function nomeClasse() {
        if (!isset($this->pai)) {
            return '<span class="mostrar-msg -erro">Essa funcionalidade está disponível apenas para <b>sub-módulos</b>.</span>';
        } // Fim if

        $mod_pai = clone $this;
        $mod_pai->selecionarPK($this->pai);

        return \Funcoes::converterPSR($mod_pai->getNome()) .
        '\\Controle\\' .
        \Funcoes::converterPSR(
            preg_replace(
                ['~s(\s+|$)~', EXPREG_PREPOSICOES],
                '',
                $this->nome
            )
        );
    } // Fim do método nomeClasse


    /**
     * Criar as funcionalidades padrão para edição de qualquer registro
     */
    public function criarFuncionalidadesPadrao() {
        $classe = $this->nomeClasse();
        $grupos = [1, 3];
        $mfn = new ModuloFunc();
        $mfn->setFuncModulo($this->id);
        $mfn->setClasse($classe);

        # Ver a lista de registros
        $mfn_clone = clone $mfn;
        $mfn_clone->setDescr('Ver a lista de registros');
        $mfn_clone->setMetodos(['mostrarLista']);
        $mfn_clone->setGrupos($grupos);
        $v = $mfn_clone->salvar();

        unset($mfn_clone);

        # Cadastrar e editar registros
        $mfn_clone = clone $mfn;
        $mfn_clone->setDescr('Cadastrar e editar registros');
        $mfn_clone->setMetodos(['mostrarForm', 'salvar', 'alternarPublicacao']);
        $mfn_clone->setGrupos($grupos);
        $s = $mfn_clone->salvar();

        unset($mfn_clone);

        # Excluir registros
        $mfn_clone = clone $mfn;
        $mfn_clone->setDescr('Excluir registros');
        $mfn_clone->setMetodos(['remover']);
        $mfn_clone->setGrupos($grupos);
        $x = $mfn_clone->salvar();

        unset($mfn_clone);

        return $v && $s && $x;
    } // Fim do método criarFuncionalidadesPadrao
} // Fim do Modelo Modulo