<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 05/01/2015 12:46:40
 */

namespace Home\Controle;

use \Geral\Controle as GeralC;

class WebSite extends GeralC\WebSite {
    public function __construct($m = null) {
        parent::__construct($m, 'home', '');
    } // Fim do método __construct


    public function index() {
        $this->carregarHTML('home');
        $this->visao->setTitulo(\DL3::$titulo);
    } // Fim do método index
} // Fim da classe WebSite