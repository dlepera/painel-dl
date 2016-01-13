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

class FotoAlbum extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\FotoAlbum(), 'website', TXT_MODELO_FOTO);
        $this->carregarPost([
            'id' => FILTER_VALIDATE_INT,
            'foto_album' => FILTER_VALIDATE_INT,
            'titulo' => FILTER_SANITIZE_STRING,
            'descr' => FILTER_SANITIZE_STRING,
            'capa' => FILTER_VALIDATE_BOOLEAN,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int  $pk  Valor da PK do registro a ser selecionado
	 * @param bool $mst Nome da página mestra a ser carregada
	 */
    protected function mostrarForm($pk = null, $mst = null){
        $this->formPadrao('foto', 'albuns-de-fotos/salvar-foto', 'albuns-de-fotos/salvar-foto', 'website/albuns-de-fotos', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_foto', $mst);
        $this->visao->setTitulo(TXT_PAGINA_TITULO_EDITAR_FOTO);
    } // Fim do método mostrarForm




	/**
	 * Realizar o upload das fotos
	 */
    protected function upload(){
        $this->modelo->upload();
        \Funcoes::mostrarMsg(SUCESSO_FOTOALBUM_UPLOAD, '__msg-sucesso');
    } // Fim do método upload
} // Fim do Controle Controle