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
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class ConfiguracaoSite extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new WebM\ConfiguracaoSite(), 'website', TXT_MODELO_CONFIGURACAOSITE);
        $this->carregarPost([
            'id'           => FILTER_VALIDATE_INT,
            'tema'         => FILTER_VALIDATE_INT,
            'formato_data' => FILTER_VALIDATE_INT,
            'email'        => FILTER_VALIDATE_INT
        ]);
    } // Fim do método __construct




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 */
    protected function mostrarForm(){
        $this->formPadrao('config', null, 'configuracoes/salvar', 'website/configuracoes', 1);

        # Visão
        $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_configuracao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_CONFIGURACAOSITE);

        # Selecionar os temas
        $mtm = new DevM\Tema();
        $ltm = $mtm->carregarSelect('tema_publicar = 1', false);

        # Selecionar os formatos de datas
        $mfd = new DevM\FormatoData();
        $lfd = $mfd->carregarSelect('formato_data_publicar = 1', false);

        # Selecionar as configurações de envio de e-mails
        $mce = new AdminM\ConfigEmail();
        $lce = $mce->carregarSelect(null, false, 'id', 'titulo');

        # Parâmetros
        $this->visao->adParam('temas', $ltm);
        $this->visao->adParam('formatos-data', $lfd);
        $this->visao->adParam('confs-email', $lce);
    } // Fim do método mostrarForm
} // Fim do Controle ConfiguracaoSite