<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class Institucional extends GeralM\EdicaoRegistro{
    protected $id;
	protected $historia;
	protected $missao;
	protected $visao;
	protected $valores;
	protected $publicar = true;




    /**
     * @return mixed
     */
    public function getHistoria(){
        return $this->historia;
    }




    /**
     * @param mixed $historia
     */
    public function setHistoria($historia){
        $this->historia = filter_var($historia);
    }




    /**
     * @return mixed
     */
    public function getMissao(){
        return $this->missao;
    }




    /**
     * @param mixed $missao
     */
    public function setMissao($missao){
        $this->missao = filter_var($missao);
    }




    /**
     * @return mixed
     */
    public function getVisao(){
        return $this->visao;
    }




    /**
     * @param mixed $visao
     */
    public function setVisao($visao){
        $this->visao = filter_var($visao);
    }




    /**
     * @return mixed
     */
    public function getValores(){
        return $this->valores;
    }




    /**
     * @param mixed $valores
     */
    public function setValores($valores){
        $this->valores = filter_var($valores);
    }




    public function __construct($pk = null){
        parent::__construct('dl_site_institucional', 'instit_');

        $this->bd_select = 'SELECT %s FROM %s';

        $this->selecionarPK($pk);
    } // Fim do método __construct




    /**
     * Desativar o método remover
     */
    public function remover(){ return; }
} // Fim do Modelo Institucional