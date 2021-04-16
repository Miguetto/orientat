------------------------------
-- Archivo de base de datos --
------------------------------

--- Esquemas

DROP TABLE IF EXISTS roles CASCADE;

CREATE TABLE roles
(
      id                BIGSERIAL     PRIMARY KEY
    , rol               VARCHAR(16)
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios
(
      id                 BIGSERIAL    PRIMARY  KEY
    , nombre             VARCHAR(255) NOT NULL
    , username           VARCHAR(255) NOT NULL UNIQUE
    , email              VARCHAR(255) NOT NULL UNIQUE
    , password           VARCHAR(255) NOT NULL   
    , auth_key           VARCHAR(255)
    , token_confirm      VARCHAR(255)
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , rol_id             BIGINT       NOT NULL DEFAULT 3 REFERENCES roles(id)

);

DROP TABLE IF EXISTS categorias CASCADE;

CREATE TABLE categorias
(
      id                 BIGSERIAL    PRIMARY  KEY
    , nombre             VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS recursos CASCADE;

CREATE TABLE recursos
(
      id                 BIGSERIAL    PRIMARY  KEY
    , titulo             VARCHAR(255) NOT NULL
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id)
    , categoria_id       BIGINT       NOT NULL REFERENCES categorias(id)
);

--- Fixtures

INSERT INTO roles(rol)
     VALUES ('admin')
           ,('revisor')
           ,('usuario');

INSERT INTO usuarios (nombre, username, email, password, rol_id)
     VALUES ('admin', 'admin', 'admin@orientat.es', crypt('admin', gen_salt('bf', 10)), 1)
           ,('Miguel', 'mrevisor', 'mrevisor@orientat.es', crypt('123', gen_salt('bf', 10)), 2);

INSERT INTO usuarios (nombre, username, email, password)
     VALUES ('Ana', 'anuska', 'anuska@orientat.es', crypt('321', gen_salt('bf', 10)))
           ,('Manuel', 'manolito', 'manolito@orientat.es', crypt('111', gen_salt('bf', 10)));