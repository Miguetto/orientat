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
    , rol_id             BIGINT       NOT NULL DEFAULT 3 REFERENCES roles(id) ON DELETE CASCADE
    , de_baja            BOOLEAN      NOT NULL DEFAULT false

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
    , contenido          TEXT         NOT NULL
    , enlace             VARCHAR(255) 
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE
    , categoria_id       BIGINT       NOT NULL REFERENCES categorias(id) ON DELETE CASCADE
    , comentario_id      BIGINT                REFERENCES comentarios(id) ON DELETE CASCADE
    , likes              INTEGER      NOT NULL DEFAULT 0
    , imagen             TEXT
    , pdf_pdf            TEXT
    , revisado           BOOLEAN      NOT NULL DEFAULT false
);

DROP TABLE IF EXISTS respuestas CASCADE;

CREATE TABLE respuestas
(
      id                 BIGSERIAL    PRIMARY  KEY
    , cuerpo             VARCHAR(255) NOT NULL
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , comentario_id      BIGINT       NOT NULL REFERENCES comentarios(id) ON DELETE CASCADE
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS comentarios CASCADE;

CREATE TABLE comentarios
(
      id                 BIGSERIAL    PRIMARY  KEY
    , cuerpo             VARCHAR(255) NOT NULL
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , recurso_id         BIGINT       NOT NULL REFERENCES recursos(id) ON DELETE CASCADE
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE
    , respuesta_id       BIGINT       REFERENCES          respuestas(id) ON DELETE CASCADE
);

DROP TABLE IF EXISTS propuestas CASCADE;

CREATE TABLE propuestas
(
      id                 BIGSERIAL    PRIMARY  KEY
    , titulo             VARCHAR(255) NOT NULL
    , descripcion        VARCHAR(255) NOT NULL
    , created_at         TIMESTAMP(0) NOT NULL DEFAULT CURRENT_TIMESTAMP
    , usuario_id         BIGINT       NOT NULL REFERENCES usuarios(id) ON DELETE CASCADE
    , votos              INTEGER      NOT NULL DEFAULT 0
);

DROP TABLE IF EXISTS likes CASCADE;

CREATE TABLE likes
(
    id             bigserial    PRIMARY KEY
  , usuario_id     bigint       NOT NULL REFERENCES usuarios (id) on update CASCADE on delete CASCADE
  , recurso_id     bigint       NOT NULL REFERENCES recursos (id) on update CASCADE on delete CASCADE
);

DROP TABLE IF EXISTS votos CASCADE;

CREATE TABLE votos
(
    id             bigserial    PRIMARY KEY
  , usuario_id     bigint       NOT NULL REFERENCES usuarios   (id) ON DELETE CASCADE
  , propuesta_id   bigint       NOT NULL REFERENCES propuestas (id) ON DELETE CASCADE
);


--- Fixtures

INSERT INTO roles(rol)
     VALUES ('admin')
           ,('revisor')
           ,('usuario');

INSERT INTO usuarios (nombre, username, email, password, rol_id)
     VALUES ('admin', 'admin', 'admin@orientat.es', crypt('admin', gen_salt('bf', 10)), 1)
           ,('Miguel', 'mrevisor', 'mrevisor@orientat.es', crypt('123', gen_salt('bf', 10)), 2);

INSERT INTO usuarios (nombre, username, email, de_baja, password)
     VALUES ('Ana', 'anuska', 'anuska@orientat.es', 'false', crypt('321', gen_salt('bf', 10)))
           ,('Manuel', 'manolito', 'manolito@orientat.es', 'true', crypt('111', gen_salt('bf', 10)));

INSERT INTO categorias (nombre)
     VALUES ('Educación infantil')
           ,('Educación primaria')
           ,('Educación secundaria')
           ,('Formación profesional');

INSERT INTO recursos (titulo, descripcion, contenido, usuario_id, categoria_id, revisado)
     VALUES ('Cogemos vocales', 'Este recurso permite trabajar con los alumnos de forma divertida'
                              , 'Contenido del recurso'
                              , 3, 2, true)
           ,('Educación emocional', 'Este recurso permite trabajar con los alumnos de forma divertida'
                              , 'Contenido del recurso'
                              , 2, 1, true);

INSERT INTO propuestas (titulo, descripcion, usuario_id)
     VALUES ('Prueba de propuesta', 'descripcion de la propuesta', 2);

