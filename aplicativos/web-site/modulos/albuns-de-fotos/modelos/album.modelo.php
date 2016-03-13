<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace AlbunsDeFotos\Modelo;

use \Geral\Modelo as GeralM;

class Album extends GeralM\Registro {
    # Diretório onde serão salvos as fotos desse álbum
    const DIR_UPLOAD = 'web/uploads/albuns/%d';

    protected $id;
    protected $nome;
    protected $publicar = true;
    protected $delete = false;
    public $dir_upload;


    /**
     * @return string|null
     */
    public function getNome() {
        return $this->nome;
    }


    /**
     * @param string $nome
     */
    public function setNome($nome) {
        $this->nome = \Funcoes::ucWords(
            filter_var($nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL),
            EXPREG_PREPOSICOES
        );
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_albuns', 'album_');

        $this->bd_select = 'SELECT %s' .
            ' FROM %s AS A' .
            " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_tabela = '{$this->bd_tabela}' AND LR.log_registro_regpk = A.album_id AND LR.log_registro_acao = 'A' )" .
            " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa = 1 )" .
            ' WHERE A.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct


    /**
     * Selecionar um registro através da chave primária (PK - Primary Key)
     *
     * @param mixed  $v Valor a ser pesquisado na PK
     * @param string $a Alias da tabela principal configurado na consulta
     *
     * @return bool
     * @throws \DL3Exception
     */
    public function selecionarPK($v, $a = null) {
        if (parent::selecionarPK($v, $a)) {
            $this->dir_upload = sprintf(static::DIR_UPLOAD, $this->id);

            return true;
        } // Fim if

        return false;
    } // Fim selecionarPK


    /**
     * Contar quantidade e fotos de um álbum
     *
     * @param int $id ID do álbum de fotos. Quando esse parâmetro não é passado, é utilizado o ID do álbum carregado no
     *                modelo
     *
     * @return int Quantidade de fotos do álbum especificado
     */
    public function qtdeFotos($id = null) {
        $id = isset($id) ? $id : $this->id;
        $mft = new FotoAlbum();

        return (int)$mft->qtdeRegistros("foto_album = {$id}");
    } // Fim metódo qtdeFotos
} // Fim do Modelo Album