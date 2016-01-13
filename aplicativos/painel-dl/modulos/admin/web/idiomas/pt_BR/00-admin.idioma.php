<?php
/**
 * Created by PhpStorm.
 * User: dlepera
 * Date: 28/08/15
 * Time: 16:00
 */

// Modelos ---------------------------------------------------------------------------------------------------------- //
define('TXT_MODELO_GRUPOUSUARIO', 'grupo de usuário');
define('TXT_MODELO_USUARIO', 'usuário');
define('TXT_MODELO_CONFIGEMAIL', 'configuração de envio de email');
define('TXT_MODELO_TEMA', 'tema');
define('TXT_MODELO_IDIOMA', 'idioma');


// Páginas ---------------------------------------------------------------------------------------------------------- //
# -> Títulos
define('TXT_PAGINA_TITULO_GRUPOS_USUARIOS', 'Grupos de usuários');
define('TXT_PAGINA_TITULO_USUARIOS', 'Usuários');
define('TXT_PAGINA_TITULO_CONFIGURACOES_ENVIO_EMAIL', 'Configurações de envio de e-mails');


// Links ------------------------------------------------------------------------------------------------------------ //
define('TXT_LINK_TESTAR_CONFIGURACAO', 'Testar configuração');

# -> Title
define('TXT_LINK_TITLE_TESTAR_CONFIGURACAO_EMAIL', 'Enviar e-mail de teste dessa configuração');


// Listas ----------------------------------------------------------------------------------------------------------- //
# -> Títulos
define('TXT_LISTA_TITULO_DESCR', 'Descrição');
define('TXT_LISTA_TITULO_GRUPO', 'Grupo');
define('TXT_LISTA_TITULO_NOME', 'Nome');
define('TXT_LISTA_TITULO_EMAIL', 'E-mail');
define('TXT_LISTA_TITULO', 'Título');
define('TXT_LISTA_TITULO_HOST', 'Host');
define('TXT_LISTA_TITULO_PRINCIPAL', 'Principal?');
define('TXT_LISTA_TITULO_BLOQUEADO', 'Bloqueado?');


// Formulários ------------------------------------------------------------------------------------------------------ //
# -> Legendas
define('TXT_LEGENDA_DADOS_PESSOAIS', 'Dados pessoais');
define('TXT_LEGENDA_PREFERENCIAS', 'Preferências');
define('TXT_LEGENDA_ACESSO_SISTEMA', 'Acesso ao sistema');
define('TXT_LEGENDA_SERVIDOR', 'Servidor SMTP');
define('TXT_LEGENDA_AUTENTICACAO', 'Autenticação');
define('TXT_LEGENDA_CONFIGURACOES_ENVIO', 'Configurações de envio');
define('TXT_LEGENDA_GRUPO', 'Grupo');
define('TXT_LEGENDA_MEMBROS', 'Membros');
define('TXT_LEGENDA_PERMISSOES', 'Permissões');

# -> Rótulos
define('TXT_ROTULO_DESCR', 'Descrição');
define('TXT_ROTULO_NOME', 'Nome');
define('TXT_ROTULO_EMAIL', 'E-mail');
define('TXT_ROTULO_TELEFONE', 'Telefone');
define('TXT_ROTULO_SEXO', 'Sexo');
define('TXT_ROTULO_IDIOMA', 'Idioma');
define('TXT_ROTULO_TEMA', 'Tema');
define('TXT_ROTULO_FORMATO_DATA', 'Formato de exibição de datas');
define('TXT_ROTULO_NUM_REGISTROS', 'Número de registros');
define('TXT_ROTULO_EXIBIR_ID', 'Exibir ID?');
define('TXT_ROTULO_FILTRO_MENU', 'Mostrar filtro do menu?');
define('TXT_ROTULO_GRUPO', 'Grupo');
define('TXT_ROTULO_LOGIN', 'Nome de usuário');
define('TXT_ROTULO_SENHA', 'Senha');
define('TXT_ROTULO_CONF_SENHA', 'Confirme a senha');
define('TXT_ROTULO_RESET', 'Resetar a senha no próximo login');
define('TXT_ROTULO_BLOQ', 'Bloquear login do usuário');
define('TXT_ROTULO_TITULO', 'Título');
define('TXT_ROTULO_HOST', 'Host');
define('TXT_ROTULO_REQUER_AUTENT', 'Requer autenticação?');
define('TXT_ROTULO_TIPO_CRIPTO', 'Tipo de criptografia');
define('TXT_ROTULO_CONTA', 'Conta');
define('TXT_ROTULO_DE_NOME', 'De (nome)');
define('TXT_ROTULO_DE_EMAIL', 'De (e-mail)');
define('TXT_ROTULO_RESPONDER_PARA', 'Responder para');
define('TXT_ROTULO_HTML', 'HTML?');
define('TXT_ROTULO_PRINCIPAL', 'Principal?');
define('TXT_ROTULO_SELECIONAR_TODOS', 'Selecionar todos');
define('TXT_ROTULO_DEBUG', 'Habilitar o debug?');
define('TXT_ROTULO_SENHA_NOVA', 'Nova senha');
define('TXT_ROTULO_SENHA_NOVA_CONF', 'Confirmar a nova senha');

