<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 21/01/2015 16:08:22
 */

$this->rotas['^(home|index|)$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostrarForm'
];



// Login e logout --------------------------------------------------------------------------------------------------- //
$this->rotas['^fazer-login$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'fazerLogin'
];

$this->rotas['^fazer-logout$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'fazerLogout'
];



// Esqueci minha senha ----------------------------------------------------------------------------------------------- //
$this->rotas['^esqueci-minha-senha$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostrarEsqueci'
];

$this->rotas['^recuperar-senha$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'recuperarSenha'
];

$this->rotas['^recuperar-senha/[a-z0-9]{32}$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'mostrarResetSenha',
    'params'    =>  '/-/:h'
];

$this->rotas['^resetar-senha-usuario$'] = [
    'controle'  =>  'Login',
    'acao'      =>  'resetarSenha'
];