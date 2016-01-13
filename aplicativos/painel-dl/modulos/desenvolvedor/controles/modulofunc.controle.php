<?php

/**
 * @Autor	: Diego Lepera
 * @E-mail	: d_lepera@hotmail.com
 * @Projeto	: FrameworkDL
 * @Data	: 12/01/2015 10:18:15
 */

namespace Desenvolvedor\Controle;

use \Geral\Controle as GeralC;
use \Desenvolvedor\Modelo as DevM;
use \Admin\Modelo as AdminM;

class ModuloFunc extends GeralC\PainelDL{
    public function __construct(){
        parent::__construct(new DevM\ModuloFunc(), 'desenvolvedor', TXT_MODELO_MODULOFUNC);
	    $this->carregarPost([
            'id'          => FILTER_VALIDATE_INT,
            'func_modulo' => FILTER_VALIDATE_INT,
            'descr'       => FILTER_SANITIZE_STRING,
            'classe'      => FILTER_SANITIZE_STRING,
            'metodos'     => ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_REQUIRE_ARRAY],
            'grupos'      => ['filter' => FILTER_VALIDATE_INT, 'flags' => FILTER_REQUIRE_ARRAY]
	    ]);
    } // Fim do método __construct




	/**
	 * Mostrar a lista de registros
	 */
    protected function mostrarLista(){
        $this->listaPadrao('func_modulo_id AS ' . TXT_LISTA_TITULO_ID . ", CONCAT(func_modulo_descr, '<br/>', func_modulo_classe) AS " . TXT_LISTA_TITULO_DESCR,
	        null, null);

        # Visão
        $this->carregarHTML('comum/visoes/lista_padrao');
        $this->visao->setTitulo(TXT_PAGINA_TITULO_FUNCIONALIDADES);

        # Parâmetros
        $this->visao->adParam('dir-lista', 'desenvolvedor/modulos/funcionalidades');
        $this->visao->adParam('campos', [
            ['valor' => 'func_modulo_descr', 'texto' => TXT_ROTULO_DESCR],
            ['valor' => 'func_modulo_classe', 'texto' => TXT_ROTULO_CLASSE]
        ]);
    } // Fim do método mostrarLista




	/**
	 * Mostrar o formulário de inclusão e edição do registro
	 *
	 * @param int|null  $md  ID do módulo dessa funcionalidade
	 * @param bool|null $mst Nome da página mestra a ser carregada
	 * @param int|null  $pk  Valor da PK do registro a ser selecionado
	 */
    protected function mostrarForm($pk = null, $md = null, $mst = null){
        $inc = $this->formPadrao('func', 'modulos/funcionalidades/salvar', 'modulos/funcionalidades/salvar', null, $pk);

        # Visão
	    $this->carregarHTML('comum/visoes/titulo_h2');
        $this->carregarHTML('form_funcs', $mst);
	    $this->visao->setTitulo($inc
		    ? sprintf(TXT_PAGINA_TITULO_CADASTRAR_NOVA, $this->nome)
            : sprintf(TXT_PAGINA_TITULO_EDITAR_ESSA, $this->nome)
        );

        # Grupos de usuários
	    $mgu = new AdminM\GrupoUsuario();
	    $lgu = $mgu->carregarSelect('grupo_usuario_publicar = 1', false);

	    # Parâmetros
	    $this->visao->adParam('grupos', $lgu);
	    $this->visao->adParam('modulo', $md);

	    if ($inc) {
		    # Módulos
		    $mf = new DevM\Modulo($md);

		    $this->modelo->setClasse($mf->nomeClasse());

		    $this->visao->adParam('modulo-classe', $this->modelo->getClasse());
	    } // Fim if

        $classe = $this->modelo->getClasse();

        /*
         * Obter a lista completa de todos os métodos existentes na classe especificada
         */
         if (class_exists($classe)) {
            $rfx = new \ReflectionClass($classe);
            $metodos = preg_grep(
                '~^_{2}~',
                array_column(
                    array_map(
                        function ($m) use ($classe) {
                            if ($m->class === $classe) {
                                return (array)$m;
                            } // Fim if
                        },
                        (array)$rfx->getMethods(\ReflectionMethod::IS_PROTECTED)
                    ),
                   'name'
                ),
                PREG_GREP_INVERT
            );

            sort($metodos);

            $this->visao->adParam('lista-metodos', $metodos);
        } // Fim if
    } // Fim do método mostrarForm
} // Fim do Controle ModuloFunc
