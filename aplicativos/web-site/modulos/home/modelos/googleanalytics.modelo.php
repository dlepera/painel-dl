<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 11/01/2015 17:03:07
 */

namespace Home\Modelo;

use \Geral\Modelo as GeralM;

class GoogleAnalytics extends GeralM\Registro {
    const DOMINIO_GSERVICE = '@developer.gserviceaccount.com';
    const DIR_P12 = 'web/uploads/google-api/';

    protected $id;
    protected $apelido;
    protected $usuario;
    protected $p12;
    protected $perfil_id;
    protected $codigo_ua;
    protected $principal = false;
    protected $publicar = true;
    protected $delete = false;


    /**
     * @return mixed
     */
    public function getApelido() {
        return $this->apelido;
    }


    /**
     * @param mixed $apelido
     */
    public function setApelido($apelido) {
        $this->apelido = filter_var($apelido, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getUsuario() {
        return $this->usuario;
    }


    /**
     * @param mixed $usuario
     */
    public function setUsuario($usuario) {
        $this->usuario = filter_var($usuario, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getP12() {
        return $this->p12;
    }


    /**
     * @param mixed $p12
     */
    public function setP12($p12) {
        $this->p12 = filter_var($p12);
    }


    /**
     * @return mixed
     */
    public function getPerfilId() {
        return $this->perfil_id;
    }


    /**
     * @param int $perfil_id
     */
    public function setPerfilId($perfil_id) {
        $this->perfil_id = filter_var($perfil_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return string
     */
    public function getCodigoUa() {
        return $this->codigo_ua;
    }


    /**
     * @param mixed $codigo_ua
     */
    public function setCodigoUa($codigo_ua) {
        $this->codigo_ua = strtoupper(filter_var($codigo_ua, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL));
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


    public function __construct($pk = null) {
        parent::__construct('dl_site_google_analytics', 'ga_');
        $this->selecionarPK($pk);
    } // Fim do método __construct


    /**
     * Selecionar a configuração principal
     */
    public function selecionarPrincipal() {
        return $this->selecionarUK('principal', 1);
    } // Fim do método selecionarPrincipal


    public function contaCompleta() {
        return $this->usuario . static::DOMINIO_GSERVICE;
    } // Fim do método contaCompleta
} // Fim do Modelo GoogleAnalytics