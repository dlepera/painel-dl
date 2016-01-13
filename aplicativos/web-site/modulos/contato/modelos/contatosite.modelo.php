<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 18:02:20
 */

namespace Contato\Modelo;

use \Geral\Modelo as GeralM;

class ContatoSite extends GeralM\EdicaoRegistro{
    protected $id;
	protected $nome;
	protected $email;
	protected $telefone;
	protected $assunto;
	protected $mensagem;
	protected $delete = false;




    /**
     * @return mixed
     */
    public function getNome(){
        return $this->nome;
    }




    /**
     * @param mixed $nome
     */
    public function setNome($nome){
        $this->nome = filter_var($nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
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
     * @return mixed
     */
    public function getTelefone(){
        return $this->telefone;
    }




    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone){
        $this->telefone = filter_var($telefone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => EXPREG_TELEFONE_GERAL], 'flags' => FILTER_NULL_ON_FAILURE]);
    }




    /**
     * @return mixed
     */
    public function getAssunto(){
        return $this->assunto;
    }




    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto){
        $this->assunto = filter_var($assunto, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }




    /**
     * @return mixed
     */
    public function getMensagem(){
        return $this->mensagem;
    }




    /**
     * @param mixed $mensagem
     */
    public function setMensagem($mensagem){
        $this->mensagem = filter_var($mensagem);
    }





    public function __construct($pk = null){
        parent::__construct('dl_site_contatos', 'contato_site_');

        $this->bd_select = 'SELECT %s'
                . ' FROM %s AS CS'
                . ' LEFT JOIN dl_site_assuntos_contato AS AC ON( AC.assunto_contato_id = CS.contato_site_assunto )'
                . " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_regpk = CS.contato_site_id AND LR.log_registro_tabela = '{$this->bd_tabela}' AND LR.log_registro_acao = 'A' )"
                . ' WHERE CS.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct
} // Fim do Modelo ContatoSite