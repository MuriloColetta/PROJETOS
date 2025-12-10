CREATE DATABASE techfit;

USE techfit;

CREATE TABLE cliente (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(50) NOT NULL,
    cpf_cliente VARCHAR(14) NOT NULL,
    data_nascimento date NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefone_cliente VARCHAR(15) NOT NULL,
    senha_cliente VARCHAR(255) NOT NULL
);

CREATE TABLE funcionario (
    id_funcionario INT AUTO_INCREMENT PRIMARY KEY,
    nome_funcionario VARCHAR(50) NOT NULL,
    cpf_funcionario VARCHAR(14) NOT NULL,
    cargo VARCHAR(50) NOT NULL,
    salario DECIMAL(10,2) NOT NULL,
    carga_horaria DECIMAL(5,2),
    email_funcionario VARCHAR(100) NOT NULL,
    telefone_funcionario VARCHAR(15) NOT NULL,
    senha_funcionario VARCHAR(255) NOT NULL
);

CREATE TABLE suporte (
    id_suporte INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    status_suporte VARCHAR(10) DEFAULT 'ativo'
);

CREATE TABLE plano (
    id_plano INT AUTO_INCREMENT PRIMARY KEY,
    nome_plano VARCHAR(50) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    descricao VARCHAR(255) NOT NULL
);

CREATE TABLE filiais (
    id_filiais INT AUTO_INCREMENT PRIMARY KEY,
    cnpj VARCHAR(18) NOT NULL,
    endereco VARCHAR(255) NOT NULL
);

CREATE TABLE aula (
    id_aula INT AUTO_INCREMENT PRIMARY KEY,
    modalidade VARCHAR(50) NOT NULL,
    data_hora VARCHAR(50) NOT NULL
);

CREATE TABLE treino (
    id_treino INT AUTO_INCREMENT PRIMARY KEY,
    nome_treino VARCHAR(50),
    descricao VARCHAR(255) NOT NULL,
    dias INT NOT NULL
);

CREATE TABLE avaliacao_fisica (
    id_avaliacao INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    peso_cliente DECIMAL(5,2) NOT NULL,
    altura_cliente DECIMAL(4,2) NOT NULL,
    status_agendamento VARCHAR(50) DEFAULT "Agendado",
    data_avaliacao DATE NOT NULL
);

CREATE TABLE assinatura (
    id_cliente INT NOT NULL,
    id_plano INT NOT NULL,
    PRIMARY KEY (id_cliente, id_plano)
);

CREATE TABLE pertence (
    id_funcionario INT NOT NULL,
    id_filiais INT NOT NULL,
    PRIMARY KEY (id_funcionario, id_filiais)
);

CREATE TABLE tem (
    id_filiais INT NOT NULL,
    id_plano INT NOT NULL,
    PRIMARY KEY (id_filiais, id_plano)
);

CREATE TABLE possui (
    id_filiais INT NOT NULL,
    id_suporte INT NOT NULL,
    PRIMARY KEY (id_filiais, id_suporte)
);

CREATE TABLE usa (
    id_funcionario INT NOT NULL,
    id_treino INT NOT NULL,
    PRIMARY KEY (id_funcionario, id_treino)
);

CREATE TABLE acesso (
    id_acesso INT AUTO_INCREMENT PRIMARY KEY,
    data date NOT NULL,
    id_cliente INT NOT NULL,
    id_filiais INT NOT NULL
);

CREATE TABLE agendamento (
    id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    horario VARCHAR(50) NOT NULL,
    status_agendamento VARCHAR(50) DEFAULT "Agendado",
    data_agendamento DATE NOT NULL
);

ALTER TABLE assinatura
ADD CONSTRAINT fk_assinatura_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
ADD CONSTRAINT fk_assinatura_treino FOREIGN KEY (id_plano) REFERENCES treino(id_plano);

ALTER TABLE pertence
ADD CONSTRAINT fk_pertence_funcionario FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario),
ADD CONSTRAINT fk_pertence_filiais FOREIGN KEY (id_filiais) REFERENCES filiais(id_filiais);

ALTER TABLE tem
ADD CONSTRAINT fk_tem_filiais FOREIGN KEY (id_filiais) REFERENCES filiais(id_filiais),
ADD CONSTRAINT fk_tem_plano FOREIGN KEY (id_plano) REFERENCES plano(id_plano);

ALTER TABLE possui
ADD CONSTRAINT fk_possui_filiais FOREIGN KEY (id_filiais) REFERENCES filiais(id_filiais),
ADD CONSTRAINT fk_possui_suporte FOREIGN KEY (id_suporte) REFERENCES suporte(id_suporte);

ALTER TABLE usa
ADD CONSTRAINT fk_usa_funcionario FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario),
ADD CONSTRAINT fk_usa_treino FOREIGN KEY (id_treino) REFERENCES treino(id_treino);

ALTER TABLE acesso
ADD CONSTRAINT fk_acesso_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
ADD CONSTRAINT fk_acesso_filiais FOREIGN KEY (id_filiais) REFERENCES filiais(id_filiais);

insert into funcionario (nome_funcionario, cpf_funcionario, cargo, salario, carga_horaria, email_funcionario, telefone_funcionario, senha_funcionario) values
("admin", "987.654.321-00", "Gerente", 5000.00, 8, "admin@techfit.com", "(19) 98888-7777", "admin123");