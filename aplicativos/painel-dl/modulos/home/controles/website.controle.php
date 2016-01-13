<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 05/01/2015 12:46:40
 */

namespace Home\Controle;

use \Geral\Controle as Geral;
use \Website\Modelo as WebM;

class WebSite extends Geral\PainelDL{
    public function __construct($m = null) {
        parent::__construct($m, 'home', '');
    } // Fim do método __construct

    public function index(){
        # Visao
        $this->carregarHTML('home');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_PAINELDL_HOME);

        # Carregar informações sobre contatos recebidos
        $mcs = new WebM\ContatoSite();
	    $mga = new WebM\GoogleAnalytics();

        # Parâmetros
        $this->visao->adParam('rel-contatos', $mcs->relContarPorAssuntos());
	    $this->visao->adParam('mostrar-acessos?', (bool)$mga->selecionarPrincipal());
    } // Fim do método index


    public function _sobre(){
	    # Visao
	    $this->carregarHTML('sobre_sistema');
	    $this->visao->setTitulo(TXT_PAGINA_TITULO_PAINELDL_SOBRE);
    } // Fim do método _sobre




	/**
	 * Obter informações do Google Analytics
	 *
	 * @param        $dt_inicio
	 * @param        $dt_fim
	 * @param string $dimensao
	 * @param array  $metricas
	 *
	 * @throws \DL3Exception
	 */
    public function _ganalytics($dt_inicio, $dt_fim, $dimensao = 'day', $metricas = ['visits']){
        # Selecionar as configurações do Google Analytics
        $m_ga = new WebM\GoogleAnalytics();
        $m_ga->selecionarPrincipal();

        # Conectar ao Google Analytics
        $o_ga = new \gapi($m_ga->contaCompleta(), $m_ga->p12);

        # Retornar as informações
        $o_ga->requestReportData(
            $m_ga->perfil_id, $dimensao, !isset($metricas) ? ['visits'] : $metricas, null, null,
            \Funcoes::formatarDataHora($dt_inicio, 'Y-m-d'), \Funcoes::formatarDataHora($dt_fim, 'Y-m-d')
        );

        # Visitas
        $infos = [];

        foreach( $o_ga->getResults() as $info ){
	        $infos[] = ['dimensao' => (string)$info, 'visitas' => $info->getVisits()];
        } // Fim foreach

        echo json_encode($infos);
    } // Fim do método _ganalytics
} // Fim da classe WebSite