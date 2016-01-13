-- ---------------------------------------------------------------------------------------------------------------------
-- Logs de registros
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_registros_logs', 'U') IS NOT NULL
    DROP TABLE dl_painel_registros_logs;
GO

CREATE TABLE dl_painel_registros_logs (
    log_registro_id INT NOT NULL IDENTITY ,
    log_registro_tabela VARCHAR(30) NOT NULL,
    log_registro_regpk VARCHAR(30) NOT NULL,
    log_registro_acao CHAR(1) DEFAULT 'A' NOT NULL,
    log_registro_data DATETIME2 NOT NULL,
    log_registro_usuario INT,
    log_registro_nome VARCHAR(50),
    log_registro_ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (log_registro_id),
    CONSTRAINT CK_log_registro_acao CHECK( log_registro_acao IN('A', 'E', 'X') )
    -- A => Registro "A"dicionado
    -- E => Registro "E"ditado
    -- X => Registro e"X"cluído
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Envio de e-mails
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_email_config', 'U') IS NOT NULL
    DROP TABLE dl_painel_email_config;
GO

CREATE TABLE dl_painel_email_config (
    config_email_id INT NOT NULL IDENTITY,
    config_email_titulo VARCHAR(30) NOT NULL,
    config_email_host VARCHAR(80) NOT NULL,
    config_email_porta INT DEFAULT 25 NOT NULL,
    config_email_autent INT NOT NULL,
    config_email_cripto VARCHAR(5) NOT NULL,
    config_email_conta VARCHAR(100),
    config_email_senha VARCHAR(100),
    config_email_de_email VARCHAR(100),
    config_email_de_nome VARCHAR(100),
    config_email_responder_para VARCHAR(100),
    config_email_html TINYINT DEFAULT 1 NOT NULL,
    config_email_principal TINYINT DEFAULT 0 NOT NULL,
    config_email_debug TINYINT DEFAULT 0 NOT NULL,
    config_email_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (config_email_id)
)
GO

IF OBJECT_ID('dl_painel_email_logs', 'U') IS NOT NULL
    DROP TABLE dl_painel_email_logs;
GO

CREATE TABLE dl_painel_email_logs (
    log_email_id INT NOT NULL IDENTITY,
    log_email_config INT,
    log_email_ip VARCHAR(80) NOT NULL,
    log_email_classe VARCHAR(80) NOT NULL,
    log_email_tabela VARCHAR(80) NOT NULL,
    log_email_idreg INT,
    log_email_status CHAR(1) DEFAULT 'S' NOT NULL,
    log_email_mensagem VARCHAR(1000),
    PRIMARY KEY (log_email_id),
    CONSTRAINT FK_log_email_config FOREIGN KEY (log_email_config) REFERENCES dl_painel_email_config (config_email_id),
    CONSTRAINT CK_log_email_status CHECK ( log_email_status IN ('S', 'E', 'F') )
    -- S => Solicitado
    -- E => Enviado
    -- F => Falha
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Preferências de usuários
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_formatos_data', 'U') IS NOT NULL
    DROP TABLE dl_painel_formatos_data;
GO

CREATE TABLE dl_painel_formatos_data (
    formato_data_id INT NOT NULL IDENTITY,
    formato_data_descr VARCHAR(20) NOT NULL,
    formato_data_completo VARCHAR(20) NOT NULL,
    formato_data_data VARCHAR(10) NOT NULL,
    formato_data_hora VARCHAR(10) NOT NULL,
    formato_data_publicar TINYINT DEFAULT 1 NOT NULL,
    formato_data_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (formato_data_id)
)
GO

IF OBJECT_ID('dl_painel_idiomas', 'U') IS NOT NULL
    DROP TABLE dl_painel_idiomas;
GO

CREATE TABLE dl_painel_idiomas (
    idioma_id INT NOT NULL IDENTITY,
    idioma_descr VARCHAR(20) NOT NULL,
    idioma_sigla VARCHAR(5) NOT NULL,
    idioma_publicar TINYINT DEFAULT 1 NOT NULL,
    idioma_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (idioma_id)
)
GO

IF OBJECT_ID('dl_painel_temas', 'U') IS NOT NULL
    DROP TABLE dl_painel_temas;
GO

CREATE TABLE dl_painel_temas (
    tema_id INT NOT NULL IDENTITY,
    tema_descr VARCHAR(20) NOT NULL,
    tema_diretorio VARCHAR(10) NOT NULL,
    tema_padrao TINYINT DEFAULT 0 NOT NULL,
    tema_publicar TINYINT DEFAULT 1 NOT NULL,
    tema_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (tema_id)
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Módulos
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_modulos', 'U') IS NOT NULL
    DROP TABLE dl_painel_modulos;
GO

CREATE TABLE dl_painel_modulos (
    modulo_id INT NOT NULL IDENTITY,
    modulo_pai INT,
    modulo_nome VARCHAR(30) NOT NULL,
    modulo_descr VARCHAR(1000),
    modulo_menu TINYINT DEFAULT 1 NOT NULL,
    modulo_link VARCHAR(100) NOT NULL,
    modulo_ordem INT DEFAULT 0 NOT NULL,
    modulo_publicar TINYINT DEFAULT 1 NOT NULL,
    modulo_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (modulo_id),
    CONSTRAINT FK_modulo_pai FOREIGN KEY (modulo_pai) REFERENCES dl_painel_modulos (modulo_id) ON DELETE SET NULL
)
GO

IF OBJECT_ID('dl_painel_modulos_funcs', 'U') IS NOT NULL
    DROP TABLE dl_painel_modulos_funcs;
GO

CREATE TABLE dl_painel_modulos_funcs (
    func_modulo INT NOT NULL,
    func_modulo_id INT NOT NULL IDENTITY,
    func_modulo_descr VARCHAR(100) NOT NULL,
    func_modulo_classe VARCHAR(100) NOT NULL,
    func_modulo_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (func_modulo_id),
    CONSTRAINT FK_func_modulo FOREIGN KEY (func_modulo) REFERENCES dl_painel_modulos (modulo_id) ON DELETE CASCADE
)
GO

IF OBJECT_ID('dl_painel_funcs_metodos', 'U') IS NOT NULL
    DROP TABLE dl_painel_funcs_metodos;
GO

CREATE TABLE dl_painel_funcs_metodos (
    metodo_func INT NOT NULL,
    metodo_func_id INT NOT NULL IDENTITY,
    metodo_func_descr VARCHAR(20) NOT NULL,
    PRIMARY KEY (metodo_func_id),
    CONSTRAINT FK_metodo_func FOREIGN KEY (metodo_func) REFERENCES dl_painel_modulos_funcs (func_modulo_id) ON DELETE CASCADE
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Grupos de usuários
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_grupos_usuarios', 'U') IS NOT NULL
    DROP TABLE dl_painel_grupos_usuarios;
GO

CREATE TABLE dl_painel_grupos_usuarios (
    grupo_usuario_id INT NOT NULL IDENTITY,
    grupo_usuario_descr VARCHAR(30) NOT NULL,
    grupo_usuario_publicar TINYINT DEFAULT 1 NOT NULL,
    grupo_usuario_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (grupo_usuario_id)
)
GO

IF OBJECT_ID('dl_painel_grupos_funcs', 'U') IS NOT NULL
    DROP TABLE dl_painel_grupos_funcs;
GO

CREATE TABLE dl_painel_grupos_funcs (
    grupo_usuario_id INT NOT NULL,
    func_modulo_id INT NOT NULL,
    PRIMARY KEY (grupo_usuario_id, func_modulo_id),
    CONSTRAINT FK_gfunc_modulo_id FOREIGN KEY (func_modulo_id) REFERENCES dl_painel_modulos_funcs (func_modulo_id) ON DELETE CASCADE,
    CONSTRAINT FK_fgrupo_usuario_id FOREIGN KEY (grupo_usuario_id) REFERENCES dl_painel_grupos_usuarios (grupo_usuario_id) ON DELETE CASCADE
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Usuários
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_painel_usuarios', 'U') IS NOT NULL
    DROP TABLE dl_painel_usuarios;
GO

CREATE TABLE dl_painel_usuarios (
    usuario_id INT NOT NULL IDENTITY,
    usuario_info_grupo INT NOT NULL,
    usuario_info_nome VARCHAR(50) NOT NULL,
    usuario_info_email VARCHAR(100) NOT NULL,
    usuario_info_telefone VARCHAR(16),
    usuario_info_sexo CHAR(1) NOT NULL,
    usuario_info_login VARCHAR(20) NOT NULL,
    usuario_info_senha VARCHAR(32) NOT NULL,
    usuario_pref_idioma INT DEFAULT 1 NOT NULL,
    usuario_pref_tema INT DEFAULT 1 NOT NULL,
    usuario_pref_formato_data INT DEFAULT 1 NOT NULL,
    usuario_pref_num_registros INT DEFAULT 20 NOT NULL,
    usuario_pref_exibir_id TINYINT DEFAULT 1 NOT NULL,
    usuario_pref_filtro_menu TINYINT DEFAULT 0 NOT NULL,
    usuario_conf_bloq TINYINT DEFAULT 0 NOT NULL,
    usuario_conf_reset TINYINT DEFAULT 0 NOT NULL,
    usuario_perfil_foto VARCHAR(255),
    usuario_ultimo_login DATETIME2,
    usuario_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (usuario_id),
    UNIQUE (usuario_info_email),
    UNIQUE (usuario_info_login),
    CONSTRAINT FK_usuario_info_grupo FOREIGN KEY (usuario_info_grupo) REFERENCES dl_painel_grupos_usuarios (grupo_usuario_id),
    CONSTRAINT FK_usuario_pref_formato_data FOREIGN KEY (usuario_pref_formato_data) REFERENCES dl_painel_formatos_data (formato_data_id),
    CONSTRAINT FK_usuario_pref_idioma FOREIGN KEY (usuario_pref_idioma) REFERENCES dl_painel_idiomas (idioma_id),
    CONSTRAINT FK_usuario_pref_tema FOREIGN KEY (usuario_pref_tema) REFERENCES dl_painel_temas (tema_id)
)
GO

IF OBJECT_ID('dl_painel_usuarios_recuperacoes', 'U') IS NOT NULL
    DROP TABLE dl_painel_usuarios_recuperacoes;
GO

CREATE TABLE dl_painel_usuarios_recuperacoes (
    recuperacao_id INT NOT NULL IDENTITY,
    recuperacao_usuario INT NOT NULL,
    recuperacao_hash VARCHAR(32) NOT NULL,
    recuperacao_status CHAR(1) DEFAULT 'S',
    PRIMARY KEY (recuperacao_id),
    UNIQUE (recuperacao_hash),
    CONSTRAINT FK_recuperacao_usuario FOREIGN KEY (recuperacao_usuario) REFERENCES dl_painel_usuarios (usuario_id) ON DELETE CASCADE,
    CONSTRAINT CK_recuperacao_status CHECK ( recuperacao_status IN ('S', 'R') )
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Álbuns de fotos
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_site_albuns', 'U') IS NOT NULL
    DROP TABLE dl_site_albuns;
GO

CREATE TABLE dl_site_albuns (
    album_id INT NOT NULL IDENTITY,
    album_nome VARCHAR(50) NOT NULL,
    album_publicar TINYINT DEFAULT 1 NOT NULL,
    album_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (album_id)
)
GO

IF OBJECT_ID('dl_site_albuns_fotos', 'U') IS NOT NULL
    DROP TABLE dl_site_albuns_fotos;
GO

CREATE TABLE dl_site_albuns_fotos (
    foto_album INT NOT NULL,
    foto_album_id INT NOT NULL IDENTITY,
    foto_album_titulo VARCHAR(50),
    foto_album_descr VARCHAR(1000),
    foto_album_imagem VARCHAR(1000) NOT NULL,
    foto_album_capa TINYINT DEFAULT 0 NOT NULL,
    foto_album_publicar TINYINT DEFAULT 1 NOT NULL,
    foto_album_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (foto_album_id),
    CONSTRAINT FK_foto_album FOREIGN KEY (foto_album) REFERENCES dl_site_albuns (album_id) ON DELETE CASCADE
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Contatos recebidos do site
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_site_assuntos_contato', 'U') IS NOT NULL
    DROP TABLE dl_site_assuntos_contato;
GO

CREATE TABLE dl_site_assuntos_contato (
    assunto_contato_id INT NOT NULL IDENTITY,
    assunto_contato_descr VARCHAR(80) NOT NULL,
    assunto_contato_email VARCHAR(100) NOT NULL,
    assunto_contato_cor VARCHAR(7) DEFAULT '#000' NOT NULL,
    assunto_contato_publicar TINYINT DEFAULT 1 NOT NULL,
    assunto_contato_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (assunto_contato_id)
)
GO

IF OBJECT_ID('dl_site_contatos', 'U') IS NOT NULL
    DROP TABLE dl_site_contatos;
GO

CREATE TABLE dl_site_contatos (
    contato_site_id INT NOT NULL IDENTITY,
    contato_site_nome VARCHAR(80) NOT NULL,
    contato_site_email VARCHAR(100) NOT NULL,
    contato_site_telefone VARCHAR(16),
    contato_site_assunto INT,
    contato_site_mensagem VARCHAR(1000) NOT NULL,
    contato_site_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (contato_site_id),
    CONSTRAINT FK_contato_site_assunto FOREIGN KEY (contato_site_assunto) REFERENCES dl_site_assuntos_contato (assunto_contato_id)
)
GO

IF OBJECT_ID('dl_site_contatos_leitura', 'U') IS NOT NULL
    DROP TABLE dl_site_contatos_leitura;
GO

CREATE TABLE dl_site_contatos_leitura (
    leitura_contato INT NOT NULL,
    leitura_contato_id INT NOT NULL IDENTITY,
    leitura_contato_usuario INT NOT NULL,
    leitura_contato_data DATETIME2 NOT NULL,
    PRIMARY KEY (leitura_contato_id),
    UNIQUE (leitura_contato, leitura_contato_usuario),
    CONSTRAINT FK_leitura_contato FOREIGN KEY (leitura_contato) REFERENCES dl_site_contatos (contato_site_id) ON DELETE CASCADE
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Dados para contato
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_site_dados_contato_tipos', 'U') IS NOT NULL
    DROP TABLE dl_site_dados_contato_tipos;
GO

CREATE TABLE dl_site_dados_contato_tipos (
    tipo_dado_id INT NOT NULL IDENTITY,
    tipo_dado_nome VARCHAR(30) NOT NULL,
    tipo_dado_exibicao VARCHAR(30) NOT NULL,
    tipo_dado_icone VARCHAR(255),
    tipo_dado_rede_social TINYINT DEFAULT 0 NOT NULL,
    tipo_dado_mascara VARCHAR(100),
    tipo_dado_expreg VARCHAR(200),
    tipo_dado_exemplo VARCHAR(200),
    tipo_dado_publicar TINYINT DEFAULT 1 NOT NULL,
    tipo_dado_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (tipo_dado_id)
)
GO

IF OBJECT_ID('dl_site_dados_contato', 'U') IS NOT NULL
    DROP TABLE dl_site_dados_contato;
GO

CREATE TABLE dl_site_dados_contato (
    dado_contato_id INT NOT NULL IDENTITY,
    dado_contato_tipo INT NOT NULL,
    dado_contato_descr VARCHAR(100) NOT NULL,
    dado_contato_publicar TINYINT DEFAULT 1 NOT NULL,
    dado_contato_delete TINYINT DEFAULT 0 NOT NULL,
    PRIMARY KEY (dado_contato_id),
    UNIQUE (dado_contato_tipo, dado_contato_descr),
    CONSTRAINT FK_dado_contato_tipo FOREIGN KEY (dado_contato_tipo) REFERENCES dl_site_dados_contato_tipos (tipo_dado_id)
)
GO


-- ---------------------------------------------------------------------------------------------------------------------
-- Configurações do website
-- ---------------------------------------------------------------------------------------------------------------------
IF OBJECT_ID('dl_site_configuracoes', 'U') IS NOT NULL
    DROP TABLE dl_site_configuracoes;
GO

CREATE TABLE dl_site_configuracoes (
    configuracao_id INT NOT NULL IDENTITY,
    configuracao_tema INT DEFAULT 1 NOT NULL,
    configuracao_formato_data INT DEFAULT 1 NOT NULL,
    configuracao_email INT,
    PRIMARY KEY (configuracao_id),
    CONSTRAINT FK_configuracao_formato_data FOREIGN KEY (configuracao_formato_data) REFERENCES dl_painel_formatos_data (formato_data_id),
    CONSTRAINT FK_configuracao_tema FOREIGN KEY (configuracao_tema) REFERENCES dl_painel_temas (tema_id),
    CONSTRAINT FK_configuracao_email FOREIGN KEY (configuracao_email) REFERENCES dl_painel_email_config (config_email_id)
)
GO

IF OBJECT_ID('dl_site_google_analytics', 'U') IS NOT NULL
    DROP TABLE dl_site_google_analytics;
GO

CREATE TABLE dl_site_google_analytics (
    ga_id INT NOT NULL IDENTITY,
    ga_apelido VARCHAR(100),
    ga_usuario VARCHAR(100) NOT NULL,
    ga_p12 VARCHAR(200) NOT NULL,
    ga_perfil_id INT NOT NULL,
    ga_codigo_ua VARCHAR(15) NOT NULL,
    ga_principal TINYINT DEFAULT 0 NOT NULL,
    ga_delete TINYINT DEFAULT 0 NOT NULL,
    ga_publicar TINYINT DEFAULT 1 NOT NULL,
    PRIMARY KEY (ga_id)
)
GO

IF OBJECT_ID('dl_site_institucional', 'U') IS NOT NULL
    DROP TABLE dl_site_institucional;
GO

CREATE TABLE dl_site_institucional (
    instit_id INT NOT NULL IDENTITY,
    instit_historia VARCHAR(1000),
    instit_missao VARCHAR(1000),
    instit_visao VARCHAR(1000),
    instit_valores VARCHAR(1000),
    instit_publicar TINYINT DEFAULT 1 NOT NULL,
    PRIMARY KEY (instit_id)
)
GO