<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class ConfiguracaoSite extends GeralM\EdicaoRegistro {
    protected $id;
    protected $tema = 1;
    protected $formato_data = 1;
    protected $email;
    protected $album_tema = 'galeria-2';
    protected $album_fotow = 400;
    protected $album_fotoh = 400;
    protected $album_miniw = 200;
    protected $album_minih = 200;


    /**
     * @return int
     */
    public function getTema() {
        return $this->tema;
    }


    /**
     * @param int $tema
     */
    public function setTema($tema) {
        $this->tema = filter_var($tema, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return int
     */
    public function getFormatoData() {
        return $this->formato_data;
    }


    /**
     * @param int $formato_data
     */
    public function setFormatoData($formato_data) {
        $this->formato_data = filter_var($formato_data, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return int
     */
    public function getEmail() {
        return $this->email;
    }


    /**
     * @param int $email
     */
    public function setEmail($email) {
        $this->email = filter_var($email, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return string
     */
    public function getAlbumTema() {
        return $this->album_tema;
    }


    /**
     * @param string $album_tema
     */
    public function setAlbumTema($album_tema) {
        $this->album_tema = filter_var($album_tema, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return int
     */
    public function getAlbumFotow() {
        return $this->album_fotow;
    }


    /**
     * @param int $album_fotow
     */
    public function setAlbumFotow($album_fotow) {
        $this->album_fotow = filter_var($album_fotow, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => 100, 'max_range' => 800, 'default' => 400
        ]]);
    }


    /**
     * @return int
     */
    public function getAlbumFotoh() {
        return $this->album_fotoh;
    }


    /**
     * @param int $album_fotoh
     */
    public function setAlbumFotoh($album_fotoh) {
        $this->album_fotoh = filter_var($album_fotoh, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => 100, 'max_range' => 800, 'default' => 400
        ]]);
    }


    /**
     * @return int
     */
    public function getAlbumMiniw() {
        return $this->album_miniw;
    }


    /**
     * @param int $album_miniw
     */
    public function setAlbumMiniw($album_miniw) {
        $this->album_miniw = filter_var($album_miniw, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => 10, 'max_range' => 400, 'default' => 200
        ]]);
    }


    /**
     * @return int
     */
    public function getAlbumMinih() {
        return $this->album_minih;
    }


    /**
     * @param int $album_minih
     */
    public function setAlbumMinih($album_minih) {
        $this->album_minih = filter_var($album_minih, FILTER_VALIDATE_INT, ['options' => [
            'min_range' => 10, 'max_range' => 400, 'default' => 200
        ]]);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_configuracoes', 'configuracao_');

        $this->bd_select = 'SELECT %s FROM %s';

        $this->selecionarPK($pk);
    } // Fim do método __construct


    /*
     * Não permitir exclusão nem alteração de publicação
     * 
     * @return void
     */
    public function remover() {
        return;
    }


    public function alternarPublicacao() {
        return;
    }
} // Fim do Modelo ConfiguracaoSite