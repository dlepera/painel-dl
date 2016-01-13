SET FOREIGN_KEY_CHECKS=0;

-- ---------------------------------------------------------------------------------------------------------------------
-- Logs de registros
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_registros_logs;
CREATE TABLE dl_painel_registros_logs (
    log_registro_id INT NOT NULL AUTO_INCREMENT,
    log_registro_tabela VARCHAR(30) NOT NULL,
    log_registro_regpk VARCHAR(30) NOT NULL,
    log_registro_acao CHAR(1) DEFAULT 'A' NOT NULL,
    log_registro_data DATETIME NOT NULL,
    log_registro_usuario INT,
    log_registro_nome VARCHAR(50),
    log_registro_ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (log_registro_id),
    CONSTRAINT CK_log_registro_acao CHECK( log_registro_acao IN('A', 'E', 'X') )
    -- A => Registro "A"dicionado
    -- E => Registro "E"ditado
    -- X => Registro e"X"cluído
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Envio de e-mails
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_email_config;
CREATE TABLE dl_painel_email_config (
    config_email_id INT NOT NULL AUTO_INCREMENT,
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
    config_email_html TINYINT(1) DEFAULT 1 NOT NULL,
    config_email_principal TINYINT(1) DEFAULT 0 NOT NULL,
    config_email_debug TINYINT(1) DEFAULT 0 NOT NULL,
    config_email_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (config_email_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_email_logs;
CREATE TABLE dl_painel_email_logs (
    log_email_id INT NOT NULL AUTO_INCREMENT,
    log_email_config INT,
    log_email_ip VARCHAR(80) NOT NULL,
    log_email_classe VARCHAR(80) NOT NULL,
    log_email_tabela VARCHAR(80) NOT NULL,
    log_email_idreg INT,
    log_email_status CHAR(1) DEFAULT 'S' NOT NULL,
    log_email_mensagem TEXT,
    PRIMARY KEY (log_email_id),
    CONSTRAINT FK_log_email_config FOREIGN KEY (log_email_config) REFERENCES dl_painel_email_config (config_email_id),
    CONSTRAINT CK_log_email_status CHECK ( log_email_status IN ('S', 'E', 'F') )
    -- S => Solicitado
    -- E => Enviado
    -- F => Falha
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Preferências de usuários
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_formatos_data;
CREATE TABLE dl_painel_formatos_data (
    formato_data_id INT NOT NULL AUTO_INCREMENT,
    formato_data_descr VARCHAR(20) NOT NULL,
    formato_data_completo VARCHAR(20) NOT NULL,
    formato_data_data VARCHAR(10) NOT NULL,
    formato_data_hora VARCHAR(10) NOT NULL,
    formato_data_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    formato_data_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (formato_data_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_idiomas;
CREATE TABLE dl_painel_idiomas (
    idioma_id INT NOT NULL AUTO_INCREMENT,
    idioma_descr VARCHAR(20) NOT NULL,
    idioma_sigla VARCHAR(5) NOT NULL,
    idioma_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    idioma_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (idioma_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_temas;
CREATE TABLE dl_painel_temas (
    tema_id INT NOT NULL AUTO_INCREMENT,
    tema_descr VARCHAR(20) NOT NULL,
    tema_diretorio VARCHAR(10) NOT NULL,
    tema_padrao TINYINT(1) DEFAULT 0 NOT NULL,
    tema_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    tema_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (tema_id)
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Módulos
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_modulos;
CREATE TABLE dl_painel_modulos (
    modulo_id INT NOT NULL AUTO_INCREMENT,
    modulo_pai INT,
    modulo_nome VARCHAR(30) NOT NULL,
    modulo_descr TEXT,
    modulo_menu TINYINT(1) DEFAULT 1 NOT NULL,
    modulo_link VARCHAR(100) NOT NULL,
    modulo_ordem INT DEFAULT 0 NOT NULL,
    modulo_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    modulo_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (modulo_id),
    CONSTRAINT FK_modulo_pai FOREIGN KEY (modulo_pai) REFERENCES dl_painel_modulos (modulo_id) ON DELETE SET NULL
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_modulos_funcs;
CREATE TABLE dl_painel_modulos_funcs (
    func_modulo INT NOT NULL,
    func_modulo_id INT NOT NULL AUTO_INCREMENT,
    func_modulo_descr VARCHAR(100) NOT NULL,
    func_modulo_classe VARCHAR(100) NOT NULL,
    func_modulo_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (func_modulo_id),
    CONSTRAINT FK_func_modulo FOREIGN KEY (func_modulo) REFERENCES dl_painel_modulos (modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_funcs_metodos;
CREATE TABLE dl_painel_funcs_metodos (
    metodo_func INT NOT NULL,
    metodo_func_id INT NOT NULL AUTO_INCREMENT,
    metodo_func_descr VARCHAR(20) NOT NULL,
    PRIMARY KEY (metodo_func_id),
    CONSTRAINT FK_metodo_func FOREIGN KEY (metodo_func) REFERENCES dl_painel_modulos_funcs (func_modulo_id) ON DELETE CASCADE
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Grupos de usuários
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_grupos_usuarios;
CREATE TABLE dl_painel_grupos_usuarios (
    grupo_usuario_id INT NOT NULL AUTO_INCREMENT,
    grupo_usuario_descr VARCHAR(30) NOT NULL,
    grupo_usuario_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    grupo_usuario_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (grupo_usuario_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_grupos_funcs;
CREATE TABLE dl_painel_grupos_funcs (
    grupo_usuario_id INT NOT NULL,
    func_modulo_id INT NOT NULL,
    PRIMARY KEY (grupo_usuario_id, func_modulo_id),
    CONSTRAINT FK_gfunc_modulo_id FOREIGN KEY (func_modulo_id) REFERENCES dl_painel_modulos_funcs (func_modulo_id) ON DELETE CASCADE,
    CONSTRAINT FK_fgrupo_usuario_id FOREIGN KEY (grupo_usuario_id) REFERENCES dl_painel_grupos_usuarios (grupo_usuario_id) ON DELETE CASCADE
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Usuários
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_painel_usuarios;
CREATE TABLE dl_painel_usuarios (
    usuario_id INT NOT NULL AUTO_INCREMENT,
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
    usuario_pref_exibir_id TINYINT(1) DEFAULT 1 NOT NULL,
    usuario_pref_filtro_menu TINYINT(1) DEFAULT 0 NOT NULL,
    usuario_conf_bloq TINYINT(1) DEFAULT 0 NOT NULL,
    usuario_conf_reset TINYINT(1) DEFAULT 0 NOT NULL,
    usuario_perfil_foto VARCHAR(255),
    usuario_ultimo_login DATETIME,
    usuario_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (usuario_id),
    UNIQUE KEY UQ_usuario_info_email (usuario_info_email),
    UNIQUE KEY UQ_usuario_info_login (usuario_info_login),
    CONSTRAINT FK_usuario_info_grupo FOREIGN KEY (usuario_info_grupo) REFERENCES dl_painel_grupos_usuarios (grupo_usuario_id),
    CONSTRAINT FK_usuario_pref_formato_data FOREIGN KEY (usuario_pref_formato_data) REFERENCES dl_painel_formatos_data (formato_data_id),
    CONSTRAINT FK_usuario_pref_idioma FOREIGN KEY (usuario_pref_idioma) REFERENCES dl_painel_idiomas (idioma_id),
    CONSTRAINT FK_usuario_pref_tema FOREIGN KEY (usuario_pref_tema) REFERENCES dl_painel_temas (tema_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_painel_usuarios_recuperacoes;
CREATE TABLE dl_painel_usuarios_recuperacoes (
    recuperacao_id INT NOT NULL AUTO_INCREMENT,
    recuperacao_usuario INT NOT NULL,
    recuperacao_hash VARCHAR(32) NOT NULL,
    recuperacao_status CHAR(1) DEFAULT 'S',
    PRIMARY KEY (recuperacao_id),
    UNIQUE KEY UQ_recuperacao_hash (recuperacao_hash),
    CONSTRAINT FK_recuperacao_usuario FOREIGN KEY (recuperacao_usuario) REFERENCES dl_painel_usuarios (usuario_id) ON DELETE CASCADE,
    CONSTRAINT CK_recuperacao_status CHECK ( recuperacao_status IN ('S', 'R') )
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Álbuns de fotos
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_site_albuns;
CREATE TABLE dl_site_albuns (
    album_id INT NOT NULL AUTO_INCREMENT,
    album_nome VARCHAR(50) NOT NULL,
    album_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    album_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (album_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_albuns_fotos;
CREATE TABLE dl_site_albuns_fotos (
    foto_album INT NOT NULL,
    foto_album_id INT NOT NULL AUTO_INCREMENT,
    foto_album_titulo VARCHAR(50),
    foto_album_descr TEXT,
    foto_album_imagem TEXT NOT NULL,
    foto_album_capa TINYINT(1) DEFAULT 0 NOT NULL,
    foto_album_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    foto_album_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (foto_album_id),
    CONSTRAINT FK_foto_album FOREIGN KEY (foto_album) REFERENCES dl_site_albuns (album_id) ON DELETE CASCADE
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Contatos recebidos do site
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_site_assuntos_contato;
CREATE TABLE dl_site_assuntos_contato (
    assunto_contato_id INT NOT NULL AUTO_INCREMENT,
    assunto_contato_descr VARCHAR(80) NOT NULL,
    assunto_contato_email VARCHAR(100) NOT NULL,
    assunto_contato_cor VARCHAR(7) DEFAULT '#000' NOT NULL,
    assunto_contato_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    assunto_contato_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (assunto_contato_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_contatos;
CREATE TABLE dl_site_contatos (
    contato_site_id INT NOT NULL AUTO_INCREMENT,
    contato_site_nome VARCHAR(80) NOT NULL,
    contato_site_email VARCHAR(100) NOT NULL,
    contato_site_telefone VARCHAR(16),
    contato_site_assunto INT,
    contato_site_mensagem LONGTEXT NOT NULL,
    contato_site_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (contato_site_id),
    CONSTRAINT FK_contato_site_assunto FOREIGN KEY (contato_site_assunto) REFERENCES dl_site_assuntos_contato (assunto_contato_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_contatos_leitura;
CREATE TABLE dl_site_contatos_leitura (
    leitura_contato INT NOT NULL,
    leitura_contato_id INT NOT NULL AUTO_INCREMENT,
    leitura_contato_usuario INT NOT NULL,
    leitura_contato_data DATETIME NOT NULL,
    PRIMARY KEY (leitura_contato_id),
    UNIQUE KEY UQ_leitura_usuario (leitura_contato, leitura_contato_usuario),
    CONSTRAINT FK_leitura_contato FOREIGN KEY (leitura_contato) REFERENCES dl_site_contatos (contato_site_id) ON DELETE CASCADE
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Dados para contato
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_site_dados_contato_tipos;
CREATE TABLE dl_site_dados_contato_tipos (
    tipo_dado_id INT NOT NULL AUTO_INCREMENT,
    tipo_dado_nome VARCHAR(30) NOT NULL,
    tipo_dado_exibicao VARCHAR(30) NOT NULL,
    tipo_dado_icone VARCHAR(255),
    tipo_dado_rede_social TINYINT(1) DEFAULT 0 NOT NULL,
    tipo_dado_mascara VARCHAR(100),
    tipo_dado_expreg VARCHAR(200),
    tipo_dado_exemplo VARCHAR(200),
    tipo_dado_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    tipo_dado_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (tipo_dado_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_dados_contato;
CREATE TABLE dl_site_dados_contato (
    dado_contato_id INT NOT NULL AUTO_INCREMENT,
    dado_contato_tipo INT NOT NULL,
    dado_contato_descr VARCHAR(100) NOT NULL,
    dado_contato_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    dado_contato_delete TINYINT(1) DEFAULT 0 NOT NULL,
    PRIMARY KEY (dado_contato_id),
    UNIQUE KEY UQ_tipo_descr (dado_contato_tipo, dado_contato_descr),
    CONSTRAINT FK_dado_contato_tipo FOREIGN KEY (dado_contato_tipo) REFERENCES dl_site_dados_contato_tipos (tipo_dado_id)
) ENGINE=INNODB;


-- ---------------------------------------------------------------------------------------------------------------------
-- Configurações do website
-- ---------------------------------------------------------------------------------------------------------------------
DROP TABLE IF EXISTS dl_site_configuracoes;
CREATE TABLE dl_site_configuracoes (
    configuracao_id INT NOT NULL AUTO_INCREMENT,
    configuracao_tema INT DEFAULT 1 NOT NULL,
    configuracao_formato_data INT DEFAULT 1 NOT NULL,
    configuracao_email INT,
    PRIMARY KEY (configuracao_id),
    CONSTRAINT FK_configuracao_formato_data FOREIGN KEY (configuracao_formato_data) REFERENCES dl_painel_formatos_data (formato_data_id),
    CONSTRAINT FK_configuracao_tema FOREIGN KEY (configuracao_tema) REFERENCES dl_painel_temas (tema_id),
    CONSTRAINT FK_configuracao_email FOREIGN KEY (configuracao_email) REFERENCES dl_painel_email_config (config_email_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_google_analytics;
CREATE TABLE dl_site_google_analytics (
    ga_id INT NOT NULL AUTO_INCREMENT,
    ga_apelido VARCHAR(100),
    ga_usuario VARCHAR(100) NOT NULL,
    ga_p12 VARCHAR(200) NOT NULL,
    ga_perfil_id INT NOT NULL,
    ga_codigo_ua VARCHAR(15) NOT NULL,
    ga_principal TINYINT(1) DEFAULT 0 NOT NULL,
    ga_delete TINYINT(1) DEFAULT 0 NOT NULL,
    ga_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    PRIMARY KEY (ga_id)
) ENGINE=INNODB;

DROP TABLE IF EXISTS dl_site_institucional;
CREATE TABLE dl_site_institucional (
    instit_id INT NOT NULL AUTO_INCREMENT,
    instit_historia LONGTEXT,
    instit_missao LONGTEXT,
    instit_visao LONGTEXT,
    instit_valores LONGTEXT,
    instit_publicar TINYINT(1) DEFAULT 1 NOT NULL,
    PRIMARY KEY (instit_id)
) ENGINE=INNODB;

SET FOREIGN_KEY_CHECKS=1;