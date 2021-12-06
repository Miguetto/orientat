# Instrucciones de instalación y despliegue

## En local

#### Requisitos:
* PHP 7.3.0 ó superior
* PostgreSQL
* Composer
* Git
* Cuenta de gmail
* Cuenta en Amazon S3

#### Instalación:
1. Clonamos el proyecto:
   
   ```
   $ git clone https://github.com/Miguetto/orientat
   ```
2. Nos movemos a la raíz del proyecto y ejecutamos el siguiente comando:

    ```
    $ composer install
    ```

3. Creamos la base de datos e intyectamos con los scripts, dentro de la raiz del proyecto ejecutamos los siguientes comandos:

    ```
    $ db/create.sh
    $ db/load.sh
    ```

4. Cambiamos algunos datos en **config/params.php** :
    * `adminEmail = Email que utilizará el Administrador.`
    * `smtpUsername = Email que utilizará la aplicación web.`

5. Editamos el archivo **.env.example** y lo guardamos como **.env** con las siguentes variables de entorno:
    * `SMTP_PASS = clave de aplicación de correo.`
    * `S3_PASS = KeyID de Amazon S3.`
    * `S3S_PASS = SecretKey de Amazon S3.`
    * `S3_BUCKET_NAME = Nombre del bucket en Amazon S3.`

6. Ejecutar lo siguiente:
    * `./yii serve = para arrancar el servidor.`

7. En el navegador ponemos:
    * `http://localhost:8008/`


## En la nube

#### Requisitos:

* Heroku CLI (https://devcenter.heroku.com/articles/heroku-cli)

#### Instalación:

1. Crear cuenta en heroku.com.

2. Iniciar sesión en Heroku y creamos una nueva apliación.

3. Añadir a la aplicación el *add-on* Heroku Postgres.

4. Añadir las variables de entorno que usamos en **.env** de la instalación local, añadiendo además la variable 'YII_ENV=prod' para indicar que estamos en producción.

5. Iniciar sesión en heroku desde la terminal:

    ```
    $ heroku login
    ```
6. En el directorio del proyecto conectamos la app de heroku con el comando:

    ```
    $ heroku git:remote --app <nombre_app>.
    ```
7. Entramos a la base de datos de heroku e instalamos el pgcrypto con el comando:
    
    ```
    $ heroku psql y luego # create extension pgcrypto
    ```

8. Inyectamos nuestra base de datos ya creada a Heroku:

    ```
    $ heroku psql < db/orientat.sql
    ```

9. Sincronizar el proyecto con GitHub, y seleccionar en que rama queremos el despliegue:

    ```
    $ git push heroku master
    ```

10. Aplicación funcionando.
