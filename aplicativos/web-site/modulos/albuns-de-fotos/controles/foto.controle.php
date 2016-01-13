<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace AlbunsDeFotos\Controle;

use \Geral\Controle as GeralM;
use \AlbunsDeFotos\Modelo as AlbumM;

class Foto extends GeralM\WebSite{
    public function __construct(){
        parent::__construct(new AlbumM\FotoAlbum(), 'albuns-de-fotos', TXT_MODELO_FOTO);
    } // Fim do método __construct




	/**
	 *  Mostrar a lista de fotos de um determinado álbum
	 *
	 * @param int $a - ID do álbum a ser exibido
	 */
    public function mostrarFotos($a){
        # Lista de fotos
        $lista = $this->modelo->listar(
            "foto_album_publicar = 1 AND foto_album = {$a}",
            'foto_album_capa DESC, foto_album_titulo',
            'foto_album_titulo, foto_album_descr, foto_album_capa, foto_album_imagem, album_nome'
        );

        # Visão
        $this->carregarHTML('lista_fotos');
        $this->visao->setTitulo($lista[0]['album_nome']);

        # Parâmetros
        $this->visao->adParam('fotos', $lista);
    } // Fim do método mostrarLista
} // Fim do Controle Foto