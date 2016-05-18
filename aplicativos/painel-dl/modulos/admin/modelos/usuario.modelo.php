<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 09/01/2015 15:11:14
 */

namespace Admin\Modelo;

use \Geral\Modelo as GeralM;

class Usuario extends GeralM\EdicaoRegistro {
    protected $id;
    protected $info_grupo;
    protected $info_nome;
    protected $info_email;
    protected $info_telefone;
    protected $info_sexo = 'M';
    protected $info_login;
    protected $info_senha;
    protected $info_senha_conf;
    protected $pref_idioma = 1;
    protected $pref_tema = 1;
    protected $pref_formato_data = 1;
    protected $pref_num_registros = 20;
    protected $pref_exibir_id = true;
    protected $pref_filtro_menu = false;
    protected $conf_bloq = false;
    protected $conf_reset = true;
    protected $perfil_foto = 'web/imgs/usuario-sem-foto.png';
    protected $ultimo_login;
    protected $delete = false;

    /**
     * Vetor com todas as extensões aceitas para upload da foto de perfil
     *
     * @var array
     */
    public $conf_extensoes_foto_perfil = ['jpg', 'jpeg', 'gif', 'png'];

    /**
     * Quantidade de camadas de criptografia MD5 a ser submetida a senha
     * @var int
     */
    public $conf_camadas_md5 = 2;


    /**
     * @return mixed
     */
    public function getInfoGrupo() {
        return $this->info_grupo;
    }


