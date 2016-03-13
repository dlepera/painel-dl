<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 09/01/2015 10:08:07
 */

$this->rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];



// Grupos de usuários ----------------------------------------------------------------------------------------------- //
$this->rotas['^(grupos-de-usuarios/lista|grupos-de-usuarios)$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^grupos-de-usuarios/novo(/[a-z]+)?$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$this->rotas['^grupos-de-usuarios/(editar|alterar)/\d+'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^grupos-de-usuarios/salvar$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'salvar'
];

$this->rotas['^grupos-de-usuarios/excluir-grupo$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'remover'
];

$this->rotas['^grupos-de-usuarios/carregar-select$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'carregarSelect'
];

$this->rotas['^grupos-de-usuarios/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'GrupoUsuario',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];


// Usuários --------------------------------------------------------------------------------------------------------- //
$this->rotas['^(usuarios/lista|usuarios)$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^usuarios/novo$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarForm'
];

$this->rotas['^usuarios/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^usuarios/salvar$'] = [
	'controle'  =>  'Usuario',
	'acao'      =>  'salvar'
];

$this->rotas['^usuarios/salvar-foto$'] = [
	'controle'  =>  'Usuario',
	'acao'      =>  'salvarFoto'
];

$this->rotas['^usuarios/excluir-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'remover'
];

$this->rotas['^usuarios/minha-conta$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'minhaConta'
];

$this->rotas['^usuarios/alterar-minha-senha$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'formAlterarSenha'
];

$this->rotas['^usuarios/alterar-senha-usuario$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'alterarSenha'
];

$this->rotas['^usuarios/bloquear-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  1
];

$this->rotas['^usuarios/desbloquear-usuarios$'] = [
    'controle'  =>  'Usuario',
    'acao'      =>  'bloquear',
    'vlr'       =>  0
];

$this->rotas['^usuarios/foto/\d+$'] = [
    'controle' => 'Usuario',
    'acao'     => 'caminhoFoto',
    'params'   => '/-/-/:id'
];



// Configuração de envio de e-mails --------------------------------------------------------------------------------- //
$this->rotas['^(envio-de-emails/lista|envio-de-emails)$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^envio-de-emails/novo$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarForm'
];

$this->rotas['^envio-de-emails/(editar|alterar)/\d+'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^envio-de-emails/salvar$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'salvar'
];

$this->rotas['^envio-de-emails/excluir-configuracao$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'remover'
];

$this->rotas['^envio-de-emails/testar-configuracao/\d+$'] = [
    'controle'  =>  'ConfigEmail',
    'acao'      =>  'testar',
    'params'    =>  '/-/-/:pk'
];