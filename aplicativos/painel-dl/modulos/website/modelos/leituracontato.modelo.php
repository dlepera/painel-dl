<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class LeituraContato extends GeralM\EdicaoRegistro {
    protected $leitura_contato;
    protected $id;
    protected $usuario;
    protected $data;


    /**
     * @return int
     */
    public function getLeituraContato() {
        return $this->leitura_contato;
    }


    /**
     * @param int $leitura_contato
     */
    public function setLeituraContato($leitura_contato) {
        $this->leitura_contato = filter_var($leitura_contato, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
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
        $this->usuario = filter_var($usuario, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getData() {
        return \Funcoes::formatarDataHora($this->data, $_SESSION['formato_data_completo']);
    }


    /**
     * @param mixed $data
     */
    public function setData($data) {
        $this->data = \Funcoes::formatarDataHora(filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL), \DL3::$bd_dh_formato_completo);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_contatos_leitura', 'leitura_contato_');

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS LC'
            . " INNER JOIN dl_site_contatos AS CS ON( CS.contato_site_id = LC.leitura_contato )"
            . " LEFT JOIN dl_painel_usuarios AS U ON ( U.usuario_id = LC.{$this->bd_prefixo}usuario )";

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
        if (!$this->reg_vazio || $this->verificarLeitura()) {
            return 0;
        } // Fim if

        # Obter a data atual
        $this->setData(date(\DL3::$bd_dh_formato_completo));

        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar


    /**
     *  Verificar se determinado usuário já leu o contato
     *
     * @param int $contato ID do contato
     * @param int $usuario ID do usuário
     *
     * @return bool Retorna true caso o usuário já tenha lido o contato ou false caso contrário
     */
    public function verificarLeitura($contato = null, $usuario = null) {
        if (isset($contato)) {
            $this->setLeituraContato($contato);
        } // Fim if

        if (isset($usuario)) {
            $this->setUsuario($usuario);
        } // Fim if

        return (bool)$this->qtdeRegistros("leitura_contato = {$this->leitura_contato} AND leitura_contato_usuario = {$this->usuario}");
    } // Fim do método verificarLeitura
} // Fim do Modelo LeituraContato