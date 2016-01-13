<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 08/01/2015 18:14:07
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class Idioma extends GeralM\EdicaoRegistro{
    protected $id;
	protected $descr;
	protected $sigla;
	protected $publicar = true;
	protected $delete = false;




    /**
     * @return string|null
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
     * @return string|null
     */
    public function getSigla(){
        return $this->sigla;
    }




    /**
     * @param string $sigla
     */
    public function setSigla($sigla){
        $this->sigla = filter_var($sigla, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => EXPREG_SIGLA_IDIOMA], 'flags' => FILTER_NULL_ON_FAILURE]);
    }




    public function __construct($pk = null){
        parent::__construct('dl_painel_idiomas', 'idioma_');
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
         * Não será permitido incluir mais de 1 idioma com a mesma sigla
         */
        if ($this->qtdeRegistros("{$this->bd_prefixo}sigla = '{$this->sigla}' AND {$this->bd_prefixo}id <> " . (int)$this->id)) {
            throw new \DL3Exception(ERRO_IDIOMA_SALVAR_REGISTRO_JA_EXISTE, 1403, 'atencao');
        } // Fim if

        return parent::salvar($s, $ci, $ce, $ipk);
    }
} // Fim do Modelo Idioma