<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 10/01/2015 12:00:59
 */

$this->rotas['^(home|index|)$'] = [
    'controle'  =>  '',
    'acao'      =>  ''
];


// Contatos recebidos do site --------------------------------------------------------------------------------------- //
$this->rotas['^(contatos-recebidos/lista|contatos-recebidos)$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^contatos-recebidos/mostrar-detalhes/\d+$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'mostrarDetalhes',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^contatos-recebidos/apagar-contato$'] = [
    'controle'  =>  'ContatoSite',
    'acao'      =>  'remover'
];


// Assuntos para contato -------------------------------------------------------------------------------------------- //
$this->rotas['^(assuntos-contato/lista|assuntos-contato)$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^assuntos-contato/novo(/[a-z]+)?$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:pg_mestra'
];

$this->rotas['^assuntos-contato/(editar|alterar)/\d+$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^assuntos-contato/remover-assunto$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'remover'
];

$this->rotas['^assuntos-contato/salvar$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'salvar'
];

$this->rotas['^assuntos-contato/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'AssuntoContato',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];



// Tipos de dados para contato -------------------------------------------------------------------------------------- //
$this->rotas['^(tipos-de-dados/lista|tipos-de-dados)$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^tipos-de-dados/novo(/[a-z]+)?$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:pg_mestra'
];

$this->rotas['^tipos-de-dados/(editar|alterar)/\d+'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^tipos-de-dados/remover-tipo-de-dado$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'remover'
];

$this->rotas['^tipos-de-dados/salvar$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'salvar'
];

$this->rotas['^tipos-de-dados/carregar-select$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'carregarSelect'
];

$this->rotas['^tipos-de-dados/opcoes-avancadas$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'opcoesAvancadas'
];

$this->rotas['^tipos-de-dados/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'TipoDadoContato',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];


// Configurações do Google Analytics -------------------------------------------------------------------------------- //
$this->rotas['^(google-analytics/lista|google-analytics)$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^google-analytics/novo(/[a-z]+)?$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:pg_mestra'
];

$this->rotas['^google-analytics/(editar|alterar)/\d+'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^google-analytics/excluir-configuracao$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'remover'
];

$this->rotas['^google-analytics/salvar$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'salvar'
];

$this->rotas['^google-analytics/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'GoogleAnalytics',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];


// Dados para contato ----------------------------------------------------------------------------------------------- //
$this->rotas['^(dados-para-contato/lista|dados-para-contato)$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^dados-para-contato/novo(/[a-z]+)?$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:pg_mestra'
];

$this->rotas['^dados-para-contato/(editar|alterar)/\d+$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^dados-para-contato/excluir-dados$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'remover'
];

$this->rotas['^dados-para-contato/salvar$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'salvar'
];

$this->rotas['^dados-para-contato/alternar-publicacao/(publicar|ocultar)$'] = [
    'controle'  =>  'DadoContato',
    'acao'      =>  'alternarPublicacao',
    'params'    =>  '/-/-/:a'
];


// Álbum de fotos --------------------------------------------------------------------------------------------------- //
$this->rotas['^(albuns-de-fotos/lista|albuns-de-fotos)$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarLista'
];

$this->rotas['^albuns-de-fotos/novo(/[a-z]+)?$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarForm',
    'id'        =>  null,
    'params'    =>  '/-/-/:pg_mestra'
];

$this->rotas['^albuns-de-fotos/(editar|alterar)/\d+$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk'
];

$this->rotas['^albuns-de-fotos/excluir-albuns$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'remover'
];

$this->rotas['^albuns-de-fotos/salvar$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'salvar'
];

$this->rotas['^albuns-de-fotos/alternar-publicacao/(publicar|ocultar)$'] = [
	'controle'  =>  'Album',
	'acao'      =>  'alternarPublicacao',
	'params'    =>  '/-/-/:a'
];

$this->rotas['^albuns-de-fotos/incluir-fotos$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'upload'
];

$this->rotas['^albuns-de-fotos/salvar-foto$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'salvar'
];

$this->rotas['^albuns-de-fotos/editar-foto/\d+(/[a-z]+)?$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'mostrarForm',
    'params'    =>  '/-/-/:pk/:pg_mestra'
];

$this->rotas['^albuns-de-fotos/excluir-fotos$'] = [
    'controle'  =>  'FotoAlbum',
    'acao'      =>  'remover'
];

/*
 * A rota 'salvar' deve ficar antes da rota 'mostrarForm' para não acontecer confusão na funcionalidade, uma vez que o a
 * expressão regular para o formulário também serve para salvar o registro.
 */
$this->rotas['^albuns-de-fotos/editar-configuracoes/salvar'] = [
    'controle' => 'AlbumConfig',
    'acao'     => 'salvar'
];

$this->rotas['^albuns-de-fotos/editar-configuracoes(/[a-z]+)?$'] = [
    'controle' => 'AlbumConfig',
    'acao'     => 'mostrarForm',
    'params'   => '/-/-/:pg_mestra'
];


// Informações institucionais --------------------------------------------------------------------------------------- //
$this->rotas['^institucional$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'mostrarInfo'
];

$this->rotas['^institucional/editar$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'mostrarForm'
];

$this->rotas['^institucional/salvar$'] = [
    'controle'  =>  'Institucional',
    'acao'      =>  'salvar'
];


// Configurações do site -------------------------------------------------------------------------------------------- //
$this->rotas['^configuracoes$'] = [
    'controle'  =>  'ConfiguracaoSite',
    'acao'      =>  'mostrarForm'
];

$this->rotas['^configuracoes/salvar$'] = [
    'controle'  =>  'ConfiguracaoSite',
    'acao'      =>  'salvar'
];