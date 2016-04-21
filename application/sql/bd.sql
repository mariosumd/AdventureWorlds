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
    id_usuario  bigserial   constraint pk_usuarios primary key,
    nombre      varchar(15) not null,
    passwd      char(64)
);

drop table if exists juegos cascade;

create table juegos (
    id_juego    bigserial   constraint pk_juegos primary key,
    id_usuario  bigint      constraint fk_juegos_usuarios references usuarios (id_usuario),
    nombre      varchar(50) not null
);

drop table if exists fichas cascade;

create table fichas (
    id_ficha     bigserial   constraint pk_fichas primary key,
    id_juego     bigint      constraint fk_fichas_juegos   references juegos (id_juego),
    id_anterior  bigint      constraint fk_ficha_anterior  references fichas (id_ficha),
    id_siguiente bigint      constraint fk_ficha_siguiente references fichas (id_ficha),
    final        boolean,
    botones      boolean,
    contenido    varchar(200)
);
