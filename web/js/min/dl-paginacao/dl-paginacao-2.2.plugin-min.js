!function($){function t(){var t=window.location.search,a=/(pg)=([\d]*)*/i,n=a.exec(t);return null===n?1:parseInt(n[n.length-1])}function a(t){var a=window.location.toString(),n=window.location.search;a.indexOf("pg=")>-1?a=a.replace(/pg=\d+/,"pg="+t):a+=""===n?"?pg="+t:"&pg="+t,window.location=a}$.fn.paginacao=function(n,r){var e=$(this),o={pgatual:t(),pgtotal:10,exibir:5,loop:!0,mostrar:0,btn_numeros:!0,btn_primeira:!0,btn_ultima:!0,btn_proxima:!0,btn_anterior:!0,tema:"painel-dl"};n=$.extend(r===!0,{},o,n),null!==n.aparencia&&("function"==typeof carregarCSS&&carregarCSS("web/js/min/dl-paginacao/temas/"+n.tema+"/css/"+n.tema+".css"),e.addClass("__pg-plugin "+n.tema));var i={primeiro:"btn -prim",anterior:"btn -ant",proximo:"btn -prox",ultimo:"btn -ult",numerico:"btn -num",atual:"-pg-atual"},p="__pgn";if(n.pgtotal<2)return!1;if(n.btn_primeira&&$(document.createElement("a")).attr("href","javascript:").addClass(i.primeiro).on("click."+p,function(){a(1)}).text("|<<").appendTo(e),n.btn_anterior&&$(document.createElement("a")).attr("href","javascript:").addClass(i.anterior).on("click."+p,function(){if(1===n.pgatual){if(!n.loop)return!1;a(n.pgtotal)}else a(n.pgatual-1)}).text("<<").appendTo(e),n.btn_numeros){var l=Math.floor(n.mostrar/2),c=n.pgatual-l;c=1>c?1:c;var u=n.pgatual+(n.mostrar-l-1);for(u=u-c<n.mostrar?n.mostrar-(u-c)+u-1:u,u=u>n.pgtotal?n.pgtotal:u,u=c>u?n.pgtotal:u,c=c===u?1:c;u>=c;)$(document.createElement("a")).attr("href","javascript:").addClass(i.numerico+" "+(c===n.pgatual?i.atual:"")).text(c++).on("click."+p,function(){var t=parseInt($(this).text());return n.pgatual!==t?a(t):!1}).appendTo(e)}return n.btn_proxima&&$(document.createElement("a")).attr("href","javascript:").addClass(i.proximo).on("click."+p,function(){if(n.pgatual===n.pgtotal){if(!n.loop)return!1;a(1)}else a(n.pgatual+1)}).text(">>").appendTo(e),n.btn_ultima&&$(document.createElement("a")).attr("href","javascript:").addClass(i.ultimo).on("click."+p,function(){a(n.pgtotal)}).text(">>|").appendTo(e),e}}(jQuery);