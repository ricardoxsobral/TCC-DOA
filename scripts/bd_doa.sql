CREATE DATABASE IF NOT EXISTS bd_doa 
	CHARACTER SET = utf8 
	COLLATE = utf8_general_ci;

USE bd_doa;

CREATE TABLE tb_categoria (
	cd_categoria VARCHAR(5) NOT NULL,
	nm_categoria VARCHAR(20) NOT NULL, 
	PRIMARY KEY (cd_categoria)
);

CREATE TABLE tb_usuario (
	cd_usuario INT(11) NOT NULL AUTO_INCREMENT,
	cd_telefone VARCHAR(11) NOT NULL,
	ds_email VARCHAR(100) NOT NULL,
	ds_senha VARCHAR(60) NOT NULL,
	dt_ultimo_acesso TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ic_ativo TINYINT(1) NOT NULL DEFAULT 1,
	nm_cidade VARCHAR(50) NOT NULL,
	nm_usuario VARCHAR(100) NOT NULL,
	qt_reputacao SMALLINT(6) NOT NULL DEFAULT 0,
	sg_estado CHAR(2) NOT NULL,
	vl_reputacao SMALLINT(6) NOT NULL DEFAULT 0,
	cd_cookie VARCHAR(100) NULL,
	cd_recuperacao VARCHAR(64) NULL,
	dt_atualizacao TIMESTAMP NULL,
	dt_verificacao TIMESTAMP NULL,
	ic_banido TINYINT(1) NULL,
	dt_nascimento DATE NOT NULL,
	cd_cep INT(9) NOT NULL,
	ds_bairro VARCHAR(30) NOT NULL,
	ds_rua VARCHAR(50) NOT NULL,
	nm_img VARCHAR(200) NOT NULL,
	cd_cpf CHAR(11) NULL,
	cd_cnpj CHAR(14) NULL, 
    PRIMARY KEY (cd_usuario)
);

INSERT INTO tb_usuario (cd_telefone, ds_email, ds_senha, nm_cidade, nm_usuario, sg_estado, dt_nascimento, cd_cep, ds_bairro, ds_rua, nm_img, cd_cpf) VALUES
	('62988579218', 'geraldo@email.com', 'teste', 'São Vicente', 'Geraldo João Yuri Almeida', 'SP', '2021-06-23', 00000000, 'A', 'A', 'profile__default-picture.png', 00000000000), 
	('5127500641', 'vitoria@email.com', 'teste', 'Santos', 'Vitória Tânia Emily Caldeira', 'SP', '2021-06-23', 11111111, 'B', 'B', 'profile__default-picture.png', 11111111111), 
    ('84994261168', 'joaquim@email.com', 'teste', 'Praia Grande', 'Joaquim Oliver Mateus Nascimento', 'SP', '2021-06-23', 22222222, 'C', 'C', 'profile__default-picture.png', 22222222222);

CREATE TABLE tb_itens (
	cd_item INT(11) NOT NULL AUTO_INCREMENT,
	cd_usuario INT(11) NOT NULL,
	nm_anuncio VARCHAR(100) NOT NULL,
	ds_descricaoitem VARCHAR(1000) NOT NULL,
	ds_tipo VARCHAR(20) NOT NULL,
	ds_condicao VARCHAR(20) NOT NULL,
	nm_img VARCHAR(1000) NOT NULL,
	dt_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ic_ativo TINYINT(1) NOT NULL DEFAULT 1,
	ic_instituicao TINYINT(1) NULL,
	ic_solicitacao TINYINT(1) NULL,
	qt_solicitacao TINYINT(1) NOT NULL DEFAULT 0,
    qt_max_solicitacao TINYINT(1) NOT NULL DEFAULT 1,
	dt_atualizacao TIMESTAMP NULL, 
    dt_conclusao TIMESTAMP NULL, 
	PRIMARY KEY (cd_item), 
	CONSTRAINT fk_usuario_anuncio
		FOREIGN KEY (cd_usuario)
		REFERENCES tb_usuario (cd_usuario)
);

