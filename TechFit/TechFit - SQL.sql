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
    id_cliente INT NOT NULL,
    id_funcionario INT NOT NULL,
    peso_cliente DECIMAL(5,2),
    altura_cliente DECIMAL(4,2),
    data_avaliacao DATE NOT NULL,
    descricao VARCHAR(255)
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
    status_agendamento VARCHAR(20) DEFAULT 'Agendado',
    id_cliente INT NOT NULL,
    id_aula INT NOT NULL
);

ALTER TABLE avaliacao_fisica
ADD CONSTRAINT fk_avaliacao_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
ADD CONSTRAINT fk_avaliacao_funcionario FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario);

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

ALTER TABLE agendamento
ADD CONSTRAINT fk_agendamento_cliente FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente),
ADD CONSTRAINT fk_agendamento_aula FOREIGN KEY (id_aula) REFERENCES aula(id_aula);

INSERT INTO cliente (nome_cliente, cpf_cliente, data_nascimento, email_cliente, telefone_cliente, senha_cliente) VALUES
('Ana Souza', '111.111.111-11', '1990-01-01', 'ana@email.com', '11999990001', 'a1111'),
('Bruno Lima', '222.222.222-22', '1985-02-02', 'bruno@email.com', '11999990002', 'b2222'),
('Carla Dias', '333.333.333-33', '1992-03-03', 'carla@email.com', '11999990003', 'c3333'),
('Daniel Silva', '444.444.444-44', '1995-04-04', 'daniel@email.com', '11999990004', 'd4444'),
('Eduarda Costa', '555.555.555-55', '1998-05-05', 'eduarda@email.com', '11999990005', 'e5555'),
('Felipe Santos', '666.666.666-66', '1993-06-06', 'felipe@email.com', '11999990006', 'f6666'),
('Gabriela Alves', '777.777.777-77', '1996-07-07', 'gabriela@email.com', '11999990007', 'g7777'),
('Henrique Rocha', '888.888.888-88', '1991-08-08', 'henrique@email.com', '11999990008', 'h8888'),
('Isabela Torres', '999.999.999-99', '1994-09-09', 'isabela@email.com', '11999990009', 'i9999'),
('João Pereira', '000.000.000-00', '1997-10-10', 'joao@email.com', '11999990010', 'j0000');

INSERT INTO funcionario (nome_funcionario, cpf_funcionario, cargo, salario, carga_horaria, email_funcionario, telefone_funcionario, senha_funcionario) VALUES
('adm1', '123.456.789-00', 'Instrutor', 2500.00, 40.00, 'adm1@email.com', '11988880001', '1234'),
('Patrícia Silva', '234.567.890-11', 'Recepcionista', 1800.00, 36.00, 'patricia@email.com', '11988880002', 'b1234'),
('Rafael Costa', '345.678.901-22', 'Personal Trainer', 3000.00, 44.00, 'rafael@email.com', '11988880003', 'c1234'),
('Camila Souza', '456.789.012-33', 'Instrutora', 2500.00, 40.00, 'camila@email.com', '11988880004', 'd1234'),
('Lucas Oliveira', '567.890.123-44', 'Gerente', 4000.00, 44.00, 'lucas@email.com', '11988880005', 'e1234'),
('Fernanda Gomes', '678.901.234-55', 'Faxineira', 1500.00, 30.00, 'fernanda@email.com', '11988880006', 'f1234'),
('Gustavo Santos', '789.012.345-66', 'Instrutor', 2500.00, 40.00, 'gustavo@email.com', '11988880007', 'g1234'),
('Amanda Rocha', '890.123.456-77', 'Recepcionista', 1800.00, 36.00, 'amanda@email.com', '11988880008', 'h1234'),
('Pedro Nunes', '901.234.567-88', 'Personal Trainer', 3000.00, 44.00, 'pedro@email.com', '11988880009', 'i1234'),
('Juliana Almeida', '012.345.678-99', 'Instrutora', 2500.00, 40.00, 'juliana@email.com', '11988880010', 'j1234');

INSERT INTO suporte (descricao, categoria, status_suporte) VALUES
('Problema com catraca', 'Equipamento', 'ativo'),
('Falha no sistema', 'TI', 'ativo'),
('Limpeza urgente', 'Serviços Gerais', 'ativo'),
('Lâmpada queimada', 'Manutenção', 'ativo'),
('Chuveiro quebrado', 'Vestiário', 'ativo'),
('Problema no ar-condicionado', 'Infraestrutura', 'ativo'),
('Torneira vazando', 'Manutenção', 'ativo'),
('Falta de toalhas', 'Serviços Gerais', 'ativo'),
('Bebedouro sem água', 'Infraestrutura', 'ativo'),
('Problema no Wi-Fi', 'TI', 'ativo');