    /**
     * @param mixed $info_grupo
     */
    public function setInfoGrupo($info_grupo) {
        $this->info_grupo = filter_var($info_grupo, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getInfoNome() {
        return $this->info_nome;
    }


    /**
     * @param mixed $info_nome
     */
    public function setInfoNome($info_nome) {
        $this->info_nome = filter_var($info_nome, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getInfoEmail() {
        return $this->info_email;
    }


    /**
     * @param mixed $info_email
     */
    public function setInfoEmail($info_email) {
        $this->info_email = filter_var($info_email, FILTER_VALIDATE_EMAIL, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return mixed
     */
    public function getInfoTelefone() {
        return $this->info_telefone;
    }


    /**
     * @param mixed $info_telefone
     */
    public function setInfoTelefone($info_telefone) {
        $this->info_telefone = filter_var($info_telefone, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => EXPREG_TELEFONE_GERAL],
            'flags'   => FILTER_NULL_ON_FAILURE
        ]);
    }


    /**
     * @return string
     */
    public function getInfoSexo() {
        return $this->info_sexo;
    }


    /**
     * @param string $info_sexo
     */
    public function setInfoSexo($info_sexo) {
        $this->info_sexo = filter_var($info_sexo, FILTER_VALIDATE_REGEXP, [
            'options' => [
                'regexp'  => '~^(F|M){1}$~',
                'default' => 'M'
            ]
        ]);
    }


    /**
     * @return mixed
     */
    public function getInfoLogin() {
        return $this->info_login;
    }


    /**
     * @param mixed $info_login
     */
    public function setInfoLogin($info_login) {
        $this->info_login = filter_var($info_login, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return string
     */
    public function getInfoSenha() {
        return $this->info_senha;
    }


    /**
     * @param string $info_senha
     */
    public function setInfoSenha($info_senha) {
        $this->info_senha = $this->criptoMD5(filter_var($info_senha));
    }


    /**
     * @return mixed
     */
    public function getInfoSenhaConf() {
        return $this->info_senha_conf;
    }


    /**
     * @param mixed $info_senha_conf
     */
    public function setInfoSenhaConf($info_senha_conf) {
        $this->info_senha_conf = $this->criptoMD5(filter_var($info_senha_conf));
    }


    /**
     * @return int
     */
    public function getPrefIdioma() {
        return $this->pref_idioma;
    }


    /**
     * @param int $pref_idioma
     */
    public function setPrefIdioma($pref_idioma) {
        $this->pref_idioma = filter_var($pref_idioma, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return int
     */
    public function getPrefTema() {
        return $this->pref_tema;
    }


    /**
     * @param int $pref_tema
     */
    public function setPrefTema($pref_tema) {
        $this->pref_tema = filter_var($pref_tema, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return int
     */
    public function getPrefFormatoData() {
        return $this->pref_formato_data;
    }


    /**
     * @param int $pref_formato_data
     */
    public function setPrefFormatoData($pref_formato_data) {
        $this->pref_formato_data = filter_var($pref_formato_data, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }


    /**
     * @return int
     */
    public function getPrefNumRegistros() {
        return $this->pref_num_registros;
    }


    /**
     * @param int $pref_num_registros
     */
    public function setPrefNumRegistros($pref_num_registros) {
        $this->pref_num_registros = filter_var($pref_num_registros, FILTER_VALIDATE_INT, ['options' => ['default' => 20]]);
    }


    /**
     * @return int
     */
    public function getPrefExibirId() {
        return $this->pref_exibir_id;
    }


    /**
     * @param int $pref_exibir_id
     */
    public function setPrefExibirId($pref_exibir_id) {
        $this->pref_exibir_id = filter_var($pref_exibir_id, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return int
     */
    public function getPrefFiltroMenu() {
        return $this->pref_filtro_menu;
    }


    /**
     * @param int $pref_filtro_menu
     */
    public function setPrefFiltroMenu($pref_filtro_menu) {
        $this->pref_filtro_menu = filter_var($pref_filtro_menu, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return int
     */
    public function getConfBloq() {
        return $this->conf_bloq;
    }


    /**
     * @param int $conf_bloq
     */
    public function setConfBloq($conf_bloq) {
        $this->conf_bloq = filter_var($conf_bloq, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return int
     */
    public function getConfReset() {
        return $this->conf_reset;
    }


    /**
     * @param int $conf_reset
     */
    public function setConfReset($conf_reset) {
        $this->conf_reset = filter_var($conf_reset, FILTER_VALIDATE_BOOLEAN, ['options' => ['default' => false]]);
    }


    /**
     * @return string
     */
    public function getPerfilFoto() {
        return $this->perfil_foto;
    }


    /**
     * @param string $perfil_foto
     */
    public function setPerfilFoto($perfil_foto) {
        $this->perfil_foto = filter_var($perfil_foto, FILTER_SANITIZE_STRING, FILTER_FLAG_EMPTY_STRING_NULL);
    }


    /**
     * @return mixed
     */
    public function getUltimoLogin() {
        return \Funcoes::formatarDataHora($this->ultimo_login, $_SESSION['formato_data_completo']);
    }


    /**
     * @param mixed $ultimo_login
     */
    public function setUltimoLogin($ultimo_login) {
        $this->ultimo_login = \Funcoes::formatarDataHora($ultimo_login, \DL3::$bd_dh_formato_completo);
    }


    public function __construct($pk = null) {
        parent::__construct('dl_painel_usuarios', 'usuario_');

        $this->bd_select = 'SELECT %s' .
            ' FROM %s AS U' .
            ' INNER JOIN dl_painel_grupos_usuarios AS G ON( G.grupo_usuario_id = U.usuario_info_grupo )' .
            ' INNER JOIN dl_painel_idiomas AS I ON( I.idioma_id = U.usuario_pref_idioma )' .
            ' INNER JOIN dl_painel_temas AS T ON( T.tema_id = U.usuario_pref_tema )' .
            ' INNER JOIN dl_painel_formatos_data FD ON( FD.formato_data_id = U.usuario_pref_formato_data )' .
            ' WHERE %sdelete = 0';

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
    protected function salvar($s = true, array $ci = null, array $ce = null, $ipk = false) {
        # Aplicar validações
        if ($s) {
            $and_id = $this->reg_vazio ? '' : " AND {$this->bd_prefixo}id <> {$this->id}";

            # Validar a senha informada
            if ($this->reg_vazio) {
                if ($this->info_senha !== $this->info_senha_conf) {
                    throw new \DL3Exception(ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM, 1500);
                } // Fim if

                $this->validarSenha($this->info_senha, true);
            } // Fim if

            # Verificar se o login já está cadastrado
            if ($this->qtdeRegistros("{$this->bd_prefixo}info_login = '{$this->info_login}'{$and_id}") > 0) {
                throw new \DL3Exception(ERRO_USUARIO_SALVAR_LOGIN_JA_CADASTRADO, 1500);
            } // Fim if

            # Verificar se o login já está cadastrado
            if ($this->qtdeRegistros("{$this->bd_prefixo}info_email = '{$this->info_email}'{$and_id}") > 0) {
                throw new \DL3Exception(ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO, 1500);
            } // Fim if
        } // Fim if

        $r = parent::salvar($s, $ci, $this->reg_vazio
            ? array_unique(array_merge(['usuario_ultiumo_login'], $ce))
            : array_unique(array_merge(['usuario_info_login', 'usuario_info_senha'], $ce)),
            $ipk
        );

        if ($this->id == $_SESSION['usuario_id'] && $r && $s) {
            \DL3::$autent->carregarSessao($this->listar("usuario_id = {$this->id}", null,
                implode(',', \DL3::$autent->usr_infos), 0, 1, 0));
        } // Fim if

        return $r;
    } // Fim do método salvar


    /**
     * Alterar a senha do usuário logado
     *
     * @param string $sn Senha nova, escolhida pelo usuário
     * @param string $sc Confirmação da senha nova
     * @param string $sa Senha atual informada pelo usuário
     * @param bool   $rt Se true, permite que o usuário altere a senha sem estar autenticado. É utilizado para resets
     *                   de senhas
     *
     * @throws \DL3Exception
     */
    public function alterarSenha($sn, $sc, $sa = null, $rt = false) {
        if (!$rt) {
            # Verificar se a sessão foi iniciada
            if (session_status() !== PHP_SESSION_ACTIVE) {
                throw new \DL3Exception(ERRO_PADRAO_SESSAO_NAO_INICIADA, 1403);
            } // Fim if

            $this->selecionarPK($_SESSION['usuario_id']);
        } // Fim if

        if ($this->reg_vazio) {
            throw new \DL3Exception(ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO, 1404);
        } // Fim if

        # Comparar a senha atual
        if (!(bool)$this->qtdeRegistros("usuario_info_login = '{$_SESSION['usuario_info_login']}' AND usuario_info_senha = '{$sa}'") && !$rt) {
            throw new \DL3Exception(ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA, 1000);
        } // Fim if

        # Comparar as senhas infromadas
        if ($sn !== $sc) {
            throw new \DL3Exception(ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM, 1000);
        } // Fim if

        # Validar a senha informada
        $this->validarSenha($sn);

        # Criptografar a senha
        $sn_c = $this->criptoMD5($sn);

        # Alterar a senha no banco de dados
        $sql = \DL3::$conex->prepare("UPDATE {$this->bd_tabela} SET {$this->bd_prefixo}info_senha = :senha, {$this->bd_prefixo}conf_reset = 0 WHERE {$this->bd_prefixo}id = :id");
        $sql->execute([':senha' => $sn_c, ':id' => $this->id]);

        $_SESSION['usuario_conf_reset'] = 0;
    } // Fim do método alterarSenha


    /**
     * Validar a senha
     *
     * @param string     $sn  Senha a ser analisada
     * @param bool|false $md5 Se true, faz a comparação usando a hash MD5 dupla do valores a serem verificados
     *
     * @return bool
     * @throws \DL3Exception
     */
    public function validarSenha($sn, $md5 = false) {
        $lg = $md5 ? $this->criptoMD5($this->info_login) : $this->info_login;

        if ($sn === $lg) {
            throw new \DL3Exception(ERRO_USUARIO_VALIDAR_SENHA_IGUAL_LOGIN, 1403);
        } // Fim if

        return true;
    } // Fim do método validarSenha


    /**
     * Criptografar em MD5 na quantidade de vezes definida por $qt
     *
     * @param string   $st String a ser criptografada
     * @param int|null $qt Quantidade de vezes que a string deve ser passada na função md5()
     *
     * @return string
     */
    public function criptoMD5($st, $qt = null) {
        $md5 = $st;
        $qt = !isset($qt) || $qt < 0 ? $this->conf_camadas_md5 : $qt;

        for ($i = $qt; $i > 0; $i--) {
            $md5 = md5($md5);
        } // Fim foreach

        return $md5;
    } // Fim do método criptoMD5


    /**
     * Bloquear ou desbloquear o acesso ao sistema desse usuário
     *
     * @param int $vlr Valor que define se o usuário será bloqueado ou desbloquado
     */
    protected function bloquear($vlr) {
        $this->setConfBloq($vlr);
        $this->salvar();
    } // Fim do método bloquear


    /**
     * Selecionar um usuário pelo usuário e senha
     *
     * @param string $u Nome de usuário
     * @param string $s Senha do usuário
     * @param string $c Campos a serem selecionados para a sessão
     * @param bool   $m Se true, a senha passará pela rotina de criptografia MD5
     *
     * @return array Vetor associativo com as informações do usuário
     * @throws \DL3Exception
     */
    public function fazerLogin($u, $s, $c = '*', $m = true) {
        $this->setInfoLogin($u);
        $this->setInfoEmail($u);
        $m ? $this->setInfoSenha($s) : $this->info_senha = $s;

        $d = $this->listar("(usuario_info_login = '{$this->info_login}' OR usuario_info_email = '{$this->info_email}') AND usuario_info_senha = '{$this->info_senha}'", null, $c, 0, 1, 0);

        if ((bool)$d === false) {
            throw new \DL3Exception(ERRO_USUARIO_FAZERLOGIN_USUARIO_OU_SENHA_INVALIDOS, 1403);
        } // Fim if

        if ((bool)$d['usuario_conf_bloq']) {
            throw new \DL3Exception(ERRO_USUARIO_FAZERLOGIN_USUARIO_BLOQUEADO, 1403);
        } // Fim if

        if ($m) {
            # Registrar a data desse login
            $this->selecionarPK($d['usuario_id']);
            $this->ultimo_login = date(\DL3::$bd_dh_formato_completo);
            $this->salvar(true, ['usuario_id', 'usuario_ultimo_login']);
        } // Fim if

        return $d;
    } // Fim do método fazerLogin


    /**
     * Mostrar a foto de perfil do usuário
     *
     * @param string $dr Diretório relativo da foto
     * @param string $tm Tamanho da foto
     *
     * @return string Trecho HTML para exibir a foto de perfil
     */
    public function mostrarFoto($dr = '.', $tm = 'm') {
        $pf = "{$dr}{$this->perfil_foto}";

        return '<span class="foto-perfil -tam-' . $tm . '">' .
        "    <img src='{$pf}' class='foto' alt='{$this->info_nome}'/>" .
        '</span>';
    } // Fim do método mostrarFoto


    public function resumo() {
        return '<table class="usr-resumo">' .
        '<tbody class="bloco-registros">' .
        '<tr>' .
        '  <td class="usr-resumo-rotulo">' . TXT_ROTULO_NOME . '</td>' .
        '  <td class="usr-resumo-info">' . $this->info_nome . '</td>' .
        '</tr>' .
        '<tr>' .
        '  <td class="usr-resumo-rotulo">' . TXT_ROTULO_EMAIL . '</td>' .
        '  <td class="usr-resumo-info">' . $this->info_email . '</td>' .
        '</tr>' .
        '<tr>' .
        '  <td class="usr-resumo-rotulo">' . TXT_ROTULO_GRUPO . '</td>' .
        '  <td class="usr-resumo-info">' . $this->info_grupo . '</td>' .
        '</tr>' .
        '</tbody>' .
        '</table>';
    } // Fim do método _resumo


    public function salvarFoto() {
        # Salvar a foto do usuário
        if ($this->id != $_SESSION['usuario_id']) {
            throw new \DL3Exception(ERRO_USUARIO_SALVAR_FOTO_OUTRO_USUARIO, 1403);
        } // Fim if

        $oup = new \Upload('web/uploads/usuarios', 'perfil_foto');
        $oup->setExtensoes($this->conf_extensoes_foto_perfil);
        $oup->conf_bloq_extensao = true;

        # Remover a foto atual
        if (!empty($this->perfil_foto)) {
            unlink($this->perfil_foto);
        } // Fim if

        if ($oup->salvar($this->info_nome)) {
            $this->perfil_foto = preg_replace('~^./~', '', $oup->salvos[0]);

            # Recortar a foto
            $tim = 200;
            $oim = new \Imagem($oup->salvos[0]);

            $oim->getAltura() > $oim->getLargura()
                ? $oim->redimensionar(null, $tim)
                : $oim->redimensionar($tim);

            $oim->salvar($oup->salvos[0]);

            # Otimizar a foto
            if (\DL3::$imageoptim_ativo) {
                $oim->otimizarParaWeb(\DL3::$imageoptim_chave);
            } // Fim if

            $this->salvar();
        } // Fim if
    }// Fim do método salvarFoto
} // Fim do Modelo Usuario