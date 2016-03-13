<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 11/01/2015 20:30:28
 */

namespace Contato\Modelo;

use \Geral\Modelo as GeralM;

class DadoContato extends GeralM\Registro {
    protected $id;
    protected $tipo;
    protected $descr;
    protected $publicar = true;
    protected $delete = false;


    /**
     * @return mixed
     */
    public function getTipo() {
        return $this->tipo;
    }


    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo) {
        $this->tipo = filter_var($tipo, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getDescr() {
        return $this->descr;
    }


    /**
     * @param mixed $descr
     */
    public function setDescr($descr) {
        $this->descr = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_dados_contato', 'dado_contato_');

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS DC'
            . " INNER JOIN {$this->bd_tabela}_tipos AS TD ON( TD.tipo_dado_id = DC.dado_contato_tipo )"
            . ' WHERE DC.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct
} // Fim do Modelo DadoContato