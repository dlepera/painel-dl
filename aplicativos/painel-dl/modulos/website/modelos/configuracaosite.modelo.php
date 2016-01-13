<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class ConfiguracaoSite extends GeralM\EdicaoRegistro{
    protected $id;
    protected $tema = 1;
    protected $formato_data = 1;
    protected $email;




    /**
     * @return int
     */
    public function getTema(){
        return $this->tema;
    }




    /**
     * @param int $tema
     */
    public function setTema($tema){
        $this->tema = filter_var($tema, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return int
     */
    public function getFormatoData(){
        return $this->formato_data;
    }




    /**
     * @param int $formato_data
     */
    public function setFormatoData($formato_data){
        $this->formato_data = filter_var($formato_data, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return int
     */
    public function getEmail(){
        return $this->email;
    }




    /**
     * @param int $email
     */
    public function setEmail($email){
        $this->email = filter_var($email, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }






    public function __construct($pk = null){
        parent::__construct('dl_site_configuracoes', 'configuracao_');

        $this->bd_select = 'SELECT %s FROM %s';

        $this->selecionarPK($pk);
    } // Fim do método __construct



    /*
     * Não permitir exclusão nem alteração de publicação
     * 
     * @return void
     */
    public function remover(){ return; }
    public function alternarPublicacao(){ return; }
} // Fim do Modelo ConfiguracaoSite