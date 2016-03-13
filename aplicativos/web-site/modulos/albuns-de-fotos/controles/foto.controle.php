<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:18:15
 */

namespace AlbunsDeFotos\Controle;

use \Geral\Controle as GeralC;
use \Geral\Modelo as GeralM;
use \AlbunsDeFotos\Modelo as AlbumM;

class Foto extends GeralC\WebSite {
    public function __construct() {
        parent::__construct(new AlbumM\FotoAlbum(), 'albuns-de-fotos', TXT_MODELO_FOTO);
    } // Fim do método __construct


    /**
     *  Mostrar a lista de fotos de um determinado álbum
     *
     * @param int         $album     ID do álbum a ser exibido
     * @param string|null $pg_mestra Nome da página mestra a ser carregada
     */
    public function mostrarFotos($album, $pg_mestra = null) {
        $album = filter_var($album, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
            'flags'   => FILTER_NULL_ON_FAILURE
        ]);

        # Lista de fotos
        $lista = $this->modelo->listar(
            "foto_album_publicar = 1 AND foto_album = {$album}",
            'foto_album_capa DESC, foto_album_titulo',
            sprintf(static::SQL_CAMPO_COM_ALIAS, "CONCAT('" . \DL3::$dir_relativo . "', foto_album_imagem)", 'src') . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'foto_album_titulo', 'titulo') . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'foto_album_descr', 'descr') . ',' .
            'album_nome'
        );

        # Visão
        $this->carregarHTML('lista_fotos', $pg_mestra);
        $this->visao->setTitulo($lista[0]['album_nome']);

        # Configurações do álbum
        $mca = new GeralM\ConfiguracaoSite();
        $lca = $mca->listar(null, null, 'configuracao_album_tema', 0, 1, 0);

        # Parâmetros
        $this->visao->adParam('fotos', $lista);
        $this->visao->adParam('config-album', $lca);
    } // Fim do método mostrarLista
} // Fim do Controle Foto