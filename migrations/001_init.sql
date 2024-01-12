# Tables
create table core_acl_privilege
(
    code varchar(10) not null
        primary key
);

create table core_acl_resource
(
    code        varchar(20)  not null
        primary key,
    description varchar(100) null
);

create table core_acl_role
(
    code        varchar(20)  not null
        primary key,
    description varchar(100) null
);

create table core_acl_user
(
    id         int                                   not null
        primary key,
    username   varchar(45)                           null,
    first_name varchar(20)                           null,
    last_name  varchar(20)                           null,
    email      varchar(45)                           null,
    password   varchar(120)                          null,
    registered timestamp default current_timestamp() null,
    is_enabled tinyint   default 1                   null,
    constraint core_acl_user_pk
        unique (username),
    constraint core_acl_user_pk2
        unique (email)
);

create table core_acl_user_roles
(
    user_id   int         not null,
    role_code varchar(20) null,
    constraint core_acl_user_roles_core_acl_role_code_fk
        foreign key (role_code) references core_acl_role (code)
            on delete cascade,
    constraint core_acl_user_roles_core_acl_user_id_fk
        foreign key (user_id) references core_acl_user (id)
            on delete cascade
);

create index core_acl_user_roles_user_id_index
    on core_acl_user_roles (user_id);

create table core_acl
(
    id             int auto_increment
        primary key,
    role_code      varchar(20) null,
    resource_code  varchar(20) null,
    privilege_code varchar(20) null,
    constraint core_acl_core_acl_privilege_code_fk
        foreign key (privilege_code) references core_acl_privilege (code),
    constraint core_acl_core_acl_resource_code_fk
        foreign key (resource_code) references core_acl_resource (code),
    constraint core_acl_core_acl_role_code_fk
        foreign key (role_code) references core_acl_role (code)
);

# Init data
INSERT INTO core_acl_privilege (code) VALUES ('view');
INSERT INTO core_acl_privilege (code) VALUES ('create');
INSERT INTO core_acl_privilege (code) VALUES ('edit');
INSERT INTO core_acl_privilege (code) VALUES ('delete');
INSERT INTO core_acl_privilege (code) VALUES ('all');

INSERT INTO core_acl_role (code, description) VALUES ('global_admin', 'Nunrestricted access to all sections');
INSERT INTO core_acl_role (code, description) VALUES ('site_admin', 'Administrator of website. have some administration rights');
INSERT INTO core_acl_role (code, description) VALUES ('user', 'Default role for registered user');

