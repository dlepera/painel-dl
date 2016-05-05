-- Criar a permissão para editar configurações dos álbuns de fotos
INSERT INTO dl_painel_modulos_funcs (func_modulo, func_modulo_descr, func_modulo_classe) VALUES
    (7, 'Editar as configurações dos álbuns de fotos', 'WebSite\\Controle\\AlbumConfig');

SET @MODULO = last_insert_id();

INSERT INTO dl_painel_funcs_metodos (metodo_func, metodo_func_descr) VALUES
    (@MODULO, 'mostrarForm'),
    (@MODULO, 'salvar');

INSERT INTO dl_painel_grupos_funcs (grupo_usuario_id, func_modulo_id)
    SELECT grupo_usuario_id, @MODULO FROM dl_painel_grupos_usuarios;


-- Criar estrutura de configurações dos álbuns na tabela de configurações do site
ALTER TABLE dl_site_configuracoes ADD COLUMN configuracao_album_tema VARCHAR(100) NOT NULL DEFAULT 'galeria-2';
ALTER TABLE dl_site_configuracoes ADD COLUMN configuracao_album_fotow INT NOT NULL DEFAULT 400;
ALTER TABLE dl_site_configuracoes ADD COLUMN configuracao_album_fotoh INT NOT NULL DEFAULT 400;
ALTER TABLE dl_site_configuracoes ADD COLUMN configuracao_album_miniw INT NOT NULL DEFAULT 200;
ALTER TABLE dl_site_configuracoes ADD COLUMN configuracao_album_minih INT NOT NULL DEFAULT 200;


-- Incluir as imagens alternativas no registro da foto
ALTER TABLE dl_site_albuns_fotos ADD COLUMN foto_album_foto VARCHAR(200) NOT NULL AFTER foto_album_imagem;
ALTER TABLE dl_site_albuns_fotos ADD COLUMN foto_album_mini VARCHAR(200) NOT NULL AFTER foto_album_foto;

UPDATE dl_site_albuns_fotos SET
    foto_album_foto = REPLACE(foto_album_imagem, '/original/', '/fotos/'),
    foto_album_mini = REPLACE(foto_album_imagem, '/original/', '/mini/');


-- Incluir a opção de definir uma página mestra para um layout específico
ALTER TABLE dl_painel_temas ADD COLUMN tema_pagina_mestra VARCHAR(100) NOT NULL DEFAULT 'padrao' AFTER tema_diretorio;


-- Incluir campo _agente nos logs de registro
ALTER TABLE dl_painel_registros_logs ADD COLUMN log_registro_agente VARCHAR(200) NOT NULL;

-- Inclusão de CONSTRAINT no campo _status da tabela dl_painel_usuarios_recuperacoes
ALTER  TABLE dl_painel_usuarios_recuperacoes ADD CONSTRAINT CK_recuperacao_status CHECK (recuperacao_status IN('S', 'E', 'R'));

-- Aumentar tamanho do campo '_descr' na tabela 'dl_painel_funcs_metodos'
ALTER TABLE dl_painel_funcs_metodos MODIFY metodo_func_descr VARCHAR(30) NOT NULL;