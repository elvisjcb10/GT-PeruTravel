# GT-PeruTravel
pagina creada
## Configuración de seguridad

El proyecto obtiene la configuración sensible desde variables de entorno del servidor:

- APP_ENV: usa production en el hosting y development solamente en local.
- RECAPTCHA_SECRET_KEY: clave secreta vigente de Google reCAPTCHA.
- RECAPTCHA_ALLOWED_HOST: dominio que Google debe devolver, por ejemplo www.gtperutravel.com.

El archivo .env.example sirve únicamente como referencia. Este proyecto no carga archivos .env automáticamente: las variables deben configurarse en Apache, PHP-FPM, el panel del hosting o el servicio de despliegue.

La clave secreta de reCAPTCHA nunca debe escribirse en PHP ni subirse a Git. Después de clonar el proyecto, configura las variables en el entorno antes de probar los formularios.

## URLs SEO amigables

Para desarrollo local, inicia PHP con el router del proyecto:

```powershell
php -S localhost:8000 router.php
```

Ejemplo:

`http://localhost:8000/es/tours/machu-picchu-clasico-full-day/`

En Apache, `.htaccess` dirige las rutas amigables a `router.php`. Después de agregar o renombrar contenido, debe regenerarse `data/routes.json` y `sitemap.xml` antes de publicar.