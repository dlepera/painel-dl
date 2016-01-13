<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class Album extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\Album(), 'website', TXT_MODELO_ALBUM);
        $this->carregarPost([
            'id' => FILTER_VALIDATE_INT,
            'nome' => FILTER_SANITIZE_STRING,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function mostrarLista(){
        $this->listaPadrao('album_id AS ' . TXT_LISTA_TITULO_ID . ','
	        . " CONCAT('<img src=\"" . \DL3::$dir_relativo . "', foto_album_imagem, '\" class=\"tbl-imagem capa-album\" alt=\"\"/>') AS " . TXT_LISTA_TITULO_CAPA . ','
            . ' album_nome AS ' . TXT_LISTA_TITULO_NOME . ','
            . " ( CASE album_publicar WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_PUBLICADO . "'",
            'album_nome', null);

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('lista_albuns');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_ALBUNS_FOTOS);

	    # Contar a quantiade de fotos de cada álbum
	    $la = $this->visao->obterParams('lista');
	    $qt = [];

        foreach ($la as $a) {
            $qt[$a[TXT_LISTA_TITULO_ID]] = $this->modelo->qtdeFotos($a[TXT_LISTA_TITULO_ID]);
        } // Fim foreach

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/albuns-de-fotos/');
        $this->visao->adParam('form-acao', 'website/albuns-de-fotos/excluir-albuns');
        $this->visao->adParam('campos', [
            ['valor' => 'album_nome', 'texto' => TXT_ROTULO_NOME]
        ]);
	    $this->visao->adParam('qtdes-fotos', $qt);
    } // Fim do método mostrarLista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int $pk Valor da PK do registro a ser selecionado
	 */
    public function mostrarForm($pk = null){
        $inc = $this->formPadrao('album', 'albuns-de-fotos/salvar', 'albuns-de-fotos/salvar', 'website/albuns-de-fotos', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_album');

	    # Fotos
	    $mf = new WebM\FotoAlbum();

	    # Parâmetros
	    $this->visao->adParam('extensoes', implode(', ', $mf->conf_extensoes_imagem));

	    if( $inc ){
		    return;
	    } // Fim if( $inc )

        # Lista de fotos
        $mf = new WebM\FotoAlbum();
        $lf = $mf->listar("foto_album = {$this->modelo->id} AND foto_album_publicar = 1", 'foto_album_capa DESC, foto_album_id DESC', 'foto_album_id, foto_album_titulo, foto_album_descr, foto_album_capa, foto_album_imagem');

        # Mais parâmetros
        $this->visao->adParam('fotos', $lf);
	    $this->visao->adParam('qtde-fotos', $this->modelo->qtdeFotos());
    } // Fim do método mostrarForm
} // Fim do Controle Controle