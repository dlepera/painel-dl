<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 03/02/2015 11:00:17
 */

// Mostrar todos os álbuns de fotos --------------------------------------------------------------------------------- //
$this->rotas['^(home|index|)$'] = [
    'controle'  =>  'Album',
    'acao'      =>  'mostrarLista'
];



// Mostrar as fotos de um determinado álbum ------------------------------------------------------------------------- //
$this->rotas['^fotos/\d+(/[a-z]+)?$'] = [
    'controle'  =>  'Foto',
    'acao'      =>  'mostrarFotos',
    'params'    =>  '/-/:album/:pg_mestra'
];