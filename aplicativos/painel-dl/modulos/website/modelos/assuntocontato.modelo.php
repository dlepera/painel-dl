<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 19:24:27
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class AssuntoContato extends GeralM\EdicaoRegistro{
    protected $id;
	protected $descr;
	protected $email;
	protected $cor = '#000';
	protected $publicar = true;
	protected $delete = false;




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




    /**
     * @return mixed
     */
    public function getEmail(){
        return $this->email;
    }




    /**
     * @param mixed $email
     */
    public function setEmail($email){
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return string
     */
    public function getCor(){
        return $this->cor;
    }




    /**
     * @param string $cor
     */
    public function setCor($cor){
        $this->cor = filter_var($cor, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => EXPREG_COR_HEXA, 'default' => '#000']]);
    }




    public function __construct($pk = null){
        parent::__construct('dl_site_assuntos_contato', 'assunto_contato_');
        $this->selecionarPK($pk);
    } // Fim do método __construct
} // Fim do Modelo AssuntoContato