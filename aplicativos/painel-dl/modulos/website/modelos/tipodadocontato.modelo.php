<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 11/01/2015 12:03:30
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class TipoDadoContato extends GeralM\EdicaoRegistro{
    protected $id;
    protected $nome;
    protected $exibicao;
    protected $icone;
    protected $rede_social = false;
    protected $mascara;
    protected $expreg;
    protected $exemplo;
    protected $publicar = true;
    protected $delete = false;
    public $conf_extensoes_icone = ['png', 'jpg', 'gif', 'bmp'];




    /**
     * @return string
     */
    public function getNome(){
        return $this->nome;
    }




    /**
     * @param string $descr
     */
    public function setNome($descr){
        $this->nome = filter_var($descr, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return string
     */
    public function getExibicao(){
        return $this->exibicao;
    }




    /**
     * @param string $exibicao
     */
    public function setExibicao($exibicao){
        $this->exibicao = filter_var($exibicao, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return mixed
     */
    public function getIcone(){
        return $this->icone;
    }




    /**
     * @param mixed $icone
     */
    public function setIcone($icone){
        $this->icone = filter_var($icone, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    /**
     * @return boolean
     */
    public function isRedeSocial(){
        return (bool)$this->rede_social;
    }




    /**
     * @param boolean $rede_social
     */
    public function setRedeSocial($rede_social){
        $this->rede_social = filter_var($rede_social, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }




    /**
     * @return mixed
     */
    public function getMascara(){
        return $this->mascara;
    }




    /**
     * @param string $mascara
     */
    public function setMascara($mascara){
        $this->mascara = filter_var($mascara);
    }




    /**
     * @return mixed
     */
    public function getExpreg(){
        return $this->expreg;
    }




    /**
     * @param string $expreg
     */
    public function setExpreg($expreg){
        $this->expreg = filter_var($expreg);
    }




    /**
     * @return string
     */
    public function getExemplo(){
        return $this->exemplo;
    }




    /**
     * @param string $exemplo
     */
    public function setExemplo($exemplo){
        $this->exemplo = filter_var($exemplo, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }




    public function __construct($pk = null){
        parent::__construct('dl_site_dados_contato_tipos', 'tipo_dado_');
        $this->selecionarPK($pk);
    } // Fim do método __construct




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
    protected function salvar($s = true, array $ci = null, array $ce = null, $ipk = false){
        # Fazer upload da imagem
        $oup = new \Upload('web/uploads/contatos', 'icone');
        $oup->setExtensoes($this->conf_extensoes_icone);

        if ($oup->salvar($this->nome, true)) {
            $this->icone = preg_replace('~^\.~', '', $oup->salvos[0]);
        } // Fim if

        # Garantir que o campo exibição seja preenchido
        $this->exibicao = !isset($this->exibicao) ? $this->nome : $this->exibicao;

        # Salvar registro
        return parent::salvar($s, $ci, $ce, $ipk);
    } // Fim do método salvar




    /**
     * Remover registro do banco de dados
     */
    protected function remover(){
        # Remover o ícone
        if (!empty($this->icone)) {
            unlink(".{$this->icone}");
        } // Fim if

        return parent::remover();
    } // Fim do método remover
} // Fim do Modelo TipoDadoContato