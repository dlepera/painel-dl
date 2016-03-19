<?php

namespace Geral\Controle;

use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class PainelDL extends Principal {
    public function __construct($m, $nm, $nc) {
        parent::__construct($m, $nm, $nc);

        # Alterar o tema utilizado
        $this->visao->setPgMestra($_SESSION['tema_pagina_mestra']);

        $this->visao->adParam('conf-site', [
            'tema_diretorio'     => $_SESSION['tema_diretorio'],
            'tema_pagina_mestra' => $_SESSION['tema_pagina_mestra']
        ]);

        # Carregar o menu
        $this->carregarHTML('comum/visoes/menu');

        # Selecionar os módulos e sub-módulos
        $mm = new DevM\Modulo();
        $lm = $mm->listar('M.modulo_publicar = 1 AND M.modulo_pai IS NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_nome, M.modulo_descr, M.modulo_link');
        $ls = $_SESSION['usuario_id'] != -1 ? $mm->listarMenu('M.modulo_publicar = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link, M.modulo_ordem') : $mm->listar('M.modulo_publicar = 1 AND M.modulo_menu = 1 AND M.modulo_pai IS NOT NULL', 'M.modulo_ordem, M.modulo_nome', 'M.modulo_id, M.modulo_pai, M.modulo_nome, M.modulo_descr, M.modulo_link, M.modulo_ordem');

        # Adicionar alguns links específicos do Painel-DL
        $this->visao->aux_links->novoLink('publicar', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_PUBLICANDO_REGISTRO,
            'data-acao'     => 'publicar-registro',
            'class'         => 'com-icone -publicar'
        ]);
        $this->visao->aux_links->novoLink('excluir-registro', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_EXCLUINDO_REGISTROS,
            'data-acao'     => '',
            'class'         => 'com-icone -excluir'
        ]);
        $this->visao->aux_links->novoLink('ocultar', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_PUBLICANDO_REGISTRO,
            'data-acao'     => 'ocultar-registro',
            'class'         => 'com-icone -nao-publicar'
        ]);
        $this->visao->aux_links->novoLink('detalhes', ['class' => 'com-icone -detalhes']);
        $this->visao->aux_links->novoLink('lista', ['class' => 'com-icone -lista']);
        $this->visao->aux_links->novoLink('bloquear', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_BLOQUEANDO_USUARIOS,
            'data-acao'     => 'bloquear-usuarios',
            'class'         => 'com-icone -bloquear'
        ]);
        $this->visao->aux_links->novoLink('desbloquear', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_DESBLOQUEANDO_USUARIOS,
            'data-acao'     => 'desbloquear-usuarios',
            'class'         => 'com-icone -desbloquear'
        ]);
        $this->visao->aux_links->novoLink('testar-email', [
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_ENVIANDO_EMAIL,
            'data-acao'     => 'testar-email',
            'class'         => 'com-icone -email'
        ]);
        $this->visao->aux_links->novoLink('voltar', ['class' => 'com-icone -voltar']);
        $this->visao->aux_links->novoLink('incluir-funcionalidades-padrao',
            ['class' => 'com-icone -nova-pasta', 'data-acao' => 'criar-funcionalidades']
        );
        $this->visao->aux_links->novoLink('configuracoes', ['class' => 'com-icone -configuracoes']);

        # Botões
        $this->visao->aux_form->novoBotao('excluir-registro', [
            'type'          => 'button',
            'data-ajax'     => true,
            'data-ajax-msg' => TXT_AJAX_EXCLUINDO_REGISTROS,
            'data-acao'     => 'excluir-registro',
            'class'         => 'botao -excluir'
        ]);

        # Dados do usuário
        $mus = new AdminM\Usuario($_SESSION['usuario_id']);

        # Parâmetros
        $this->visao->adParam('menu-modulos', $lm);
        $this->visao->adParam('menu-submodulos', $ls);
        $this->visao->adParam('usr-foto', $mus->mostrarFoto(\DL3::$dir_relativo, 'p'));
        $this->visao->adParam('mostrar-filtro-menu?', $_SESSION['usuario_pref_filtro_menu']);

        /*
         * Se a classe chamada for Login\Controle\Login, ainda não é necessário verificar o permissionamento
         */
        if (get_called_class() !== 'Login\\Controle\\Login') {
            $this->visao->adParam('perm-usr-senha?', \DL3::$autent->verificarPerm('Admin\Controle\Usuario', 'formAlterarSenha') && $_SESSION['usuario_id'] > 0);
            $this->visao->adParam('perm-usr-conta?', \DL3::$autent->verificarPerm('Admin\Controle\Usuario', 'minhaConta') && $_SESSION['usuario_id'] > 0);
        } // Fim if
    } // Fim do método __construct


    /**
     * Verificar o permissionamento do grupo antes de executar a ação
     *
     * @param string $n Nome da ação / método  a ser executada
     * @param array  $a Vetor com os valores dos argumentos a serem utilizados na chamada da ação
     *
     * @return bool|mixed
     */
    public function __call($n, $a) {
        if (!\DL3::$autent->verificarPerm(get_called_class(), $n)) {
            $this->visao->statusHTTP(403);

            return false;
        } // Fim if

        return call_user_func_array([$this, $n], !empty($a) ? $a : []);
    } // Fim do método __call
} // Fim do Controle PainelDL