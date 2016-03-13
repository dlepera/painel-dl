<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 01/07/2014 13:38:07
 */

namespace Login\Modelo;

use \Geral\Modelo as GeralM;

class Recuperacao extends GeralM\EdicaoRegistro {
    # Propriedades desse modelo
    protected $id;
    protected $usuario;
    protected $hash;
    protected $status = 'E';


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
        $this->usuario = filter_var($usuario, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getHash() {
        return $this->hash;
    }


    /**
     * @param mixed $hash
     */
    public function setHash($hash) {
        $this->hash = filter_var(md5(crypt($hash)));
    }


    /**
     * @return string
     */
    public function getStatus() {
        return $this->status;
    }


    /**
     * @param string $status Letra que representa o status atual da hash:
     *                       S => Reset de senha "s"olicitado
     *                       E => Solicitação "E"xpirada
     *                       R => Senha "R"ecuperada
     */
    public function setStatus($status) {
        $this->status = filter_var($status, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => '~^[SER]{1}$~'], 'flags' => FILTER_NULL_ON_FAILURE]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_usuarios_recuperacoes', 'recuperacao_');

        # Query de seleção
        $this->bd_select = 'SELECT %s' .
            ' FROM %s AS R' .
            ' INNER JOIN dl_painel_usuarios AS U ON( U.usuario_id = R.recuperacao_usuario )';

        $this->selecionarPK($pk);
    } // Fim do método mágico __construct
} // Fim do modelo Recuperacao
