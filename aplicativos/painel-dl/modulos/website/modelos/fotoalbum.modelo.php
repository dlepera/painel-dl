<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;
use \WebSite\Modelo as WebM;

class FotoAlbum extends GeralM\EdicaoRegistro {
    protected $foto_album;
    protected $id;
    protected $titulo;
    protected $descr;
    protected $imagem;
    protected $foto;
    protected $mini;
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
     * @return string
     */
    public function getTitulo() {
        return $this->titulo;
    }


    /**
     * @param string $titulo
     */
    public function setTitulo($titulo) {
        $this->titulo = \Funcoes::ucWords(
            filter_var($titulo, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL),
            EXPREG_PREPOSICOES
        );
    }


    /**
     * @return string
     */
    public function getDescr() {
        return $this->descr;
    }


    /**
     * @param string $descr
     */
    public function setDescr($descr) {
        $this->descr = filter_var($descr, FILTER_DEFAULT, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getImagem() {
        return $this->imagem;
    }


    /**
     * @param string $imagem
     */
    public function setImagem($imagem) {
        $this->imagem = filter_var($imagem, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getFoto() {
        return $this->foto;
    }


    /**
     * @param string $foto
     */
    public function setFoto($foto) {
        $this->foto = filter_var($foto, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getMini() {
        return $this->mini;
    }


    /**
     * @param string $mini
     */
    public function setMini($mini) {
        $this->mini = filter_var($mini, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
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

        $this->bd_select = 'SELECT %s FROM %s AS F' .
            ' INNER JOIN dl_site_albuns AS A ON( A.album_id = F.foto_album )' .
            ' WHERE %sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct


    /**
     * Fazer o upload das fotos e salvá-las no diretório do álbum
     *
     * É feito o upload das fotos e as salva no diretório de fotos do álbum.
     * Depois é criado o registro das fotos salvas na base de dados.
     */
    public function upload() {
        if (isset($_FILES) && !empty($_FILES)) {
            # Informações do álbum
            $maf = new WebM\Album($this->foto_album);

            /*
             * Garantir que o diretório para upload das imagens esteja disponível. Já executo direto o método de criação
             * do diretório pois ele já faz a verificação se o diretório existe ou não, portanto não é necessário fazer
             * isso antes.
             */
            if (!$maf->criarDiretorio()) {
                throw new \DL3Exception(sprintf(ERRO_FOTOALBUM_UPLOAD_DIRETORIO_NAO_LOCALIZADO, $maf->dir_upload),
                    1404);
            } // Fim if

            # Fazer o upload das fotos
            $oup = new \Upload("{$maf->dir_upload}/original", 'fotos');
            $oup->setExtensoes($this->conf_extensoes_imagem);

            if (!$oup->salvar($maf->nome)) {
                throw new \DL3Exception(ERRO_FOTOALBUM_UPLOAD_SALVAR, 1500);
            } // Fim if

            # Selecionar as configurações do álbum
            $cws = new ConfiguracaoSite();

            foreach ($oup->salvos as $f) {
                $this->id = null;
                $this->imagem = preg_replace('~^\.?/~', '', $f);
                $this->publicar = true;

                # Criar as alternativas da imagem (foto e miniatura)
                $img_foto = new \Imagem($this->imagem);
                $img_mini = clone $img_foto;
                $img_fotow = $img_foto->getLargura();
                $img_fotoh = $img_foto->getAltura();

                if ($img_fotow > $img_fotoh) {
                    $img_foto->redimensionar($cws->getAlbumFotow(), null);
                    $img_mini->redimensionar($cws->getAlbumMiniw(), null);
                } else {
                    $img_foto->redimensionar(null, $cws->getAlbumFotoh());
                    $img_mini->redimensionar(null, $cws->getAlbumMinih());
                } // Fim if

                $this->foto = preg_replace('~\/original\/~', '/fotos/', $this->imagem);
                $this->mini = preg_replace('~\/original\/~', '/mini/', $this->imagem);

                $img_foto->salvar($this->foto);
                $img_mini->salvar($this->mini);

                # Otimizar as imagens
                if (\DL3::$imageoptim_ativo) {
                    $img_foto->otimizarParaWeb(\DL3::$imageoptim_chave);
                    $img_mini->otimizarParaWeb(\DL3::$imageoptim_chave);
                } // Fim if

                /*
                 * Utilizar a seguinte chamada "$this->salvar();" para salvar a foto não funciona da maneira desejada,
                 * pois não passa pelo __call
                 */
                $this->__call('salvar');
            } // Fim foreach
        } // Fim if
    } // Fim do método upload


    /**
     * Salvar determinado registro
     *
     * @param boolean $s   Define se o registro será salvo ou apenas será gerada a query de insert/update
     * @param array   $ci  Vetor com os campos a serem considerados
     * @param array   $ce  Vetor com os campos a serem desconsiderados
     * @param bool    $ipk Define se o campo PK será considerado para inserção
     *
     * @return mixed
     * @throws \DL3Exception
     */
    protected function salvar($s = true, array $ci = null, array $ce = null, $ipk = false) {
        # Apenas uma foto pode ser definida como capa de um álbum, portanto, caso
        # o registro atual esteja sendo definido como capa, a flag deve ser
        # desmarcada nas demais fotos
        if ($this->capa) {
            \DL3::$conex->exec("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}capa = 0 WHERE foto_album = {$this->foto_album}");
        } // Fim if

        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar


    /**
     * Remover o registro e as fotos vinculadas a ele
     */
    protected function remover() {
        if (parent::remover()) {
            # Remover as fotos
            return (file_exists($this->imagem) && unlink($this->imagem)) &&
            (file_exists($this->foto) && unlink($this->foto)) &&
            (file_exists($this->mini) && unlink($this->mini));
        } // Fim if

        return false;
    } // Fim do método remover
} // Fim do Modelo FotoAlbum