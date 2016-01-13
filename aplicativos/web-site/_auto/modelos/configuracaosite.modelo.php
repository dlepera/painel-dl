<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:27:37
 */

namespace Geral\Modelo;

class ConfiguracaoSite extends Registro{
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




    public function __construct(){
        parent::__construct('dl_site_configuracoes', 'configuracao_');

        $this->bd_select = 'SELECT %s' .
            ' FROM %s AS C' .
            ' INNER JOIN dl_painel_temas AS T ON( T.tema_id = C.configuracao_tema )' .
            ' INNER JOIN dl_painel_formatos_data AS F ON( F.formato_data_id = C.configuracao_formato_data )' .
            ' LEFT JOIN dl_painel_email_config AS E ON( E.config_email_id = C.configuracao_email )';

        $this->selecionarPK(1);
    } // Fim do método __construct
} // Fim do Modelo ConfiguracaoSite