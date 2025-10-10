create database techfit;

use techfit;

create table cliente (
    id_cliente int auto_increment primary key,
    nome_cliente varchar(50) not null,
    cpf varchar(14) not null,
    data_nascimento date not null,
    email varchar(50) not null,
    telefone varchar(15) not null
);

create table funcionario (
    id_funcionario int auto_increment primary key,
    nome_funcionario varchar(50) not null,
    cpf varchar(14) not null,
    cargo varchar(50) not null,
    salario decimal(10,2) not null,
    carga_horaria decimal(5,2),
    email varchar(50) not null,
    telefone varchar(15) not null
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
    carga_horaria decimal(5,2) not null,
    descricao varchar(255) not null
);

create table avaliacao_fisica (
    id_avaliacao int auto_increment primary key,
    data date not null,
    descricao varchar(255),
    id_cliente int not null,
    id_funcionario int not null
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
