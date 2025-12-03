create database techfit;

use techfit;

create table cliente (
    id_cliente int auto_increment primary key,
    nome_cliente varchar(50) not null,
    cpf_cliente varchar(14) not null,
    data_nascimento date not null,
    email_cliente varchar(100) not null,
    telefone_cliente varchar(15) not null,
    senha_cliente varchar(255) not null
);

create table funcionario (
    id_funcionario int auto_increment primary key,
    nome_funcionario varchar(50) not null,
    cpf_funcionario varchar(14) not null,
    cargo varchar(50) not null,
    salario decimal(10,2) not null,
    carga_horaria decimal(5,2),
    email_funcionario varchar(100) not null,
    telefone_funcionario varchar(15) not null,
    senha_funcionario varchar(255) not null
);

create table suporte (
    id_suporte int auto_increment primary key,
    descricao varchar(255) not null,
    categoria varchar(50) not null,
    status_suporte varchar(10) default 'ativo'
);

create table plano (
    id_plano int auto_increment primary key,
    nome_plano varchar(50) not null,
    preco decimal(10,2) not null,
    descricao varchar(255) not null
);

create table filiais (
    id_filiais int auto_increment primary key,
    cnpj varchar(18) not null,
    endereco varchar(255) not null
);

create table aula (
    id_aula int auto_increment primary key,
    modalidade varchar(50) not null,
    data_hora varchar(50) not null
);

create table treino (
    id_treino int auto_increment primary key,
    descricao varchar(255) not null,
    dias int not null
);

create table avaliacao_fisica (
    id_avaliacao int auto_increment primary key,
    id_cliente int not null,
    id_funcionario int not null,
    data date not null,
    descricao varchar(255)
);

create table faz (
    id_cliente int not null,
    id_treino int not null,
    primary key (id_cliente, id_treino)
);

create table pertence (
    id_funcionario int not null,
    id_filiais int not null,
    primary key (id_funcionario, id_filiais)
);

create table tem (
    id_filiais int not null,
    id_plano int not null,
    primary key (id_filiais, id_plano)
);

create table possui (
    id_filiais int not null,
    id_suporte int not null,
    primary key (id_filiais, id_suporte)
);

create table usa (
    id_funcionario int not null,
    id_treino int not null,
    primary key (id_funcionario, id_treino)
);

create table acesso (
    id_acesso int auto_increment primary key,
    data date not null,
    id_cliente int not null,
    id_filiais int not null
);

create table agendamento (
    id_agendamento int auto_increment primary key,
    status_agendamento varchar(20),
    id_cliente int not null,
    id_aula int not null
);

alter table avaliacao_fisica
add constraint fk_avaliacao_cliente foreign key (id_cliente) references cliente(id_cliente),
add constraint fk_avaliacao_funcionario foreign key (id_funcionario) references funcionario(id_funcionario);

alter table faz
add constraint fk_faz_cliente foreign key (id_cliente) references cliente(id_cliente),
add constraint fk_faz_treino foreign key (id_treino) references treino(id_treino);

alter table pertence
add constraint fk_pertence_funcionario foreign key (id_funcionario) references funcionario(id_funcionario),
add constraint fk_pertence_filiais foreign key (id_filiais) references filiais(id_filiais);

alter table tem
add constraint fk_tem_filiais foreign key (id_filiais) references filiais(id_filiais),
add constraint fk_tem_plano foreign key (id_plano) references plano(id_plano);

alter table possui
add constraint fk_possui_filiais foreign key (id_filiais) references filiais(id_filiais),
add constraint fk_possui_suporte foreign key (id_suporte) references suporte(id_suporte);

alter table usa
add constraint fk_usa_funcionario foreign key (id_funcionario) references funcionario(id_funcionario),
add constraint fk_usa_treino foreign key (id_treino) references treino(id_treino);

alter table acesso
add constraint fk_acesso_cliente foreign key (id_cliente) references cliente(id_cliente),
add constraint fk_acesso_filiais foreign key (id_filiais) references filiais(id_filiais);

alter table agendamento
add constraint fk_agendamento_cliente foreign key (id_cliente) references cliente(id_cliente),
add constraint fk_agendamento_aula foreign key (id_aula) references aula(id_aula);

insert into cliente (nome_cliente, cpf_cliente, data_nascimento, email_cliente, telefone_cliente, senha_cliente) values
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

insert into funcionario (nome_funcionario, cpf_funcionario, cargo, salario, carga_horaria, email_funcionario, telefone_funcionario, senha_funcionario) values
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

insert into suporte (descricao, categoria, status_suporte) values
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

insert into plano (nome_plano, preco, descricao) values
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


insert into aula (modalidade, data_hora) values
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

insert into treino (dias, descricao) values
(2, 'Treino leve de musculação'),
(3, 'Treino intermediário'),
(5, 'Treino avançado'),
(4, 'Cardio rápido'),
(3, 'Treino de resistência'),
(3, 'Treino funcional'),
(4, 'Treino de força'),
(5, 'Treino para emagrecimento'),
(3, 'Treino de alto rendimento'),
(2, 'Treino regenerativo');

insert into avaliacao_fisica (data, descricao, id_cliente, id_funcionario) values
('2025-10-01', 'Avaliação inicial', 1, 1),
('2025-10-02', 'Avaliação inicial', 2, 2),
('2025-10-03', 'Avaliação inicial', 3, 3),
('2025-10-04', 'Avaliação inicial', 4, 4),
('2025-10-05', 'Avaliação inicial', 5, 5),
('2025-10-06', 'Avaliação inicial', 6, 6),
('2025-10-07', 'Avaliação inicial', 7, 7),
('2025-10-08', 'Avaliação inicial', 8, 8),
('2025-10-09', 'Avaliação inicial', 9, 9),
('2025-10-10', 'Avaliação inicial', 10, 10);

insert into agendamento (status_agendamento, id_cliente, id_aula) values
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