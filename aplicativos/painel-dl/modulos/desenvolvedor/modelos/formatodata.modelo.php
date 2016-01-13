<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 11:33:42
 */

namespace Desenvolvedor\Modelo;

use \Geral\Modelo as GeralM;

class FormatoData extends GeralM\EdicaoRegistro{
    protected $id;
    protected $descr;
    protected $completo;
    protected $data;
    protected $hora;
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
    public function getCompleto(){
        return $this->completo;
    }




    /**
     * @param mixed $completo
     */
    public function setCompleto($completo){
        $this->completo = filter_var($completo, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return mixed
     */
    public function getData(){
        return $this->data;
    }




    /**
     * @param mixed $data
     */
    public function setData($data){
        $this->data = filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return mixed
     */
    public function getHora(){
        return $this->hora;
    }




    /**
     * @param mixed $hora
     */
    public function setHora($hora){
        $this->hora = filter_var($hora, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    public function __construct($pk = null){
        parent::__construct('dl_painel_formatos_data', 'formato_data_');
        $this->selecionarPK($pk);
    } // fim do método __construct
} // Fim do Modelo FormatoData