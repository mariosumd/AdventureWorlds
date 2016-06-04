drop table if exists "ci_sessions" cascade;

create table "ci_sessions" (
        "id"         varchar(40) not null,
        "ip_address" varchar(45) not null,
        "timestamp"  bigint default 0 not null,
        "data"       text default '' not null
);

create index "ci_sessions_timestamp" on "ci_sessions" ("timestamp");

drop table if exists usuarios cascade;

create table usuarios (
    id_usuario          bigserial    constraint pk_usuarios primary key,
    nombre              varchar(15)  not null constraint uq_nombre_usuarios unique,
    password            char(60)     not null constraint ck_password_valida
                                     check (length(password) = 60),
    email               varchar(100) not null constraint uq_email_usuarios unique,
    registro_verificado boolean      not null default false,
    admin               boolean      not null default false,
    activado            boolean      not null default true
);

insert into usuarios (nombre, password, email, registro_verificado)
    values ('MarioSumD', crypt('MarioSumD', gen_salt('bf')), 'mariosumd@gmail.com', true);

drop table if exists juegos cascade;

create table juegos (
    id_juego    bigserial   constraint pk_juegos primary key,
    id_usuario  bigint      constraint fk_juegos_usuarios
                                       references usuarios (id_usuario),
    nombre      varchar(50) not null,
    finalizado  boolean     not null default false
);

drop table if exists fichas cascade;

create table fichas (
    id_ficha   bigserial  constraint pk_fichas primary key,
    id_juego      bigint  constraint fk_fichas_juegos
                                        references juegos (id_juego)
                                        on delete cascade,
    id_anterior   bigint  constraint fk_ficha_anterior
                                        references fichas (id_ficha)
                                        on delete set null,
    id_siguiente1 bigint  constraint fk_ficha_siguiente1
                                        references fichas (id_ficha)
                                        on delete set null,
    id_siguiente2 bigint  constraint fk_ficha_siguiente2
                                        references fichas (id_ficha)
                                        on delete set null,
    titulo        varchar (50),
    final         boolean default false,
    botones       boolean default false,
    cont_boton1   varchar(50),
    cont_boton2   varchar(50),
    color_boton   varchar(10),
    color_ficha   varchar(10),
    imagen        boolean default false,
    contenido     varchar(500)
);

drop table if exists tokens cascade;

create table tokens (
    usuario_id bigint   constraint pk_tokens primary key
                        constraint fk_tokens_usuarios references usuarios (id_usuario),
    token      char(32) not null
);

create view v_usuarios_verificados as
    select *
    from usuarios
    where registro_verificado = true;

create view v_juegos_pendientes as
    select *
    from juegos
    where finalizado = false;

create view v_fichas_formateadas as
    select f.titulo, f.id_ficha, f.id_juego, f.final, f.id_siguiente1,
           f.id_siguiente2, u.titulo as siguiente1, d.titulo as siguiente2
    from fichas f
    left join fichas u on f.id_siguiente1 = u.id_ficha
    left join fichas d on f.id_siguiente2 = d.id_ficha;

create view v_juegos_finalizados as
    select j.nombre as nombre_juego, u.nombre as nombre_usuario,
           j.finalizado, j.id_juego
    from juegos j
    left join usuarios u on j.id_usuario = u.id_usuario
    where finalizado = true
