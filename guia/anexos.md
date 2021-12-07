# Anexos

**-Prueba del seis-**.

**1- ¿Qué sitio es este?**
- La aplicación en todo momento muestra el logotipo indicando en que sitio estás.

**2- ¿En qué ṕagina estoy?**
- Todas las pantallas de la web indican con encabezados en el sitio que te encuentras, con la ayuda también de las migas de pan.

**3- ¿Cuales son las principales secciones del sitio?**
- Si no estás logueado son: *Index*, *Registrarse*, *Login*.
- Si estás logueado: *Mi perfil*.

**4- ¿Que opciones tengo en este nivel?**
- En cualquier nivel se puede navegar hacia otros niveles a través del menú de navegación y botones.

**5- ¿Dónde estoy en el esquema de las cosas?**
- En todas las pantallas se puede ver a través del menú de navegación y migas de pan donde estoy.

**6- ¿Cómo busco algo?**
- La aplicación cuenta con su propio buscador en las distintas secciones.

---

(**([R25](https://github.com/Miguetto/orientat/issues/25)) Codeception**).

![Pruebas Codeception](images/anexos/codeception.png)

(**([R26](https://github.com/Miguetto/orientat/issues/26)) Code Climate**).

![Pruebas Codeclimate](images/anexos/codeclimate.png)

(**([R34](https://github.com/Miguetto/orientat/issues/34)) Validación HTML5, CSS3 y Accesibilidad**).

**HTML**

![Validación HTML](images/anexos/validacionhtml.png)

**CSS**

![Validación CSS](images/anexos/validacioncss.png)

**Accesibilidad**

![Validación accesibilidad](images/anexos/validacionacc.png)

(**([R35](https://github.com/Miguetto/orientat/issues/35)) Diseño para varias resoluciones**).

**Grandes resoluciones**

![Grandes resoluciones](images/anexos/gr.png)

**Pequeñas resoluciones**

![Pequeñas resoluciones](images/anexos/pr.png)


(**([R36](https://github.com/Miguetto/orientat/issues/36)) Varios navegadores**).

**Brave**

![Brave](images/anexos/brave.png)

**Chrome**

![Chrome](images/anexos/chrome.png)

**Mozilla Firefox**

![Mozilla](images/anexos/firefox.png)

(**([R38](https://github.com/Miguetto/orientat/issues/38)) Despliegue en servidor local**).

*DHCP*
- Configuramos la red en el servidor:

![netplan servidor](images/despliegue/servidor-netplan.png)

- Configuramos la red en el cliente:

![netplan cliente](images/despliegue/cliente-netplan.png)

*DNS*
- Editamos /etc/bind/named.conf.local:

![dns named](images/despliegue/dns-conf.png)

- Editamos /etc/bind/db.orienta-t.com:

![dns directa](images/despliegue/dns-directa.png)

- Editamos /etc/bind/db.1.168.192:

![dns inversa](images/despliegue/dns-inversa.png)

*APACHE*
- Editamos /etc/apache2/sites-available/000-default.conf para el directorio del proyecto y la redirección:

![apache](images/despliegue/apache.png)

*SSL*

**1- Generar clave privada y la solicitud**
    ```
    $ openssl genrsa -out orienta-t.key 2048
    ```

    ```
    $ openssl x509 -req -days 365 -in orienta-t.csr -signkey orienta-t.key -out orienta-t.crt
    ```
**2- Mover las claves y el certificadoa los directorios de apache**
    ```
    $ sudo mv orienta-t.key /etc/ssl/private/
    $ sudo mv orienta-t.crt /etc/ssl/certs/
    ```
**3- Configurar los permisos**
**4- Crear el fichero de configuración**
    ```
    $ $ sudo nano /etc/apache2/sites-available/orienta-tssl.conf
    ```

**5- Habilitamos el módulo ssl**
    ```
    $ sudo a2enmod ssl
    ```

**6- Activamos el servicio**
    ```
    $ sudo a2enmod orienta-tssl
    ```

*FINAL*

![web desplegada en local](images/despliegue/orientat-cliente.png)



















