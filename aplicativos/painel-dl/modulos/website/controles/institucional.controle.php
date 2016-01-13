<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace WebSite\Controle;

use \Geral\Controle as GeralC;
use \WebSite\Modelo as WebM;

class Institucional extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\Institucional(), 'website', TXT_MODELO_SOBRE);
        $this->carregarPost([
            'id'       => FILTER_VALIDATE_INT,
            'historia' => FILTER_DEFAULT,
            'missao'   => FILTER_DEFAULT,
            'visao'    => FILTER_DEFAULT,
            'valores'  => FILTER_DEFAULT,
            'publicar' => FILTER_VALIDATE_BOOLEAN
        ]);
    } // Fim do método __construct




	/**
	 *  Mostrar as informações institucionais do site
	 */
    protected function mostrarInfo(){
        # Visão
        $this->carregarHTML('det_instit');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_INFOS_INSTITUCIONAIS);

        # Obter o ID das informações
        $id = $this->modelo->listar(null, null, 'MAX(instit_id) AS ID', 0, 1, 0);
        $this->modelo->selecionarPK($id['ID']);

        # Parâmetros
        $this->visao->adParam('modelo', $this->modelo);
    } // Fim do método mostrarInfo




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 */
    protected function mostrarForm(){
        $id = $this->modelo->listar(null, null, 'MAX(instit_id) AS ID', 0, 1, 0);

        $this->formPadrao('instit', 'institucional/salvar', 'institucional/salvar', 'website/institucional', $id['ID']);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_instit');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_EDITAR_INSTITUCIONAL);
    } // Fim do método mostrarForm
} // Fim do Controle Institucional