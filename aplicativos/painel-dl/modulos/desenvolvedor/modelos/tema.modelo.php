<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 08/01/2015 13:33:06
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class Tema extends GeralM\EdicaoRegistro {
    protected $id;
    protected $descr;
    protected $diretorio;
    protected $pagina_mestra = 'padrao';
    protected $padrao = false;
    protected $publicar = true;
    protected $delete = false;


    /**
     * @return mixed
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
     * @return mixed
     */
    public function getDiretorio() {
        return $this->diretorio;
    }


    /**
     * @param string $diretorio
     */
    public function setDiretorio($diretorio) {
        $this->diretorio = trim(filter_var($diretorio, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL), '/');
    }


    /**
     * @return string
     */
    public function getPaginaMestra() {
        return $this->pagina_mestra;
    }


    /**
     * @param string $pagina_mestra
     */
    public function setPaginaMestra($pagina_mestra) {
        $this->pagina_mestra = filter_var($pagina_mestra, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return boolean
     */
    public function isPadrao() {
        return (bool)$this->padrao;
    }


    /**
     * @param boolean $padrao
     */
    public function setPadrao($padrao) {
        $this->padrao = filter_var($padrao, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_temas', 'tema_');
        $this->selecionarPK($pk);
    } // Fim do método __construct


    /**
     * Salvar determinado registro
     *
     * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array   $ci  Vetor com os campos a serem considerados
     * @param array   $ce  Vetor com os campos a serem desconsiderados
     * @param bool    $ipk Define se o campo PK será considerado para inserção
     *
     * @return mixed
     * @throws \DL3Exception
     */
    protected function salvar($s = true, array $ci = null, array $ce = null, $ipk = false) {
        /*
         * Apenas um registro pode ter a flag 'padrao' marcada. Por tanto, caso o registro atual tenha essa flag a
         * mesma deve ser desmarcados do outro registro, se houver
         */
        if ($this->padrao) {
            \DL3::$conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}padrao = 0");
        } // Fim if

        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar


    public function selecionarPadrao() {
        return $this->selecionarUK('padrao', 1);
    } // Fim do método selecionarPadrao


    /**
     * Testar se o diretório existe e se não está vazio
     *
     * @return bool
     */
    public function verificarDiretorio() {
        $dir = \DL3::$dir_temas . "/{$this->diretorio}";

        return file_exists($dir) || file_exists("{$dir}/css") ||
            count(preg_grep('~^[^\.]{1,2}~', scandir("{$dir}/css"))) > 0;
    } // Fim do método verificarDiretorio
} // Fim do Modelo Tema