CREATE TABLE tb_imagem (
	cd_imagem INT(11) NOT NULL AUTO_INCREMENT,
	cd_anuncio INT(11) NOT NULL, 
    PRIMARY KEY (cd_imagem), 
	CONSTRAINT fk_anuncio_imagem
		FOREIGN KEY (cd_anuncio)
		REFERENCES tb_itens (cd_item)
);

CREATE TABLE IF NOT EXISTS tb_solicitacao (
cd_solicitacao INT NOT NULL AUTO_INCREMENT, 
cd_item INT NOT NULL, 
cd_usuario INT NOT NULL, 
dt_conclusao TIMESTAMP NULL, 
PRIMARY KEY (cd_solicitacao), 
CONSTRAINT fk_item_solicitacao
	FOREIGN KEY (cd_item)
	REFERENCES tb_itens (cd_item), 
CONSTRAINT fk_doador_solicitacao
	FOREIGN KEY (cd_usuario)
	REFERENCES tb_usuario (cd_usuario)
);

CREATE TABLE tb_historico (
	cd_historico INT(11) NOT NULL AUTO_INCREMENT,
	cd_usuario INT(11) NOT NULL,
	cd_referencia INT(11) DEFAULT NULL,
	ds_historico VARCHAR(150) NOT NULL,
	dt_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ic_notificacao TINYINT(1) NOT NULL, 
    PRIMARY KEY (cd_historico), 
	CONSTRAINT fk_usuario_historico 
		FOREIGN KEY (cd_usuario)
		REFERENCES tb_usuario (cd_usuario),
	CONSTRAINT fk_solicitacao_historico 
		FOREIGN KEY (cd_referencia)
		REFERENCES tb_solicitacao (cd_solicitacao)
);

CREATE TABLE tb_denuncia (
	cd_denuncia INT(11) NOT NULL AUTO_INCREMENT,
	cd_categoria VARCHAR(5) NOT NULL,
	cd_denunciado INT(11) NOT NULL,
	cd_usuario INT(11) NOT NULL,
	dt_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	dt_atualizacao TIMESTAMP NULL DEFAULT NULL,
	ic_aprovada TINYINT(1) DEFAULT NULL,
	ic_banimento TINYINT(1) DEFAULT NULL, 
    PRIMARY KEY (cd_denuncia), 
	CONSTRAINT fk_categoria_denuncia
		FOREIGN KEY (cd_categoria)
		REFERENCES tb_categoria (cd_categoria), 
	CONSTRAINT fk_usuario_denuncia
		FOREIGN KEY (cd_usuario)
		REFERENCES tb_usuario (cd_usuario), 
	CONSTRAINT fk_denunciado_denuncia
		FOREIGN KEY (cd_denunciado)
		REFERENCES tb_usuario (cd_usuario)
);

CREATE TABLE tb_anuncio_salvo (
	cd_salvo INT(11) NOT NULL,
	cd_anuncio INT(11) NOT NULL,
	cd_usuario INT(11) NOT NULL, 
    PRIMARY KEY (cd_salvo), 
	CONSTRAINT fk_anuncio_salvo
		FOREIGN KEY (cd_anuncio)
		REFERENCES tb_itens (cd_item), 
	CONSTRAINT fk_usuario_anuncio_salvo
		FOREIGN KEY (cd_usuario)
		REFERENCES tb_usuario (cd_usuario)
);

CREATE TABLE IF NOT EXISTS tb_notificacao (
	cd_notificacao INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	cd_tipo CHAR(1) NOT NULL, 
    ic_concluida BIT(1) NULL, 
	cd_solicitacao INT NOT NULL, 
	cd_usuario INT NOT NULL, 
	dt_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	ic_visualizado BIT(1) NOT NULL DEFAULT false, 
	PRIMARY KEY (cd_notificacao), 
	CONSTRAINT fk_solicitacao_notificacao
		FOREIGN KEY (cd_solicitacao)
		REFERENCES tb_solicitacao (cd_solicitacao), 
	CONSTRAINT fk_usuario_notificacao
		FOREIGN KEY (cd_usuario)
		REFERENCES tb_usuario (cd_usuario)
);