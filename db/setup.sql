create table emails
(
    id         int auto_increment
        primary key,
    `from`     varchar(320)         not null,
    subject    varchar(256)         null,
    body       varchar(8192)        null,
    image      varchar(320)         null,
    isPhishing tinyint(1) default 0 not null
);

create table tests
(
    id         int auto_increment
        primary key,
    user_email varchar(320) not null,
    test_name  varchar(40)  not null,
    result     int          not null,
    date       datetime     not null
);

create table tooltips
(
    hint_id int           not null,
    text    varchar(2048) not null,
    constraint tooltips_hint_id_uindex
        unique (hint_id)
);

alter table tooltips
    add primary key (hint_id);

create table users
(
    id         int auto_increment
        primary key,
    email      varchar(320) not null,
    password   varchar(320) not null,
    first_name varchar(320) not null,
    last_name  varchar(320) not null,
    image      varchar(320) null
);


