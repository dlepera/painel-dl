SET FOREIGN_KEY_CHECKS=0;

-- Formatos de data
TRUNCATE TABLE dl_painel_formatos_data;
INSERT INTO dl_painel_formatos_data (formato_data_descr, formato_data_completo, formato_data_data, formato_data_hora)
VALUES ('dd/mm/aaaa hh:mm', 'd/m/Y H:i', 'd/m/Y', 'H:i'),
    ('mm/dd/aaaa hh:mm', 'm/d/Y H:i', 'm/d/Y', 'H:i'),
    ('aaaa/mm/dd hh:mm:ss', 'Y/m/d H:i:s', 'Y/m/d', 'H:i:s');

-- Cadastro de idiomas
TRUNCATE TABLE dl_painel_idiomas;
INSERT INTO dl_painel_idiomas (idioma_descr, idioma_sigla)
VALUES ('Português (Brasil)', 'pt_BR'),
    ('Inglês (USA)', 'en_US'),
    ('Espanhol', 'es_ES');

-- Cadastro de temas
TRUNCATE TABLE dl_painel_temas;
INSERT INTO dl_painel_temas (tema_descr, tema_diretorio, tema_padrao)
VALUES ('Painel-DL 3.2', 'painel-dl3', 1);

-- Grupos de usuários
TRUNCATE TABLE dl_painel_grupos_usuarios;
INSERT INTO dl_painel_grupos_usuarios (grupo_usuario_descr)
VALUES ('Administradores'), ('Editores do website'), ('Desenvolvedores');

-- Usuários
TRUNCATE TABLE dl_painel_usuarios;
INSERT INTO dl_painel_usuarios (usuario_info_grupo, usuario_info_nome, usuario_info_email, usuario_info_telefone, usuario_info_sexo, usuario_info_login, usuario_info_senha, usuario_pref_idioma, usuario_pref_tema, usuario_pref_formato_data, usuario_pref_num_registros, usuario_pref_exibir_id, usuario_pref_filtro_menu, usuario_conf_bloq, usuario_conf_reset, usuario_perfil_foto, usuario_ultimo_login)
VALUES (1, 'Administrador', 'admin@diegolepera.xyz', '(00) 0000-0000', 'M', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 1, 1, 1, 20, 1, 1, 0, 0, 'web/imgs/usuario-sem-foto.png', NULL);

-- Módulos
TRUNCATE TABLE dl_painel_modulos;
INSERT INTO dl_painel_modulos (modulo_pai, modulo_nome, modulo_descr, modulo_menu, modulo_link, modulo_ordem) VALUES
    (null, 'Admin', '', 1, 'admin', 98),
    (null, 'Website', '', 1, 'website', 0),
    (null, 'Desenvolvedor', 'Área para desenvolvedores adicionarem módulos, temas e pacote de idiomas.', 1, 'desenvolvedor', 99);

-- Submódulos
-- DECLARE @ID AS INT;
SET @ID = (SELECT modulo_id FROM dl_painel_modulos WHERE modulo_nome = 'Admin' AND modulo_pai IS NULL);

INSERT INTO dl_painel_modulos (modulo_pai, modulo_nome, modulo_descr, modulo_menu, modulo_link, modulo_ordem)
    VALUES (@ID, 'Usuários', 'Gerenciar contas de usuário.', 1, 'admin/usuarios', 0),
    (@ID, 'Grupos de usuários', 'Gerenciar grupos de usuários e suas permissões.', 1, 'admin/grupos-de-usuarios', 0),
    (@ID, 'Envio de e-mails', 'Configuração SMTP para envios de e-mails através do sistema.', 1, 'admin/envio-de-emails', 0);

SET @ID = (SELECT modulo_id FROM dl_painel_modulos WHERE modulo_nome = 'Website' AND modulo_pai IS NULL);

