function executarConfirm(a,o,t){return $("body")._msgconfirmacao({titulo:t||"Confirmação",mensagem:a,botao_sim:{texto:"Sim",classe:"btn-sim",funcao:function(){return o()}},botao_nao:{texto:"Não",classe:"btn-nao btn-principal",funcao:function(){return!1}}}),!0}function verificarAlteracao(a){var o=$(a),t=o.attr("value"),c=o.val();o.attr("data-alterado",(t!==c)+0)}function confirmarSubmit(a,o){var t=$(a),c=t.parents("form"),r=t.data("acao-param-msg");c[0].checkValidity()&&(o.stopPropagation(),o.preventDefault(),executarConfirm(r,function(){c.find(":submit").off(".__acao").trigger("click").on("click.__acao",function(a){confirmarSubmit(this,a)})},"Confirmar ação"))}$("#dl3-logout").on("click",function(){void 0===$logout?console.warn("Formulário de logout não localizado!"):$logout.trigger("submit")}),$('[data-acao="publicar-registro"], [data-acao="ocultar-registro"]').on("click.__acao",function(){var a=$(this);selecionarLinha(this,!0),alternarPublicacao(a.data("acao-param-dir"))}),$('[data-acao="excluir-registro"]').on("click.__acao",function(){var a=this;return executarConfirm("Deseja realmente excluir esse(s) registro(s)?",function(){selecionarLinha(a,!0),$el.submit()},"Confirmar exclusão")}),$('[data-acao="testar-email"]').on("click.__acao",function(){var a=$(this);$el.executar(a.data("acao-param-dir"),null,function(){return null})}),$('[data-acao="bloquear-usuarios"], [data-acao="desbloquear-usuarios"]').on("click",function(){var a=$(this);selecionarLinha(this,!0),$el.executar(a.data("acao-param-dir"),null,function(){window.location.reload()},!1)}),$('[data-acao="carregar-html"]').on("click.__acao",function(){var a=$(this);carregarHTML(a.data("acao-param-html"),"html")}),$('[data-acao="carregar-form"]').on("click.__acao",function(){var $th=$(this),func=$th.data("acao-param-func")||"window.location.reload()";carregarForm($th.data("acao-param-html"),"form",function(){eval("("+func+")")})}),$('[data-verificar-alteracao="1"]').on("change.__acao",function(){verificarAlteracao(this)}),$('[data-acao="confirmar-submit"]').on("click.__acao",function(a){confirmarSubmit(this,a)}),$("[data-mask]").each(function(){var a=$(this);a.mascara(a.data("mask"))}),$('[data-acao="criar-funcionalidades"]').on("click.__acao",function(){var a=$(this),o=a.data("acao-param-pk");$.ajax({url:"desenvolvedor/modulos/editar/"+o+"/criar-funcionalidades-padrao",dataType:"json",success:function(a){a=a[a.length-1],$("body").mostrarMsg({mensagem:a.mensagem,tipo:["__msg-alerta",a.tipo],botoes:[{texto:"x",classe:"btn-principal",funcao:function(){window.location.reload()}}]})}})});