use curriculo_db;

create table if not exists dados_pessoais (
Nome VARCHAR(50) not null,
cargo VARCHAR(20) not null,
resumo VARCHAR(100) null,
info_principal VARCHAR(250) not null,
imagem VARCHAR(200) DEFAULT 'https://cdn-icons-png.flaticon.com/512/12225/12225881.png' null
);

create table if not exists contatos (
email VARCHAR(50) not null,
telefone VARCHAR(20) not null,
link VARCHAR(100) null
);

create table if not exists experiencias (
Empresa VARCHAR(25) not null,
funcao VARCHAR(20) not null,
periodo VARCHAR(20) not null,
descricao VARCHAR(250) null
);

create table if not exists formacao (
Instituicao VARCHAR(25) not null,
curso VARCHAR(20) not null,
periodo VARCHAR(20) not null
);

show tables;