INSERT INTO plano (nome_plano, preco, descricao) VALUES
('Básico', 99.90, 'Acesso livre à academia'),
('Intermediário', 149.90, 'Acesso + aulas coletivas'),
('Premium', 199.90, 'Acesso total + personal'),
('Duo', 179.90, 'Plano para 2 pessoas'),
('Família', 299.90, 'Plano para até 4 pessoas'),
('Estudante', 89.90, 'Desconto para estudantes'),
('Senior', 79.90, 'Desconto para idosos'),
('Mensal Flex', 129.90, 'Mensalidade flexível'),
('Semestral', 499.90, 'Plano de 6 meses'),
('Anual', 899.90, 'Plano de 12 meses');

INSERT INTO filiais (cnpj, endereco) VALUES
('11.111.111/0001-11', 'Av. Laranjeiras, 1200 – Jardim Nova Itália'),
('22.222.222/0001-22', 'Rua Barão de Campinas, 85 – Centro'),
('33.333.333/0001-33', 'Rua Tiradentes, 450 – Jardim do Lago'),
('44.444.444/0001-44', 'Av. Costa e Silva, 1020 – Vila São João'),
('55.555.555/0001-55', 'Rua Pedro Zaccaria, 699 – Parque Egisto Ragazzo'),
('66.666.666/0001-66', 'Av. Campinas, 1600 – Vila Camargo'),
('77.777.777/0001-77', 'Rua Luiz Pântano, 233 – Jardim Nova Europa'),
('88.888.888/0001-88', 'Av. Maestro Xixxá, 510 – Cecap'),
('99.999.999/0001-99', 'Rua Paschoal Marmo, 1420 – Jardim Morro Azul'),
('00.000.000/0001-00', 'Av. Maria Thereza, 780 – Parque Egisto Ragazzo'),
('12.345.678/0001-01', 'Rua Santa Cruz, 410 – Centro'),
('23.456.789/0001-02', 'Rua Humberto de Campos, 900 – Vila Cláudia'),
('34.567.890/0001-03', 'Av. Lauro Corrêa da Silva, 2100 – Jardim Novo Horizonte'),
('45.678.901/0001-04', 'Rua João Simões, 370 – Vila Independência'),
('56.789.012/0001-05', 'Rua Prefeito Dr. Alberto Ferreira, 520 – Boa Vista');


INSERT INTO aula (modalidade, data_hora) VALUES
('Yoga', 'Segunda - 14:00'),
('Spinning', 'Sexta - 19:00'),
('Crossfit', 'Quinta - 15:00'),
('Pilates', 'Quinta - 18:00'),
('Zumba', 'Terça - 13:40'),
('Boxe', 'Quarta - 19:00'),
('Funcional', 'Segunda - 16:30'),
('Step', 'Terça - 17:00'),
('Alongamento', 'Sexta - 16:00'),
('Dança', 'Quinta - 14:00');

INSERT INTO treino (nome_treino, dias, descricao) VALUES
('Iniciante', 2, 'Treino leve de musculação'),
('Intermediario', 3, 'Treino intermediário'),
('Avancado', 5, 'Treino avançado'),
('Rendimento', 4, 'Cardio rápido'),
('Resistência', 3, 'Treino de resistência'),
('Funcional', 3, 'Treino funcional'),
('Força', 4, 'Treino de força'),
('Emagrecimento', 5, 'Treino para emagrecimento'),
('Alto rendimento', 3, 'Treino de alto rendimento'),
('Regenerativo', 2, 'Treino regenerativo');

INSERT INTO avaliacao_fisica (data_avaliacao, descricao, id_cliente, id_funcionario, peso_cliente, altura_cliente) VALUES
('2025-10-01', 'Avaliação inicial', 1, 1, 70.00, 1.75),
('2025-10-02', 'Avaliação inicial', 2, 2, 80.00, 1.80),
('2025-10-03', 'Avaliação inicial', 3, 3, 65.00, 1.65),
('2025-10-04', 'Avaliação inicial', 4, 4, 90.00, 1.85),
('2025-10-05', 'Avaliação inicial', 5, 5, 75.00, 1.70),
('2025-10-06', 'Avaliação inicial', 6, 6, 85.00, 1.78),
('2025-10-07', 'Avaliação inicial', 7, 7, 68.00, 1.72),
('2025-10-08', 'Avaliação inicial', 8, 8, 95.00, 1.90),
('2025-10-09', 'Avaliação inicial', 9, 9, 78.00, 1.76),
('2025-10-10', 'Avaliação inicial', 10, 10, 82.00, 1.82);

INSERT INTO agendamento (status_agendamento, id_cliente, id_aula) VALUES
('Agendado', 1, 1),
('Agendado', 2, 2),
('Agendado', 3, 3),
('Agendado', 4, 4),
('Agendado', 5, 5),
('Agendado', 6, 6),
('Agendado', 7, 7),
('Agendado', 8, 8),
('Agendado', 9, 9),
('Agendado', 10, 10);