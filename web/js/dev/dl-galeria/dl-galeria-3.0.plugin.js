/**
 * @Autor    : Diego Lepera
 * @E-mail    : d_lepera@hotmail.com
 * @Projeto    : FrameworkDL
 * @Data    : Jul 28, 2014 10:33:24 AM
 */

/*global carregarCSS*/

(function ($) {
    // Variáveis ---------------------------------------------------------------------------------------------------- //
    var seletor_foto = '.grade-fotos > .foto';
    var seletor_indic = '.grade-fotos > .indic';
    var seletor_minis = '.grade-minis > .foto > .imagem';

    // Funções ------------------------------------------------------------------------------------------------------ //
    function trocarFoto($galeria, foto, loop) {
        var $foto = $galeria.find(seletor_foto);
        var $indic = $galeria.find(seletor_indic);
        var $minis = $galeria.find(seletor_minis);
        var ultima = $foto.length - 1;
        var display = $foto.filter(':visible').css('display');
        loop = loop || false;

        if (foto < 0 || foto > ultima) {
            if (loop) {
                if (foto < 0) {
                    foto = ultima;
                } else if (foto > ultima) {
                    foto = 0;
                }
            } else {
                return null;
            } // Fim if
        } // Fim if

        // Mostrar a nova foto
        $foto.css('display', 'none')
            .filter(':eq(' + foto + ')').css('display', display);

        // Marcar o indicador da foto atual
        $indic.find('.link.-atual').removeClass('-atual');
        $indic.find('.link:eq(' + foto + ')').addClass('-atual');

        // Marcar a miniatura da foto atual
        $minis.filter('.-atual').removeClass('-atual');
        $minis.filter(':eq(' + foto + ')').addClass('-atual');
    } // Fim function trocarFoto($galeria, foto, loop)


    // Plugin ------------------------------------------------------------------------------------------------------- //
    /**
     * Iniciar e configurar a galeria de fotos
     *
     * @param {object} opcoes
     * @param {boolean} mesclar
     * @returns {object} instância jquery do objeto selecionado
     */
    $.fn.galeriaFotos = function (opcoes, mesclar) {
        var $th = $(this);

        // Definir os valores padrão para as opções / configurações do plugin
        var padrao = {
            // Definir se haverão as miniaturas das fotos
            minis: false,

            // Definir se haverão botões para controlar a navegação
            naveg: false,

            // Definir se será exibido o indicador
            indicador: false,

            // Objeto que contenha as informações (json) das fotos
            // src (obrigatório): caminho para a fotos
            // titulo (opcional): título a ser exibido da foto
            // descr (opcional): descrição a ser exibida juntamente com a foto
            // ir (opcional): link para onde a imagem deve direcionar ao ser clicada
            fotos: [],

            /**
             * Animação utilizada para a troca de imagens (quando necessário de acordo com o tema)
             */
            animacao: 'rotacionar .35s linear',

            // Definir o tema do plugin
            tema: 'galeria-2',

            // Definir a auto troca de imagens, como numa apresentação de slides
            // ativar (obrigatório): ativar ou desativar a opção
            // tempo (obrigatório): tempo que a imagem será exibida antes de ser alterada
            // para a próxima
            autotroca: {ativar: false, tempo: 10000},

            // Configurar a tecla ESC para remover (esconder) a galeria
            // Obs.: Utilizado para galerias no estilo LightBox
            teclaesc: false,

            // Criar um botão para fechar a galeria
            // Obs.: Utilizado para galerias no estilo LightBox
            botaofechar: false
        };

        // Unir os valores de configuração do usuário com os valores padrão
        opcoes = $.extend(mesclar === true, {}, padrao, opcoes);

        // Aplicar o tema do plugin
        if (typeof(carregarCSS) === 'function') {
            carregarCSS('web/js/min/dl-galeria/temas/' + opcoes.tema + '/css/galeria-fotos.tema.css');
        } // Fim if

        $th.addClass('__jQuery-galeriaFotos ' + opcoes.tema);

        /**
         * Quantidade de fotos a serem incluídas na galeria
         * @type {Number}
         */
        var qtde_f = opcoes.fotos.length;

        /**
         * Nome do namespace a ser aplicado nos eventos
         * @type {string}
         */
        var evt_ns = '__fotos';


        // Fotos ---------------------------------------------------------------------------------------------------- //
        var i, foto, $foto, $infos, $imagem;
        var $fotos = $(document.createElement('div')).addClass('grade-fotos').appendTo($th);

        // Criar as fotos
        for (i = 0; i < qtde_f; i++) {
            foto = opcoes.fotos[i];

            $foto = $(document.createElement('figure')).addClass('foto').appendTo($fotos);
            $imagem = $(document.createElement('img')).addClass('imagem')
                .attr({
                    src: foto.src, title: foto.titulo
                })
                .appendTo($foto);

            // Configurar a animação de troca da imagem
            if (opcoes.animacao.length > 0) {
                $imagem.css({
                    '-webkit-animation': opcoes.animacao,
                    animation: opcoes.animacao
                });
            } // Fim if

            if (foto.titulo || foto.descr) {
                $infos = $(document.createElement('figcaption')).addClass('infos').appendTo($foto);

                if (foto.titulo) {
                    $(document.createElement('p')).addClass('titulo').text(foto.titulo).appendTo($infos);
                } // if

                if (foto.descr) {
                    $(document.createElement('p')).addClass('descr').text(foto.descr).appendTo($infos);
                } // Fim if
            } // Fim if
        } // Fim for

        var $minis = $fotos.clone().removeClass('grade-fotos').addClass('grade-minis');

        if (opcoes.naveg || opcoes.indicador) {
            var $links = $(document.createElement('a')).attr('href', 'javascript:').addClass('link');

            // Navegação -------------------------------------------------------------------------------------------- //
            if (opcoes.naveg) {
                var $naveg = $(document.createElement('nav')).addClass('naveg').appendTo($fotos);

                // Botão: Primeira foto
                $links.clone().addClass('link -primeira').text('Primeira').on('click.' + evt_ns, {DOM: $th}, function (evt) {
                    trocarFoto(evt.data.DOM, 0, false);
                }).appendTo($naveg);

                // Botão: Foto anterior
                $links.clone().addClass('link -anterior').text('Anterior').on('click.' + evt_ns, {DOM: $th}, function (evt) {
                    trocarFoto(
                        evt.data.DOM,
                        evt.data.DOM.find(seletor_foto + ':visible').index() - 1,
                        false
                    );
                }).appendTo($naveg);

                // Botão: Próxima foto
                $links.clone().addClass('link -proxima').text('Próximo').on('click.' + evt_ns, {DOM: $th}, function (evt) {
                    trocarFoto(
                        evt.data.DOM,
                        evt.data.DOM.find(seletor_foto + ':visible').index() + 1
                    );
                }).appendTo($naveg);

                // Botão: Última foto
                $links.clone().addClass('link -ultima').text('Última').on('click.' + evt_ns, {
                    DOM: $th,
                    ultima: qtde_f - 1
                }, function (evt) {
                    trocarFoto(evt.data.DOM, evt.data.ultima, false);
                }).appendTo($naveg);
            } // Fim if


            // Indicadores ------------------------------------------------------------------------------------------ //
            if (opcoes.indicador) {
                var num;
                var $indic = $(document.createElement('nav')).addClass('indic').appendTo($fotos);

                for (i = 0; i < qtde_f; i++) {
                    num = i + 1;
                    $links.clone().addClass(num === 1 ? 'link -atual' : '').text(num).on('click.' + evt_ns, {
                        DOM: $th,
                        pos: num - 1
                    }, function (evt) {
                        trocarFoto(evt.data.DOM, evt.data.pos, false);
                    }).appendTo($indic);
                } // Fim for
            } // Fim if
        } // Fim if


        // Miniaturas ----------------------------------------------------------------------------------------------- //
        if (opcoes.minis) {
            $minis.appendTo($th).find('> .foto')
                .on('click.' + evt_ns, {DOM: $th}, function (evt) {
                    trocarFoto(evt.data.DOM, $(this).index(), false);
                }).find('> .infos').remove();
        } // Fim if


        // Tecla ESC ------------------------------------------------------------------------------------------------ //
        if (opcoes.teclaesc) {
            $(window).on('keyup.' + evt_ns, {DOM: $th}, function (evt) {
                var kc = evt.keyCode || evt.charCode || evt.which;

                if (kc === 27) {
                    evt.data.DOM.fadeOut('fast');
                } // Fim if
            });
        } // Fim if


        // Botão fechar --------------------------------------------------------------------------------------------- //
        if (opcoes.botaofechar) {
            $(document.createElement('button')).attr('type', 'button').addClass('btn-fechar').text('Fechar')
                .on('click.' + evt_ns, {DOM: $th}, function (evt) {
                    evt.data.DOM.fadeOut('fast', function () {
                        $(this).remove();
                    });
                }).appendTo($th);
        } // Fim if


        // Configurar a auto-troca ---------------------------------------------------------------------------------- //
        if (opcoes.autotroca.ativar) {
            window.setInterval(function () {
                trocarFoto($th, $th.find(seletor_foto + ':visible').index() + 1, true);
            }, opcoes.autotroca.tempo);
        } // Fim if
    };
})(jQuery);
