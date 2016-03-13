<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebSiteM;

class AlbumConfig extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new WebSiteM\ConfiguracaoSite(), 'website', TXT_MODELO_CONFIGURACAOSITE);
        $this->carregarPost([
            'id'          => FILTER_VALIDATE_INT,
            'album_tema'  => FILTER_SANITIZE_STRING,
            'album_fotow' => FILTER_SANITIZE_NUMBER_INT,
            'album_fotoh' => FILTER_SANITIZE_NUMBER_INT,
            'album_miniw' => FILTER_SANITIZE_NUMBER_INT,
            'album_minih' => FILTER_SANITIZE_NUMBER_INT
        ]);
    } // Fim do método __construct


    /**
     * Mostrar o formulário de inclusão e edição do registro
     *
     * @param string $pg_mestra Nome da página mestra a ser carregada
     */
    protected function mostrarForm($pg_mestra = null) {
        $this->formPadrao('config-album', null, 'albuns-de-fotos/editar-configuracoes/salvar', 'website/albuns-de-fotos', 1);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_album_config', $pg_mestra);
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONFIGURACOES_ALBUNS_DE_FOTOS);
    } // Fim do método mostrarForm
} // Fim do Controle AlbumConfig
