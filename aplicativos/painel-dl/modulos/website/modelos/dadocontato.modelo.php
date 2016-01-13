<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 11/01/2015 20:30:28
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class DadoContato extends GeralM\EdicaoRegistro{
    protected $id;
	protected $tipo;
	protected $descr;
	protected $publicar = true;
	protected $delete = false;




    /**
     * @return mixed
     */
    public function getTipo(){
        return $this->tipo;
    }




    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo){
        $this->tipo = filter_var($tipo, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return mixed
     */
    public function getDescr(){
        return $this->descr;
    }




    /**
     * @param mixed $descr
     */
    public function setDescr($descr){
        $this->descr = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    public function __construct($pk = null){
        parent::__construct('dl_site_dados_contato', 'dado_contato_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS DC'
                . " INNER JOIN {$this->bd_tabela}_tipos AS TD ON( TD.tipo_dado_id = DC.dado_contato_tipo )"
                . ' WHERE DC.%sdelete = 0';

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
         * Antes de inserir ou atualizar o registro, verificar se não há outro registro igual
         */
        if ($this->qtdeRegistros("{$this->bd_prefixo}tipo = {$this->tipo} AND {$this->bd_prefixo}descr = '{$this->descr}' AND {$this->bd_prefixo}id <> " . (int)$this->id) > 0) {
            throw new \DL3Exception(ERRO_DADOCONTATO_SALVAR_REGISTRO_JA_EXISTE, 1403, 'atencao');
        } // Fim if

        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar
} // Fim do Modelo DadoContato