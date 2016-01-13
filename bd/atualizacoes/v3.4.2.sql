-- Alterar os logs de registro
DROP TABLE dl_painel_registros_logs;
CREATE TABLE IF NOT EXISTS dl_painel_registros_logs(
    log_registro_id INT NOT NULL AUTO_INCREMENT,
    log_registro_tabela VARCHAR(30) NOT NULL,
    log_registro_regpk VARCHAR(30) NOT NULL,
    log_registro_acao CHAR(1) NOT NULL DEFAULT 'A',
    log_registro_data DATETIME NOT NULL,
    log_registro_usuario INT,
    log_registro_nome VARCHAR(50),
    log_registro_ip VARCHAR(15) NOT NULL,
    PRIMARY KEY (log_registro_id),
    CONSTRAINT CK_log_registro_acao CHECK ( log_registro_acao IN('A', 'E', 'X') )
) ENGINE=INNODB;


-- Corrigir logs de e-mail
ALTER TABLE dl_painel_email_logs MODIFY log_email_classe VARCHAR(80) NOT NULL;
ALTER TABLE dl_painel_email_logs MODIFY log_email_tabela VARCHAR(80) NOT NULL;

-- Não permitir dados para contato repetidos
ALTER TABLE dl_site_dados_contato ADD CONSTRAINT UQ_tipo_descr UNIQUE KEY (dado_contato_tipo, dado_contato_descr);

-- Corrigir configurações de e-mails
ALTER TABLE dl_painel_email_config MODIFY config_email_conta VARCHAR(100) NULL;
ALTER TABLE dl_painel_email_config MODIFY config_email_senha VARCHAR(100) NULL;


-- Ajuste dos nomes dos método na tabela de permissionamento
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'mostrarLista' WHERE metodo_func_descr = '_mostrarlista';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'mostrarForm' WHERE metodo_func_descr = '_mostrarform';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'mostrarDetalhes' WHERE metodo_func_descr = '_mostrardetalhes';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'salvar' WHERE metodo_func_descr = '_salvar';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'remover' WHERE metodo_func_descr = '_remover';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'alterarSenha' WHERE metodo_func_descr = '_alterarsenha';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'alternarPublicacao' WHERE metodo_func_descr = '_alternarpublicacao';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'bloquear' WHERE metodo_func_descr = '_bloquear';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'formAlterarSenha' WHERE metodo_func_descr = '_formalterarsenha';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'minhaConta' WHERE metodo_func_descr = '_minhaconta';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'mostrarInfo' WHERE metodo_func_descr = '_mostrarinfos';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'formAlterarSenha' WHERE metodo_func_descr = '_formalterarsenha';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'salvarFoto' WHERE metodo_func_descr = '_salvarfoto';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'testar' WHERE metodo_func_descr = '_testar';
UPDATE dl_painel_funcs_metodos SET metodo_func_descr = 'upload' WHERE metodo_func_descr = '_ipload';


-- Incluir opção "Configuração de e-mail" para as configurações do website
ALTER TABLE dl_site_configuracoes ADD configuracao_email INT;
ALTER TABLE dl_site_configuracoes ADD CONSTRAINT FK_configuracao_email FOREIGN KEY (configuracao_email) REFERENCES dl_painel_email_config(config_email_id);


-- Incluir o campo "DICA" no cadastro do tipo de dado para contato
ALTER TABLE dl_site_dados_contato_tipos CHANGE tipo_dado_descr tipo_dado_nome VARCHAR(30) NOT NULL;
ALTER TABLE dl_site_dados_contato_tipos ADD tipo_dado_exibicao VARCHAR(30) NOT NULL;
ALTER TABLE dl_site_dados_contato_tipos ADD tipo_dado_exemplo VARCHAR(200) AFTER tipo_dado_expreg;