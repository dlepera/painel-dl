<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 09/01/2015 09:54:50
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class GrupoUsuario extends GeralM\EdicaoRegistro {
    protected $id;
    protected $descr;
    protected $funcs = [];
    protected $publicar = true;
    protected $delete = false;


    /**
     * @return mixed
     */
    public function getDescr() {
        return $this->descr;
    }


    /**
     * @param mixed $descr
     */
    public function setDescr($descr) {
        $this->descr = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return array
     */
    public function getFuncs() {
        return $this->funcs;
    }


    /**
     * @param array $funcs
     */
    public function setFuncs($funcs) {
        $this->funcs = filter_var($funcs, FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY | FILTER_FORCE_ARRAY);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_grupos_usuarios', 'grupo_usuario_');
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
        $r = parent::salvar($s, $ci, $ce, $ipk);

        # Salvar o permissionamento atual e remover o antigo
        if ($s && $this->id != $_SESSION['usuario_info_grupo']) {
            if (!$this->reg_vazio) {
                $sql = \DL3::$conex->prepare("DELETE FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = :id");
                $sql->execute([':id' => $this->id]);
            } // Fim if

            $sql = \DL3::$conex->prepare("INSERT INTO dl_painel_grupos_funcs VALUES (:id, :func)");

            foreach ($this->funcs as $f) {
                $sql->execute([':id' => $this->id, ':func' => $f]);
            } // Fim foreach
        } // Fim if

        return $r;
    } // Fim do método salvar


    /**
     * Selecionar um registro através da chave primária (PK - Primary Key)
     *
     * @param string $v Valor a ser pesquisado na PK
     * @param string $a Alias da tabela principal configurado na consulta
     *
     * @return bool
     * @throws \DL3Exception
     */
    public function selecionarPK($v, $a = null) {
        if (parent::selecionarPK($v, $a)) {
            $sql = \DL3::$conex->prepare("SELECT func_modulo_id FROM dl_painel_grupos_funcs WHERE {$this->bd_prefixo}id = :id");
            $sql->execute([':id' => $this->id]);

            if ($sql === false) {
                return true;
            } // Fim if

            $this->funcs = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);

            return true;
        } // Fim if

        return false;
    } // Fim do método selecionarPK


    /**
     * Verificar a permissão desse grupo para executar determinada ação
     *
     * @param string $c Nome da classe
     * @param string $m Nome do método / ação a ser executada
     *
     * @return bool true se a o grupo possui permissão para executar a ação ou false se não tem
     */
    public function verificarPerm($c, $m) {
        $q = "SELECT COUNT(DISTINCT MF.metodo_func_descr) AS PERM" .
            " FROM dl_painel_grupos_funcs AS GF" .
            " INNER JOIN dl_painel_modulos_funcs FM ON( FM.func_modulo_id = GF.func_modulo_id )" .
            " LEFT JOIN dl_painel_funcs_metodos MF ON( MF.metodo_func = FM.func_modulo_id )" .
            " WHERE GF.{$this->bd_prefixo}id = :id" .
            " AND FM.func_modulo_classe = :classe" .
            " AND MF.metodo_func_descr = :metodo";

        $sql = \DL3::$conex->prepare($q);
        $sql->execute([':id' => $this->id, ':classe' => $c, ':metodo' => $m]);

        return (bool)$sql->fetchColumn(0);
    } // Fim do método verificarPerm
} // Fim do Modelo GrupoUsuario