CREATE DATABASE db_gestao;
USE db_gestao;

CREATE TABLE tb_usuario(
    id_usuario INT AUTO_INCREMENT,
    nm_usuario VARCHAR(45),
    nm_login VARCHAR(45),
    ds_senha VARCHAR(45),
    ds_foto VARCHAR(100),
    PRIMARY KEY (id_usuario)
);

CREATE TABLE tb_categoria(
    id_categoria INT AUTO_INCREMENT,
    nm_categoria VARCHAR(45),
    PRIMARY KEY (id_categoria)
);

CREATE TABLE tb_produto(
    id_produto INT AUTO_INCREMENT,
    nm_produto VARCHAR(45),
    ds_produto VARCHAR(200),
    vl_produto DECIMAL(10,2),
    id_categoria INT,
    id_usuario INT,
    PRIMARY KEY (id_produto),
    FOREIGN KEY (id_categoria) REFERENCES tb_categoria(id_categoria),
    FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario)
);

CREATE TABLE tb_foto(
    id_foto INT AUTO_INCREMENT,
    nm_foto VARCHAR(200),
    id_produto INT,
    PRIMARY KEY (id_foto),
    FOREIGN KEY (id_produto) REFERENCES tb_produto(id_produto)
);
