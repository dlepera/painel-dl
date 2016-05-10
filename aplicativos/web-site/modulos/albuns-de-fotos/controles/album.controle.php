<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:18:15
 */

namespace AlbunsDeFotos\Controle;

use \Geral\Controle as GeralC;
use \AlbunsDeFotos\Modelo as AlbunsM;

class Album extends GeralC\WebSite {
    public function __construct() {
        parent::__construct(new AlbunsM\Album(), 'albuns-de-fotos', TXT_MODELO_ALBUM);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    public function mostrarLista() {
        # Mostrar apenas álbuns que contenham fotos
        $this->listaPadrao(
            'album_id, album_nome, FC.foto_album_mini, COUNT(FT.foto_album_id) AS QTDE_FOTOS', 'album_id DESC',
            20, 'listarComFotos', false,
            'album_publicar = 1 GROUP BY album_id HAVING QTDE_FOTOS > 0'
        );

        # Visão
        $this->carregarHTML('lista_albuns');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_ALBUNS_FOTOS);
    } // Fim do método mostrarLista
} // Fim do Controle Controle