# -> Dicas
define('TXT_DICA_EXIBIR_ID', 'Deseja ver o ID do registro nas listas?');
define('TXT_DICA_FILTRO_MENU', 'Mostra um filtro para localizar as opções do menu.');
define('TXT_DICA_USUARIO_RESET', 'Força o usuário a resetar sua senha imediatamente ao próximo login.');
define('TXT_DICA_USUARIO_BLOQ', 'Bloqueia a conta de usuário para fazer login no sistema.');
define('TXT_DICA_USUARIO_NUM_REGISTROS', 'Define a quantidade de registros a serem exibidos por página');
define('TXT_DICA_EMAIL_HTML', 'Quando essa opção é marcada, os e-mails são enviados em formato HTML. Do contrário, apenas texto puro, sem formatação.');
define('TXT_DICA_EMAIL_PRINCIPAL', 'Define qual configuração será usada para o envio quando mais de uma configuração for cadastrada no sistema.');
define('TXT_DICA_DEBUG', 'Habilitar o debugger do PHPMailer faz com que a classe exiba mensagens mais detalhadas para melhor compreensão de erros.');

# -> Exemplos
define('TXT_EXEMPLO_HOST_SMTP', 'Ex.: smtp.dominio.com.br');
define('TXT_EXEMPLO_EMAIL', 'Ex.: nome@dominio.com.br');

# -> Opções
define('TXT_OPCAO_MASCULINO', 'Masculino');
define('TXT_OPCAO_FEMININO', 'Feminino');
define('TXT_OPCAO_NENHUMA', 'Nenhuma');
define('TXT_OPCAO_TLS', 'TLS - Transport Layer Security');
define('TXT_OPCAO_SSL', 'SSL - Secure Socket Layer');


// Diversos --------------------------------------------------------------------------------------------------------- //
define('MSG_USUARIO_BLOQUEADO', '<b>Atenção:</b> Esse usuário está bloqueado e, portanto, não tem acesso ao sistema.');
define('MSG_USUARIO_ALTERAR_FOTO', 'Alterar foto');
define('TXT_DIVERSOS_CONFIRMAR_ALTERAR_SENHA', 'Você está prestes a alterar a sua senha e essa tarefa não poderá ser desfeita.<br/><br/>Deseja realmente continuar?');


// E-mails ---------------------------------------------------------------------------------------------------------- //
# -> Assuntos
define('TXT_EMAIL_ASSUNTO_TESTE', 'Teste de configuração');

# -> Conteúdos
define('TXT_EMAIL_CONTEUDO_TESTE', <<<HTML
Este é apenas um teste de configuração (%s).<br/>
SMTP: %s:%d<br/>
Origem: %s
HTML
);


// Classes ---------------------------------------------------------------------------------------------------------- //
/*
 * AdminM\Usuario()
 * AdminC\Usuario()
 */
# Sucessos
define('SUCESSO_USUARIO_ALTERARSENHA', 'Sua senha foi alterada com sucesso!');
define('SUCESSO_USUARIO_BLOQUEAR_UM', 'Usuário bloqueado com sucesso!');
define('SUCESSO_USUARIO_BLOQUEAR_VARIOS', 'Foram bloqueados %d usuários de um total de %d selecionados!');
define('SUCESSO_USUARIO_DESBLOQUEAR_UM', 'Usuário desbloqueado com sucesso!');
define('SUCESSO_USUARIO_DESBLOQUEAR_VARIOS', 'Foram desbloqueados %d usuários de um total de %d selecionados!');
define('SUCESSO_USUARIOS_SALVAR_FOTO', 'Foto de perfil salva com sucesso!');

# Erros
define('ERRO_USUARIO_ALTERARSENHA_USUARIO_NAO_ENCONTRADO', '<b>Erro ao tentar alterar sua senha</b><p>O usuário não foi localizado.</p>');
define('ERRO_USUARIO_ALTERARSENHA_SENHA_ATUAL_INCORRETA', '<b>Erro ao tentar alterar sua senha</b><p>A senha atual informada está incorreta.</p>');
define('ERRO_USUARIO_ALTERSENHA_SENHAS_NAO_COINCIDEM', '<b>Erro ao tentar alterar sua senha</b><p>As novas senhas informadas devem ser iguais.</p>');
define('ERRO_USUARIO_BLOQUEAR', '<b>Erro ao tentar bloquear o(s) usuário(s)</b><p>Nenhum usuário foi bloqueado.</p>');
define('ERRO_USUARIO_DESBLOQUEAR', '<b>Erro ao tentar desbloquear o(s) usuário(s)</b><p>Nenhum usuário foi desbloqueado.</p>');
define('ERRO_USUARIO_SALVAR_LOGIN_JA_CADASTRADO', '<b>Nome de usuário inválido!</b><p>O nome de usuário informado já está sendo usado.</p><p>Por favor, informe um nome de usuário diferente.</p>');
define('ERRO_USUARIO_SALVAR_EMAIL_JA_CADASTRADO', '<b>E-mail inválido!</b><p>O e-mail informado já está sendo usado por outro usuário.</p><p>Por favor, utilize um e-mail diferente.</p>');
define('ERRO_USUARIO_SALVAR_FOTO_OUTRO_USUARIO', 'Você não pode salvar fotos para o perfil de outro usuário!');
define('ERRO_USUARIO_VALIDAR_SENHA_IGUAL_LOGIN', 'A senha não pode ser igual ao nome de usuário utilizado pelo usuário!');


# -> AdminM\ConfigEmail()
# ->-> Sucessos
define('SUCESSO_CONFIGEMAIL_TESTAR', 'A configuração foi testada com sucesso!');

# ->-> Erros
define('ERRO_CONFIGEMAIL_TESTAR', 'Erro! A configuração não conseguiu enviar o e-mail de teste.<p>%s</p>');
define('ERRO_CONFIGEMAIL_SALVAR_INFORMAR_DADOS_CONTA', 'Essa configuração <b>Requer Autenticação</b>!<br/>Por favor, preencha as informações <b>Conta</b> e <b>Senha</b> para autenticar no servidor SMTP.');