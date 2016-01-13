<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 07/01/2015 16:45:46
 */

$this->rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];



// Módulos ---------------------------------------------------------------------------------------------------------- //
$this->rotas['^(modulos/lista|modulos)$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^modulos/novo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarForm'
];

$this->rotas['^modulos/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^modulos/atualizar-modulo$'] = $this->rotas['^modulos/instalar-modulo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'salvar'
];

$this->rotas['^modulos/desinstalar-modulo$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'remover'
];

$this->rotas['^modulos/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle' => 'Modulo',
    'acao'     => 'alternarPublicacao',
    'params'   => '/-/-/:a'
];

$this->rotas['^modulos/editar/\d+/criar-funcionalidades-padrao'] = [
    'controle' => 'Modulo',
    'acao' => 'criarFuncionalidadesPadrao',
    'params' => '/-/-/:pk/-'
];


// Funcionalidades -------------------------------------------------------------------------------------------------- //
$this->rotas['^modulos/funcionalidades/novo/\d+(/[a-z]+)?$'] = [
    'controle' => 'ModuloFunc',
    'acao'     => 'mostrarForm',
    'params'   => '/-/-/-/:md/:mst'
];

$this->rotas['^modulos/funcionalidades/editar/\d+(/[a-z]+)?$'] = [
	'controle'  =>  'ModuloFunc',
	'acao'      =>  'mostrarForm',
	'params'    =>  '/-/-/-/:pk/:mst'
];

$this->rotas['^modulos/funcionalidades/salvar$'] = [
	'controle'  =>  'ModuloFunc',
	'acao'      =>  'salvar'
];

$this->rotas['^modulos/funcionalidades/excluir$'] = [
    'controle'  =>  'ModuloFunc',
    'acao'      =>  'remover'
];


// Filtro de módulos para o menu ------------------------------------------------------------------------------------ //
$this->rotas['^modulos/filtro-menu$'] = [
    'controle'  =>  'Modulo',
    'acao'      =>  'filtroMenu',
    'bm'        =>  filter_input(INPUT_POST, 'bm')
];


// Temas ------------------------------------------------------------------------------------------------------------ //
$this->rotas['^(temas/lista|temas)$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^temas/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$this->rotas['^temas/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^temas/atualizar-tema$'] = $this->rotas['^temas/instalar-tema$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'salvar'
];

$this->rotas['^temas/desinstalar-tema$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'remover'
];

$this->rotas['^temas/carregar-select$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'carregarSelect'
];

$this->rotas['^temas/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'Tema',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];



// Idiomas ---------------------------------------------------------------------------------------------------------- //
$this->rotas['^(idiomas/lista|idiomas)$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^idiomas/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:mst'
];

$this->rotas['^idiomas/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^idiomas/salvar$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'salvar'
];

$this->rotas['^idiomas/remover-idioma$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'remover'
];

$this->rotas['^idiomas/carregar-select$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'carregarSelect'
];

$this->rotas['^idiomas/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'Idioma',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];