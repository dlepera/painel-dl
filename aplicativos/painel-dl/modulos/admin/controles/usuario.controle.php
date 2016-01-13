<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 09/01/2015 15:33:07
 */

/*
 * TAREFA: melhorar o algorítmo de salvamento da foto de perfil
 */

namespace Admin\Controle;

use \Geral\Controle as GeralC;
use \Admin\Modelo as AdminM;
use \Desenvolvedor\Modelo as DevM;

class Usuario extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new AdminM\Usuario(), 'admin', TXT_MODELO_USUARIO);
        $this->carregarPost([
            'id' => FILTER_VALIDATE_INT,
            'info_grupo' => FILTER_VALIDATE_INT,
            'info_nome' => FILTER_SANITIZE_STRING,
            'info_email' => FILTER_VALIDATE_EMAIL,
            'info_telefone' => FILTER_SANITIZE_STRING,
            'info_sexo' => FILTER_SANITIZE_STRING,
            'info_login' => FILTER_SANITIZE_STRING,
            'info_senha' => FILTER_DEFAULT,
            'info_senha_conf' => FILTER_DEFAULT,
            'pref_idioma' => FILTER_VALIDATE_INT,
            'pref_tema' => FILTER_VALIDATE_INT,
            'pref_formato_data' => FILTER_VALIDATE_INT,
            'pref_num_registros' => FILTER_VALIDATE_INT,
            'pref_exibir_id' => FILTER_VALIDATE_BOOLEAN,
            'pref_filtro_menu' => FILTER_VALIDATE_BOOLEAN,
            'conf_reset' => FILTER_VALIDATE_BOOLEAN,
            'conf_bloq' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




    /**
     * Mostrar a lista de registros
     */
    protected function mostrarLista(){
        $this->listaPadrao('usuario_id AS ' . TXT_LISTA_TITULO_ID . ', usuario_info_nome AS ' . TXT_LISTA_TITULO_NOME . ',' .
            " usuario_info_email AS '" . TXT_LISTA_TITULO_EMAIL . "', grupo_usuario_descr AS '" . TXT_LISTA_TITULO_GRUPO . "',"
            . " ( CASE usuario_conf_bloq WHEN 0 THEN 'Não' WHEN 1 THEN 'Sim' END ) AS '" . TXT_LISTA_TITULO_BLOQUEADO . "'",
            'usuario_info_nome, usuario_info_sexo', null);

        # Visão
        $this->carregarHTML('comum/visoes/form_filtro');
        $this->carregarHTML('lista_usuarios');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_USUARIOS);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'admin/usuarios/');
        $this->visao->adParam('form-acao', 'admin/usuarios/excluir-usuarios');
        $this->visao->adParam('campos', [
            ['valor' => 'grupo_usuario_descr', 'texto' => TXT_ROTULO_GRUPO],
            ['valor' => 'usuario_info_nome', 'texto' => TXT_ROTULO_NOME],
            ['valor' => 'usuario_info_email', 'texto' => TXT_ROTULO_EMAIL]
        ]);
        $this->visao->adParam('perm-bloquear?', \DL3::$autent->verificarPerm(get_called_class(), 'bloquear'));
    } // Fim do método mostrarLista




    /**
     * Minha conta
     *
     * Mostrar as informações do usuário logado
     */
    protected function minhaConta(){
        $this->mostrarForm($_SESSION['usuario_id'], '');
    } // Fim do método mostrarForm




    /**
     * Mostrar o formulário de inclusão e edição do registro
     *
     * @param int    $pk PK do registro a ser selecionado
     * @param string $rd URL para onde será redirecionado depois do salvamento do registro
     */
    protected function mostrarForm($pk = null, $rd = 'admin/usuarios'){
        $inc = $this->formPadrao('usuario', 'usuarios/salvar', 'usuarios/salvar', empty($rd) ? 'admin/usuarios' : $rd, $pk);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_usuario');

        $m_gu = new AdminM\GrupoUsuario();
        $l_gu = $m_gu->carregarSelect('grupo_usuario_publicar = 1', false);

        $m_id = new DevM\Idioma();
        $l_id = $m_id->carregarSelect('idioma_publicar = 1', false);

        $m_te = new DevM\Tema();
        $l_te = $m_te->listar('tema_publicar = 1', 'tema_descr', 'tema_id AS VALOR, tema_descr AS TEXTO, tema_padrao');

        $m_fd = new DevM\FormatoData();
        $l_fd = $m_fd->carregarSelect('formato_data_publicar = 1', false);

        if (!$inc) {
            # Grupo de usuário
            $mgu = new AdminM\GrupoUsuario($this->modelo->info_grupo);
            $this->visao->adParam('grupo-descr', $mgu->descr);
        } // Fim if( !$inc )

        # Parâmetros
        $this->visao->adParam('grupos-usuarios', $l_gu);
        $this->visao->adParam('idiomas', $l_id);
        $this->visao->adParam('temas', $l_te);
        $this->visao->adParam('formatos-data', $l_fd);
        $this->visao->adParam('novo-idioma?', \DL3::$autent->verificarPerm('Desenvolvedor\Controle\Idioma', 'mostrarForm'));
        $this->visao->adParam('novo-tema?', \DL3::$autent->verificarPerm('Desenvolvedor\Controle\Tema', 'mostrarForm'));
        $this->visao->adParam('novo-grupo?', \DL3::$autent->verificarPerm('Admin\Controle\GrupoUsuario', 'mostrarForm'));
        $this->visao->adParam('msg-usuario-bloq?', !$inc && $this->modelo->conf_bloq);
        $this->visao->adParam('usuario-logado?', $this->modelo->id == $_SESSION['usuario_id']);
    } // Fim do método minhaConta




    /**
     * Mostrar o formulário para alteração de senhas desse usuário
     */
    protected function formAlterarSenha(){
        $this->formPadrao('senha', null, 'usuarios/alterar-senha-usuario', 'admin/usuarios/minha-conta', $_SESSION['usuario_id']);

        # Visão
        $this->carregarHTML('form_trocar_senha');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_TROCAR_MINHA_SENHA);

        # Parâmetros
        $this->visao->adParam('msg-reset?', (bool)$_SESSION['usuario_conf_reset']);
    } // Fim do método formAlterarSenha




    /**
     * Executar a ação de alterar a senha do usuário
     */
    protected function alterarSenha(){
        # Obter as senhas informadas
        $sn = filter_input(INPUT_POST, 'senha_nova');
        $sc = filter_input(INPUT_POST, 'senha_nova_conf');
        $sa = $this->modelo->criptoMD5(
            filter_input(INPUT_POST, 'senha_atual'),
            $this->modelo->conf_camadas_md5
        );

        $this->modelo->selecionarPK($_SESSION['usuario_id']);
        $this->modelo->alterarSenha($sn, $sc, $sa);

        \Funcoes::mostrarMsg(SUCESSO_USUARIO_ALTERARSENHA, '__msg-sucesso');
    } // Fim do método alterarSenha




    /**
     * Bloquear ou desbloquear os usuários selecionado
     *
     * @param int $vlr 0 => bloqueia o(s) usuário(2) | 1 => desbloqueia o(s) usuário(s)
     *
     * @throws \DL3Exception
     */
    protected function bloquear($vlr){
        $tid = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

        if( !isset($tid) ){
            throw new \DL3Exception(MSG_PADRAO_NENHUM_REGISTRO_SELECIONADO, 1404);
        } // Fim if( !isset($tid) )

        # Quantidade total de registros e quantidade excluída
        $qt = count($tid);
        $qe = 0;

        foreach( $tid as $id ){
            $this->modelo->selecionarPK($id);
            $this->modelo->conf_bloq = $vlr;
            $qe = $this->modelo->salvar();
        } // Fim foreach

        $vlr == 1
            ? \Funcoes::mostrarMsg(!$qe? ERRO_USUARIO_BLOQUEAR : sprintf($qe == 1 ? SUCESSO_USUARIO_BLOQUEAR_UM : SUCESSO_USUARIO_BLOQUEAR_VARIOS, $qe, $qt), !$qe ? '__msg-erro' : '__msg-sucesso')
            : \Funcoes::mostrarMsg(!$qe ? ERRO_USUARIO_DESBLOQUEAR : sprintf($qe == 1 ? SUCESSO_USUARIO_DESBLOQUEAR_UM : SUCESSO_USUARIO_DESBLOQUEAR_VARIOS, $qe, $qt), !$qe ? '__msg-erro' : '__msg-sucesso');
    } // Fim do método bloquear




    protected function salvarFoto(){
        $this->modelo->salvarFoto();
        \Funcoes::mostrarMsg(SUCESSO_USUARIOS_SALVAR_FOTO, '__msg-sucesso');
    } // Fim do método salvarFoto
} // Fim do Controle Usuario