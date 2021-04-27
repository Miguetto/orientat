------------------------------
-- Archivo de base de datos --
------------------------------

--- Esquemas

-- usuario (id clave primaria) borrar una fila, perfiles (id (primaria y ajena a usuarios),nombre, username, etc, usuario_id) borrar una fila no cascade.

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
    , descripcion        VARCHAR(255) NOT NULL
    , contenido          VARCHAR(255) NOT NULL
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id)
    , categoria_id       BIGINT       NOT NULL REFERENCES categorias(id)
);

DROP TABLE IF EXISTS propuestas CASCADE;

CREATE TABLE propuestas
(
      id                 BIGSERIAL    PRIMARY  KEY
    , titulo             VARCHAR(255) NOT NULL
    , descripcion        VARCHAR(255) NOT NULL
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id)
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

INSERT INTO categorias (nombre)
     VALUES ('Educación infantil')
           ,('Educación primaria')
           ,('Educación secundaria')
           ,('Formación profesional');

INSERT INTO recursos (titulo, descripcion, contenido, usuario_id, categoria_id)
     VALUES ('Cogemos vocales', 'Este recurso permite trabajar con los alumnos de forma divertida'
                              , 'Contenido del recurso'
                              , 3, 2)
           ,('Educación emocional', 'Este recurso permite trabajar con los alumnos de forma divertida'
                              , 'Contenido del recurso'
                              , 2, 1);

INSERT INTO propuestas (titulo, descripcion, usuario_id)
     VALUES ('Prueba de propuesta', 'descripcion de la propuesta', 2);

