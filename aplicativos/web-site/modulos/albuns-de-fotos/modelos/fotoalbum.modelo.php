<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace AlbunsDeFotos\Modelo;

use \Geral\Modelo as GeralM;
use \WebSite\Modelo as WebM;

class FotoAlbum extends GeralM\Registro {
    protected $foto_album;
    protected $id;
    protected $titulo;
    protected $descr;
    protected $imagem;
    protected $capa = false;
    protected $publicar = true;
    protected $delete = false;

    # Configurações
    public $conf_extensoes_imagem = ['png', 'jpg', 'jpeg', 'gif'];


    /**
     * @return int
     */
    public function getFotoAlbum() {
        return $this->foto_album;
    }


    /**
     * @param int $foto_album
     */
    public function setFotoAlbum($foto_album) {
        $this->foto_album = filter_var($foto_album, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


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
        $this->titulo = \Funcoes::ucWords(
            filter_var($titulo, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL),
            EXPREG_PREPOSICOES
        );
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


    /**
     * @return mixed
     */
    public function getImagem() {
        return $this->imagem;
    }


    /**
     * @param mixed $imagem
     */
    public function setImagem($imagem) {
        $this->imagem = filter_var($imagem, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return boolean
     */
    public function isCapa() {
        return (bool)$this->capa;
    }


    /**
     * @param boolean $capa
     */
    public function setCapa($capa) {
        $this->capa = filter_var($capa, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_albuns_fotos', 'foto_album_');

        $this->bd_select = 'SELECT %s' .
            ' FROM %s AS F' .
            ' INNER JOIN dl_site_albuns AS A ON( A.album_id = F.foto_album )' .
            ' WHERE F.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct
} // Fim do Modelo FotoAlbum