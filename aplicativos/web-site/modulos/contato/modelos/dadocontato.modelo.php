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


    /**
     * Mostrar os contatos em uma lista HTML
     *
     * @param bool  $rede_social        Define se serão mostradas redes sociais (true) ou não (false)
     * @param array $classes_adicionais Classes adicionais a serem aplicadas no componente HTML
     *
     * @return string
     */
    public function contatosHTML($rede_social = false, array $classes_adicionais = []) {
        $rede_social = \Funcoes::varExportBD((bool)$rede_social);
        $classes = ['dados-contato'];

        if ($rede_social) {
            $classes[] = '-redes-sociais';
        } // Fim if

        $classes = implode(' ', array_merge($classes, $classes_adicionais));

        $contatos = $this->listar(
            "dado_contato_publicar = 1 AND tipo_dado_rede_social = {$rede_social}", 'tipo_dado_exibicao',
            'CONCAT(' .
            "'<li class=\"item\">" .
            "  <span class=\"link -', LOWER(REPLACE(tipo_dado_exibicao, ' ', '')), '\">" .
            "    <span class=\"exibicao\">', tipo_dado_exibicao, '</span>" .
            "    <span class=\"descr\">', dado_contato_descr, '</span>" .
            " </span>" .
            "</li>'" .
            ") AS HTML"
        );

        $html = "<ul class=\"{$classes}\">";
        $html .= implode('', array_column($contatos, 'HTML'));
        $html .= '</ul>';

        return $html;
    } // Fim do método contatosHTML
} // Fim do Modelo DadoContato