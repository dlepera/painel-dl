<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 21/01/2015 16:05:12
 */

namespace Login\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;
use \Login\Modelo as LoginM;

class Login extends GeralC\PainelDL {
    public function __construct() {
        parent::__construct(null, 'login', null);
        $this->visao->setPgMestra('login');
    } // Fim do método __construct


    /**
     * Mostrar o formulário de login
     */
    public function mostrarForm() {
        $this->formPadrao('login', 'fazer-login', null, filter_input(INPUT_GET, 'url'), null, false);

        $this->carregarHTML('form_login');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_LOGIN);

        # Selecionar o tema padrão
        $mtm = new DevM\Tema();
        $ltm = $mtm->listar('tema_padrao = 1', null, 'tema_diretorio', 0, 1, 0);

        // Parâmetros
        $this->visao->adParam('tema', $ltm['tema_diretorio']);
    } // Fim do método mostrarForm


    /**
     * Mostrar o formulário para recuperação da senha
     */
    public function mostrarEsqueci() {
        $this->formPadrao('login', 'recuperar-senha', null);

        $this->carregarHTML('form_esqueci');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_ESQUECI_MINHA_SENHA);

        # Selecionar o tema padrão
        $mtm = new DevM\Tema();
        $ltm = $mtm->listar('tema_padrao = 1', null, 'tema_diretorio', 0, 1, 0);

        /* Parâmetros */
        $this->visao->adParam('tema', $ltm['tema_diretorio']);
    } // Fim do método mostrarEsqueci


    /**
     * Recuperar senha
     *
     * Enviar um e-mail ao usuário com um link para resetar a senha
     */
    public function recuperarSenha() {
        $le = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);

        $mu = new AdminM\Usuario();
        $lu = $mu->listar("usuario_info_login = '{$le}' OR usuario_info_email = '{$le}'", null, 'usuario_id, usuario_info_nome, usuario_info_email', 0, 1, 0);

        if ($lu === false) {
            throw new \DL3Exception(ERRO_LOGIN_RECUPERARSENHA_USUARIO_NAO_LOCALIZADO, 1404);
        } // Fim if

        /*
         * Quando houver uma solicitação em aberto, expirá-la e criar uma nova
         */
        $mr_e = new LoginM\Recuperacao();
        $mr_e->selecionarUK(['usuario', 'status'], [$lu['usuario_id'], 'S']);

        if (!$mr_e->reg_vazio) {
            $mr_e->setStatus('E');
            $mr_e->salvar(true, ['recuperacao_id', 'recuperacao_status']);
        } // Fim if

        /*
         * Criar uma nova solicitação de recuperação de senha
         */
        $mr_s = new LoginM\Recuperacao();
        $mr_s->setStatus('S');
        $mr_s->setUsuario($lu['usuario_id']);
        $mr_s->setHash(date(\DL3::$bd_dh_formato_completo));
        $mr_s->salvar(true, ['recuperacao_status', 'recuperacao_usuario', 'recuperacao_hash']);

        # Link de recuperação da senha
        $lk = \DL3::$host_completo . "login/recuperar-senha/{$mr_s->getHash()}";

        if (!class_exists('Email')) {
            throw new \DL3Exception(ERRO_LOGIN_RECUPERARSENHA_CLASSE_ENVIO_EMAIL_NAO_LOCALIZADA, 1404);
        } // Fim if

        # Enviar o e-mail
        $corpo = sprintf(TXT_EMAIL_CORPO_RECUPERAR_SENHA, $lu['usuario_info_nome'], $lk, $lk);

        $obj_e = new \Email();
        $obj_e->enviar($lu['usuario_info_email'], TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA, $corpo);
        $obj_e->gravarLog(__CLASS__, 'dl_painel_usuarios_recuperacoes', $mr_s->getId(), TXT_EMAIL_ASSUNTO_RECUPERACAO_SENHA, $corpo, $lu['usuario_info_email']);

        \Funcoes::mostrarMsg(sprintf(SUCESSO_LOGIN_RECUPERARSENHA, $lu['usuario_info_email']), '-sucesso');
    } // Fim do método recuperarSenha


    /**
     * Mostrar formulário para reset de senha
     *
     * @param string $h Hash MD5 da recuperação
     *
     * @throws \DL3Exception
     */
    public function mostrarResetSenha($h) {
        $hs = filter_var($h, FILTER_DEFAULT);

        # Selecionar a recuperação
        $mr = new LoginM\Recuperacao();
        $lr = $mr->listar("recuperacao_hash = '{$hs}' AND recuperacao_status = 'S'", null, 'recuperacao_id, usuario_info_nome', 0, 1, 0);

        if ($lr === false || empty($lr)) {
            throw new \DL3Exception(ERRO_LOGIN_MOSTRARRESETSENHA, 1404);
        } // Fim if

        $this->formPadrao('login', 'resetar-senha-usuario', null, \DL3::$base_html);

        # Visão
        $this->carregarHTML('form_reset');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_MOSTRARRESETSENHA);

        # Selecionar o tema padrão
        $mtm = new DevM\Tema();
        $ltm = $mtm->listar('tema_padrao = 1', null, 'tema_diretorio', 0, 1, 0);

        # Parâmetros
        $this->visao->adParam('tema', $ltm['tema_diretorio']);
        $this->visao->adParam('id', $lr['recuperacao_id']);
        $this->visao->adParam('nome-usuario', $lr['usuario_info_nome']);
    } // Fim do método mostrarResetSenha


    /**
     * Realizar o reset da senha
     */
    public function resetarSenha() {
        # Tratar os dados
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $sn = filter_input(INPUT_POST, 'senha_nova');
        $sc = filter_input(INPUT_POST, 'senha_nova_conf');

        $mr = new LoginM\Recuperacao($id);
        $mu = new AdminM\Usuario($mr->getUsuario());

        # Alterar a senha do usuário
        $mu->alterarSenha($sn, $sc, null, true);

        # Alterar o status
        $mr->setStatus('R');
        $mr->salvar(true, ['recuperacao_id', 'recuperacao_status']);

        \Funcoes::mostrarMsg(SUCESSO_LOGIN_RESETARSENHA, '-sucesso');
    } // Fim do método resetarSenha


    /**
     * Realizar o login no sistema
     */
    public function fazerLogin() {
        $u = filter_input(INPUT_POST, 'login');
        $s = filter_input(INPUT_POST, 'senha');

        \DL3::$autent->fazerLogin($u, $s)
            ? \Funcoes::mostrarMsg(SUCESSO_LOGIN_FAZERLOGIN, '-sucesso')
            : \Funcoes::mostrarMsg(ERRO_LOGIN_FAZERLOGIN, '-erro');
    } // Fim do método fazerLogin


    /**
     * Realizar o logout do sistema
     */
    public function fazerLogout() {
        \DL3::$autent->fazerLogout()
            ? \Funcoes::mostrarMsg(SUCESSO_LOGIN_FAZERLOGOUT, '-sucesso')
            : \Funcoes::mostrarMsg(ERRO_LOGIN_FAZERLOGOUT, '-erro');
    } // Fim do método fazerLogout
} // Fim do Controle Login