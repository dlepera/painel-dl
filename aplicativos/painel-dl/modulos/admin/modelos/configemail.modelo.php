<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 09/01/2015 22:01:46
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class ConfigEmail extends GeralM\EdicaoRegistro {
    protected $id;
    protected $titulo;
    protected $host;
    protected $porta = 25;
    protected $autent = false;
    protected $cripto;
    protected $conta;
    protected $senha;
    protected $de_email;
    protected $de_nome;
    protected $responder_para;
    protected $html = false;
    protected $principal = false;
    protected $debug = false;
    protected $delete = false;


    /**
     * @return mixed
     */
    public function getTitulo() {
        return $this->titulo;
    }


    /**
     * @param mixed $titulo
     */
    public function setTitulo($titulo) {
        $this->titulo = filter_var($titulo, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getHost() {
        return $this->host;
    }


    /**
     * @param string $host
     */
    public function setHost($host) {
        $this->host = filter_var($host, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return int
     */
    public function getPorta() {
        return $this->porta;
    }


    /**
     * @param int $porta
     */
    public function setPorta($porta) {
        $this->porta = filter_var($porta, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => 0,
            'max_range' => 65535,
            'default'   => 25
        ]]);
    }


    /**
     * @return boolean
     */
    public function isAutent() {
        return (bool)$this->autent;
    }


    /**
     * @param boolean $autent
     */
    public function setAutent($autent) {
        $this->autent = filter_var($autent, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return mixed
     */
    public function getCripto() {
        return $this->cripto;
    }


    /**
     * @param mixed $cripto
     */
    public function setCripto($cripto) {
        $this->cripto = filter_var($cripto, FILTER_VALIDATE_REGEXP, ['options' => [
            'regexp'  => '~^(tls|ssl|)$~',
            'default' => ''
        ]]);
    }


    /**
     * @return string
     */
    public function getConta() {
        return $this->conta;
    }


    /**
     * @param string $conta
     */
    public function setConta($conta) {
        $this->conta = filter_var($conta, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getSenha() {
        return $this->senha;
    }


    /**
     * @param string $senha
     */
    public function setSenha($senha) {
        $this->senha = filter_var($senha, FILTER_SANITIZE_STRING);
    }


    /**
     * @return string
     */
    public function getDeEmail() {
        return $this->de_email;
    }


    /**
     * @param string $de_email
     */
    public function setDeEmail($de_email) {
        $this->de_email = filter_var($de_email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return string
     */
    public function getDeNome() {
        return $this->de_nome;
    }


    /**
     * @param string $de_nome
     */
    public function setDeNome($de_nome) {
        $this->de_nome = filter_var($de_nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getResponderPara() {
        return $this->responder_para;
    }


    /**
     * @param string $responder_para
     */
    public function setResponderPara($responder_para) {
        $this->responder_para = filter_var($responder_para, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return boolean
     */
    public function isHtml() {
        return (bool)$this->html;
    }


    /**
     * @param boolean $html
     */
    public function setHtml($html) {
        $this->html = filter_var($html, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return boolean
     */
    public function isPrincipal() {
        return (bool)$this->principal;
    }


    /**
     * @param boolean $principal
     */
    public function setPrincipal($principal) {
        $this->principal = filter_var($principal, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return boolean
     */
    public function isDebug() {
        return (bool)$this->debug;
    }


    /**
     * @param boolean $debug
     */
    public function setDebug($debug) {
        $this->debug = filter_var($debug, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_email_config', 'config_email_');
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
        /*
         * Apenas um registro pode ter a flag 'principal' marcada. Portanto, caso o registro atual tenha a flag, a mesma
         * deve ser desmarcada em qualquer outro registro
         */

        if ($this->principal && $s) {
            \DL3::$conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}principal = 0");
        } // Fim if

        /*
         * Quando a flag de autenticação está ativada, os campos 'Conta' e 'Senha' são obrigatórios
         */
        if ($this->autent && (empty($this->conta) || empty($this->senha))) {
            throw new \DL3Exception(ERRO_CONFIGEMAIL_SALVAR_INFORMAR_DADOS_CONTA, 1403, 'atencao');
        } // Fim if

        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar


    /**
     * Selecionar o registro marcado como principal
     *
     * @return bool
     * @throws \DL3Exception
     */
    public function selecionarPrincipal() {
        return $this->selecionarUK('principal', 1);
    } // Fim do método selecionarPrincipal
} // Fim do Modelo ConfigEmail
