<?php

/**
 * @Autor      : Diego Lepera
 * @E-mail     : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data       : 28/01/2015 23:49:46
 */

namespace Geral\Controle;

use \Geral\Modelo as GeralM;
use \Contato\Modelo as ContatoM;
use \Home\Modelo as HomeM;

class WebSite extends Principal {
    public function __construct($m, $nm, $nc) {
        parent::__construct($m, $nm, $nc);

        # Selecionar a configuração do Google Analytics ativa
        $mga = new HomeM\GoogleAnalytics();
        $lga = $mga->listar('ga_publicar = 1', null, 'ga_codigo_ua');

        # Informações para contato
        $mdc = new ContatoM\DadoContato();

        # Listar as redes sociais
        $lrs = $mdc->listar('dado_contato_publicar = 1 AND tipo_dado_rede_social = 1', 'tipo_dado_exibicao', 'tipo_dado_exibicao, tipo_dado_icone, dado_contato_descr');

        # Listar dados para contato
        $ldc = $mdc->listar('dado_contato_publicar = 1 AND tipo_dado_rede_social = 0', 'tipo_dado_exibicao', 'tipo_dado_exibicao, tipo_dado_icone, dado_contato_descr');

        # Selecionar as configurações para o website
        $mcf = new GeralM\ConfiguracaoSite();
        $lcf = $mcf->listar(null, null, 'tema_diretorio, tema_pagina_mestra, formato_data_data, formato_data_hora, formato_data_completo', 0, 1, -1);

        # Alterar a página mestra
        $this->visao->setPgMestra($lcf['tema_pagina_mestra']);

        # Carregar o menu
        $this->carregarHTML('comum/visoes/menu');

        # Parâmetros
        $this->visao->adParam('ga-configs', $lga);
        $this->visao->adParam('dados-contato', $ldc);
        $this->visao->adParam('redes-sociais', $lrs);
        $this->visao->adParam('conf-site', $lcf);
    } // Fim do método __construct
} // Fim do Controle WebSite