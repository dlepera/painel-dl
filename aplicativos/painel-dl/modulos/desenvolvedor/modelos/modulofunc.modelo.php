<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class ModuloFunc extends GeralM\EdicaoRegistro{
    protected $id;
	protected $func_modulo;
	protected $descr;
	protected $classe;
	protected $metodos = [];
	protected $grupos = [];
	protected $delete = false;




    /**
     * @return int
     */
    public function getFuncModulo(){
        return $this->func_modulo;
    }




    /**
     * @param int $func_modulo
     */
    public function setFuncModulo($func_modulo){
        $this->func_modulo = filter_var($func_modulo, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return string
     */
    public function getDescr(){
        return $this->descr;
    }




    /**
     * @param string $descr
     */
    public function setDescr($descr){
        $this->descr = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return string
     */
    public function getClasse(){
        return $this->classe;
    }




    /**
     * @param string $classe
     */
    public function setClasse($classe){
        $this->classe = filter_var($classe, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return array
     */
    public function getMetodos(){
        return $this->metodos;
    }




    /**
     * @param array $metodos
     */
    public function setMetodos($metodos){
        $this->metodos = array_filter(
            filter_var(
                $metodos,
                FILTER_SANITIZE_STRING,
                FILTER_REQUIRE_ARRAY | FILTER_FLAG_EMPTY_STRING_NULL
            ),
            function ($m){ return isset($m); }
        );
    }




    /**
     * @return array
     */
    public function getGrupos(){
        return $this->grupos;
    }




    /**
     * @param array $grupos
     */
    public function setGrupos($grupos){
        $this->grupos = filter_var(
            $grupos,
            FILTER_VALIDATE_INT,
            FILTER_REQUIRE_ARRAY
        );
    }




    public function __construct($pk = null){
        parent::__construct('dl_painel_modulos_funcs', 'func_modulo_');
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
    protected function salvar($s = true, array $ci = null, array $ce = null, $ipk = false){
        /*
         * Não permitir que o módulo seja alterado
         */
        $ce = $this->reg_vazio ? $ce : array_merge($ce, ['func_modulo']);

        $r = parent::salvar($s, $ci, $ce, $ipk);

        if ($s) {
            if (!$this->reg_vazio) {
	            # Remover os métodos atuais dessa função
	            $sql = \DL3::$conex->prepare("DELETE FROM dl_painel_funcs_metodos WHERE metodo_func = :id");
	            $sql->execute([':id' => $this->id]);

	            # Remover os grupos atuais dessa função
	            $sql = \DL3::$conex->prepare("DELETE FROM dl_painel_grupos_funcs WHERE func_modulo_id = :id");
	            $sql->execute([':id' => $this->id]);
            } // Fim if

	        # Incluir os métodos
	        $sql = \DL3::$conex->prepare("INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUES (:id, :metodo)");

	        foreach( $this->metodos as $m ){
		        $sql->execute([':id' => $this->id, ':metodo' => $m]);
	        } // Fim foreach

	        # Incluir os grupos
	        $sql = \DL3::$conex->prepare("INSERT INTO dl_painel_grupos_funcs (grupo_usuario_id, func_modulo_id) VALUES (:grp, :fnc)");

	        foreach( $this->grupos as $g ){
		        $sql->execute([':grp' => $g, ':fnc' => $this->id]);
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
	public function selecionarPK($v, $a = null){
        if( parent::selecionarPK($v, $a) ){
	        # Selecionar os métodos dessa classe
	        $sql = \DL3::$conex->prepare("SELECT metodo_func_descr FROM dl_painel_funcs_metodos WHERE metodo_func = :id");
	        $sql->execute([':id' => $this->id]);

            if ($sql !== false) {
                $this->metodos = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);
            } // Fim if

	        # Selecionar os grupos dessa classe
	        $sql = \DL3::$conex->prepare("SELECT grupo_usuario_id FROM dl_painel_grupos_funcs WHERE func_modulo_id = :id");
	        $sql->execute([':id' => $this->id]);

	        if( $sql !== false ){
		        $this->grupos = $sql->fetchAll(\PDO::FETCH_COLUMN, 0);
	        } // Fim if

	        return true;
        } // Fim if

		return false;
    } // Fim do método selecionarPK
} // Fim do Modelo ModuloFunc