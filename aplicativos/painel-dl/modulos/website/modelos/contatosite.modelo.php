<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 05/01/2015 18:02:20
 */

namespace WebSite\Modelo;

use \Geral\Modelo as GeralM;

class ContatoSite extends GeralM\EdicaoRegistro {
    protected $id;
    protected $nome;
    protected $email;
    protected $telefone;
    protected $assunto;
    protected $mensagem;
    protected $delete = false;


    /**
     * @return mixed
     */
    public function getNome() {
        return $this->nome;
    }


    /**
     * @param mixed $nome
     */
    public function setNome($nome) {
        $this->nome = filter_var($nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email) {
        $this->email = filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getTelefone() {
        return $this->telefone;
    }


    /**
     * @param mixed $telefone
     */
    public function setTelefone($telefone) {
        $this->telefone = filter_var($telefone, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => EXPREG_TELEFONE_GERAL], 'flags' => FILTER_NULL_ON_FAILURE]);
    }


    /**
     * @return mixed
     */
    public function getAssunto() {
        return $this->assunto;
    }


    /**
     * @param mixed $assunto
     */
    public function setAssunto($assunto) {
        $this->assunto = filter_var($assunto, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getMensagem() {
        return $this->mensagem;
    }


    /**
     * @param mixed $mensagem
     */
    public function setMensagem($mensagem) {
        $this->mensagem = filter_var($mensagem);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_site_contatos', 'contato_site_');

        $this->bd_select = 'SELECT %s'
            . ' FROM %s AS CS'
            . ' LEFT JOIN dl_site_assuntos_contato AS AC ON( AC.assunto_contato_id = CS.contato_site_assunto )'
            . " INNER JOIN dl_painel_registros_logs AS LR ON( LR.log_registro_regpk = CS.contato_site_id AND LR.log_registro_tabela = '{$this->bd_tabela}' AND LR.log_registro_acao = 'A' )"
            . ' WHERE CS.%sdelete = 0';

        $this->selecionarPK($pk);
    } // Fim do método __construct


    /*
     * Impedir o salvamento de registros
     */
    public function salvar($s = true, array $ci = null, array $ce = null, $ipk = false) {
        return;
    } // Fim do método salvar


    /**
     * Relatório de contatos recebidos por assunto
     *
     * Gerar um relatório simples para mostrar quantos contatos foram recebidos
     * para cada assunto
     *
     * @return string Trecho HTML demosntrando o resultado do relatório
     */
    public function relContarPorAssuntos() {
        $num = $this->qtdeRegistros();

        $lis = $this->listar(
            '1 = 1 GROUP BY assunto_contato_id', 'QTDE DESC, assunto_contato_descr',
            "COUNT({$this->bd_prefixo}id) AS QTDE, COALESCE(assunto_contato_descr, '" . TXT_DIVERSOS_ASSUNTO_NAO_INFORMADO . "') AS DESCR, COALESCE(assunto_contato_cor, '#000') AS COR"
        );

        $tabela = '<table style="width: 100%;"><tbody>';

        foreach ($lis as $d) {
            $p100 = round(($d['QTDE'] * 100) / $num);

            $tabela .= "<tr style='color: {$d['COR']}'>"
                . "<td>{$d['DESCR']}</td>"
                . "<td>{$d['QTDE']} ({$p100}%)</td>"
                . '</tr>';
        } // Fim foreach

        $tabela .= '</tbody><tfoot>'
            . '<tr style="color: #000">'
            . '<td>' . TXT_ROTULO_TOTAL . '</td>'
            . "<td>{$num} (100%)</td>"
            . '</tr></tfoot></table>';

        return $tabela;
    } // Fim do método relContarPorAssuntos
} // Fim do Modelo ContatoSite