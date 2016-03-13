<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class Album extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(new WebM\Album(), 'website', TXT_MODELO_ALBUM);
        $this->carregarPost([
            'id'       => FILTER_VALIDATE_INT,
            'nome'     => FILTER_SANITIZE_STRING,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct


    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista() {
        $this->listaPadrao(
            sprintf(static::SQL_CAMPO_COM_ALIAS, 'album_id', TXT_LISTA_TITULO_ID) . ',' .
            sprintf(static::SQL_IMAGEM_HTML, \DL3::$dir_relativo, 'FT.foto_album_mini', TXT_LISTA_TITULO_CAPA) . ',' .
            sprintf(static::SQL_CAMPO_COM_ALIAS, "CONCAT(album_nome, '<br/>', COUNT(FT.foto_album_id), '" . TXT_DIVERSOS_QTDE_FOTOS . "')", TXT_LISTA_TITULO_NOME) . ',' .
            sprintf(static::SQL_CASE_SIM_NAO, 'album_publicar', TXT_LISTA_TITULO_PUBLICADO),
            'album_nome', null, 'listarComFotos', true, '1=1 GROUP BY album_id'
        );

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_ALBUNS_FOTOS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'website/albuns-de-fotos/');
        $this->visao->adParam('form-acao', 'website/albuns-de-fotos/excluir-albuns');
        $this->visao->adParam('campos', [
            ['valor' => 'album_nome', 'texto' => TXT_ROTULO_NOME]
        ]);

        /*
         * Verificar se o usuário logado tem permissão para editar as configurações do álbum de fotos e incluir o
         * resultado no parâmetro de opções
         */
        $classe = 'WebSite\Controle\AlbumConfig';
        $this->visao->adParam('opcoes',
            array_merge(
                $this->visao->obterParams('opcoes'),
                ['editar-configuracoes?' => \DL3::$autent->verificarPerm($classe, 'mostrarForm') && \DL3::$autent->verificarPerm($classe, 'salvar')]
            )
        );
    } // Fim do método mostrarLista


    /**
     * Mostrar o formulário de inclusão e edição do registro
     *
     * @param int $pk Valor da PK do registro a ser selecionado
     */
    public function mostrarForm($pk = null) {
        $inc = $this->formPadrao('album', 'albuns-de-fotos/salvar', 'albuns-de-fotos/salvar', 'website/albuns-de-fotos', $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_album');

        # Fotos
        $mf = new WebM\FotoAlbum();

        # Parâmetros
        $this->visao->adParam('extensoes', implode(', ', $mf->conf_extensoes_imagem));

        if (!$inc) {
            # Visões
            $this->carregarHTML('form_upload_fotos');
            $this->carregarHTML('lista_fotos');

            # Lista de fotos
            $mf = new WebM\FotoAlbum();
            $lf = $mf->listar(
                "foto_album = {$this->modelo->id} AND foto_album_publicar = 1",
                'foto_album_capa DESC, foto_album_id DESC',
                'foto_album_id, foto_album_capa, foto_album_mini, foto_album_publicar, foto_album_titulo, foto_album_descr,' .
                sprintf(static::SQL_CAMPO_COM_ALIAS, "COALESCE(foto_album_titulo, '" . TXT_DIVERSOS_FOTO_SEM_TITULO . "')", 'TITULO') . ',' .
                sprintf(static::SQL_CAMPO_COM_ALIAS, "COALESCE(foto_album_descr, '" . TXT_DIVERSOS_FOTO_SEM_DESCR . "')", 'DESCR')
            );

            # Mais parâmetros
            $this->visao->adParam('fotos', $lf);
            $this->visao->adParam('qtde-fotos', count($lf));
        } // Fim if
    } // Fim do método mostrarForm
} // Fim do Controle Controle