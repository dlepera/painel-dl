<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 12/01/2015 10:27:37
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class Album extends GeralM\EdicaoRegistro {
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

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS A'
            . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON ( FC.foto_album = A.album_id AND FC.foto_album_capa = 1 )"
            . ' WHERE A.%sdelete = 0';

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
        $r = parent::salvar($s, $ci, $ce, $ipk);

        if ($s && $r) {
            # Criar diretório do álbum
            if (isset($this->id)) {
                $this->criarDiretorio();
            } // Fim if

            # Durante a inclusão do registro, fotos podem ser incluídas
            if ($this->reg_vazio) {
                # Salvar as fotos enviadas
                $mfa = new FotoAlbum();
                $mfa->foto_album = $this->id;
                $mfa->upload();
            } // Fim if
        } // Fim if

        return $r;
    } // Fim do método salvar


    /**
     * Remover o registro do banco de dados
     */
    protected function remover() {
        return (int)(\Arquivos::removerDir($this->dir_upload, true) && parent::remover());
    } // Fim do método remover


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


    /**
     * Listar álbuns considerando as fotos contidas em cada um
     *
     * @param string $flt  Filtro a ser aplicado na listagem
     * @param string $ord  Ordenação a ser aplicada na listagem
     * @param string $cpos Campos a serem mostrados na listagem
     * @param int    $pgn  Número da página, para casos de paginação
     * @param int    $qtde Quantidade de registros a serem exibidos durante a paginação
     * @param int    $pos  Posição do registro a ser retornado. Quando null, retorna todos os registros encontrados
     *
     * @return array
     */
    public function listarComFotos($flt = null, $ord = null, $cpos = '*', $pgn = 0, $qtde = 20, $pos = null) {
        $bd_select = $this->bd_select;

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS A'
            . " LEFT JOIN {$this->bd_tabela}_fotos AS FC ON (FC.foto_album = A.album_id AND FC.foto_album_capa = 1 AND FC.foto_album_delete = 0)"
            . " LEFT JOIN {$this->bd_tabela}_fotos AS FT ON (FT.foto_album = A.album_id AND FT.foto_album_delete = 0)"
            . ' WHERE A.%sdelete = 0';

        $lista = $this->listar($flt, $ord, $cpos, $pgn, $qtde, $pos);

        $this->bd_select = $bd_select;

        return $lista;
    } // Fim do método listarComFotos


    // Diretório de salvamento das fotos ---------------------------------------------------------------------------- //
    /**
     * Criar o diretório que será utilizado para salvar as fotos
     *
     * @return bool
     */
    public function criarDiretorio() {
        if (!$this->verificarDiretorio()) {
            return mkdir($this->dir_upload) &&
            mkdir("{$this->dir_upload}/original") &&
            mkdir("{$this->dir_upload}/fotos") &&
            mkdir("{$this->dir_upload}/mini");
        } // Fim if

        return true;
    } // Fim do método criarDiretorio


    /**
     * Verificar se o diretório para upload as imagens existe
     *
     * @return bool
     */
    public function verificarDiretorio() {
        return file_exists($this->dir_upload);
    } // Fim do método verificarDiretorio
} // Fim do Modelo Album