INSERT INTO dl_painel_modulos (modulo_pai, modulo_nome, modulo_descr, modulo_menu, modulo_link, modulo_ordem) VALUES (@ID, 'Álbuns de fotos', 'Incluir, editar e remover álbuns de fotos para o site.', 1, 'website/albuns-de-fotos', 0),
    (@ID, 'Dados para contato', 'Dados para entrar em contato com o proprietário do site.', 1, 'website/dados-para-contato', 0),
    (@ID, 'Contatos recebidos', 'Lista com todos os contatos recebidos através do formulário do web-site.', 1, 'website/contatos-recebidos', 0),
    (@ID, 'Assuntos de contatos', 'Assuntos que são exibidos no formulário de contato. São utilizados para categorizar  os contatos recebidos, podendo encaminhar cada assunto para um e-mail específico.', 1, 'website/assuntos-contato', 0),
    (@ID, 'Google Analytics', 'Configurações do Google Analytics.', 0, 'website/google-analytics', 0),
    (@ID, 'Tipos de dados para contato', 'Tipos de dados para contato. Redes sociais, e-mails, telefones, etc.', 0, 'website/tipos-de-dados', 0),
    (@ID, 'Institucional', 'Informações instiucionais sobre a empresa: história, missão, visão e valores.', 1, 'website/institucional', 0),
    (@ID, 'Configurações do website', 'Define algumas configurções para o website, como tema, formato para as data, entre outros.', 1, 'website/configuracoes', 0);

SET @ID = (SELECT modulo_id FROM dl_painel_modulos WHERE modulo_nome = 'Desenvolvedor' AND modulo_pai IS NULL);

INSERT INTO dl_painel_modulos (modulo_pai, modulo_nome, modulo_descr, modulo_menu, modulo_link, modulo_ordem)
VALUES (@ID, 'Temas', 'Gerenciar temas do Painel-DL instalados.', 1, 'desenvolvedor/temas', 0),
    (@ID, 'Módulos', 'Gerenciar módulos instalados, ou informar novos módulos do Painel-DL.', 1, 'desenvolvedor/modulos', 0),
    (@ID, 'Idiomas', 'Informar pacotes de idiomas instalados.', 1, 'desenvolvedor/idiomas', 0);

-- Cadastro de assuntos de contatos
INSERT INTO dl_site_assuntos_contato (assunto_contato_descr, assunto_contato_email) VALUES
    ('Dúvida', 'contato@diegolepera.xyz'),
    ('Sugestão', 'contato@diegolepera.xyz'),
    ('Reclamação', 'contato@diegolepera.xyz'),
    ('Elogio', 'contato@diegolepera.xyz');

-- Cadastro de redes sociais
INSERT INTO dl_site_dados_contato_tipos (tipo_dado_nome, tipo_dado_exibicao, tipo_dado_rede_social, tipo_dado_mascara, tipo_dado_expreg, tipo_dado_exemplo) VALUES
    ('Facebook', 'Facebook', 1, NULL, 'http(s)?://(wwww.)?facebook.com/[A-Za-z0-9_\-]{1,}', 'https://facebook.com/dlepera88'),
    ('Twitter', 'Twitter', 1, NULL, 'http(s)?://(wwww.)?twitter.com/[A-Za-z0-9_\-]{1,}', 'https://twitter.com/dlepera88'),
    ('Instagram', 'Instagram', 1, NULL, 'http(s)?://(wwww.)?instagram.com/[A-Za-z0-9_\-]{1,}/?', 'https://instagram.com/d_lepera/'),
    ('Youtube', 'Youtube', 1, NULL, 'http(s)?://(wwww.)?youtube.com(.br)?/channel/A-Za-z0-9_\-]{1,}', 'https://youtube.com/channel/dlepera88');

-- Cadastro de tipos de dados para contato
INSERT INTO dl_site_dados_contato_tipos (tipo_dado_nome, tipo_dado_exibicao, tipo_dado_mascara, tipo_dado_expreg, tipo_dado_exemplo) VALUES
    ('Telefone fixo', 'Telefone', '(##) ####-####', '\([0-9]{2}\)\s[0-9]{4}\-[0-9]{4}', '(11) 2334-0000'),
    ('Celular c/ 8 dígitos', 'Celular', '(##) ####-####', '\([0-9]{2}\)\s[6-9]{1}[0-9]{3}\-[0-9]{4}', '(11) 9123-0000'),
    ('Celular c/ 9 dígitos', 'Celular', '(##) # ####-####', '\([0-9]{2}\)\s[6-9]{1}\s[0-9]{4}\-[0-9]{4}', '(11) 9 4123-0000'),
    ('E-mail', 'E-mail', NULL, NULL, 'contato@diegolepera.xyz');

-- Inclusão das configurações padrão do website
INSERT INTO dl_site_configuracoes (configuracao_tema, configuracao_formato_data) VALUE (1, 1);

SET FOREIGN_KEY_CHECKS=1;