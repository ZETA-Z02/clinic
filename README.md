# Plantilla Base para Proyectos en PHP con MVC

Este repositorio contiene una plantilla base para proyectos en PHP utilizando el patrón de diseño MVC (Modelo-Vista-Controlador). La estructura está diseñada para mantener el código organizado y facilitar la escalabilidad.

---

## 📂 Estructura del Proyecto

```plaintext
.
├── 404.html                # Página de error 404
├── index.php               # Punto de entrada principal que incluye las librerías necesarias
├── config/                 # Configuración general del proyecto
│   ├── config.php          # Configuración global (base de datos, rutas, etc.)
│   └── helpers.php         # Funciones auxiliares reutilizables
├── controller/             # Controladores principales del proyecto
│   ├── dashboard.php
│   ├── error.php
│   ├── login.php
│   └── services.php        # Uso de Apis y funcionalidades publicas
├── models/                 # Modelos relacionados con la lógica de negocio
│   ├── dashboardmodel.php
│   └── loginmodel.php
├── views/                  # Vistas organizadas por sección
│   ├── dashboard/
│   │   └── index.php
│   ├── error/
│   │   └── index.php
│   ├── login/
│   │   └── index.php
│   ├── footer.php          # Pie de página compartido
│   ├── header.php          # Encabezado compartido
│   └── template.php        # Plantilla base para las vistas
├── libs/                   # Librerías esenciales para implementar MVC
│   ├── app.php
│   ├── Conexion.php
│   ├── controller.php
│   ├── model.php
│   └── view.php
├── public/                 # Archivos públicos como CSS, JavaScript, imágenes, etc.
│   ├── assets/             # Recursos multimedia
│   │   ├── images/         # Imágenes del proyecto
│   │   └── video/          # Videos
│   ├── css/                # Estilos CSS por vista
│   │   └── app.css
│   ├── js/                 # Scripts JavaScript
│   │   └── app.js
|   |── plugins/             # Scripts reutilizables para evitar redundancias
│   │   ├── ajaxCrud
│   │   ├── paginador
│   │   └── validador
│   └── scss/               # Archivos SASS organizados
│       ├── animaciones.scss
│       ├── app.scss
│       ├── main.scss
│       └── productos.scss
├── utils/                  # Utilidades y recursos estáticos
│   ├── fonts/              # Fuentes personalizadas
│   │   ├── nucleo-icons.eot
│   │   ├── nucleo-icons.ttf
│   │   └── nucleo-icons.woff
│   └── foundation/         # Archivos de frameworks frontend (Foundation)
│       ├── css/
│       ├── js/
│       └── core/
├── doc/                    # Documentación del proyecto
├── dumps/                  # Backups o registros de datos
├── script.sql              # Script para inicializar la base de datos
├── robots.txt              # Configuración para rastreadores web
├── composer.json           # Archivo de configuración para Composer
└── package.json            # Archivo de configuración para Node.js
```

### 🚀 Funcionalidades

- Patrón MVC: Organiza la aplicación en tres componentes principales (Modelo, Vista, Controlador) para mejorar la mantenibilidad.
- Soporte SASS: Permite utilizar preprocesadores CSS para personalizar estilos fácilmente.
- Scripts Modulares: Los plugins reutilizables evitan la redundancia de código.
- Framework Frontend: Integración con Foundation para diseño responsivo.
- Documentación Incluida: Estructura para agregar documentación técnica del proyecto y las bases de datos.

### 📁 Detalles de las Carpetas

`config/`

- Contiene la configuración global del proyecto, como variables, rutas y funciones reutilizables.

`libs/`

- Incluye las librerías necesarias para que el proyecto funcione bajo el patrón MVC:

    - app.php: Configuración de rutas principales.
    - Conexion.php: Conexión a la base de datos.
    - controller.php: Clase base para los controladores.
    - model.php: Clase base para los modelos.
    - view.php: Clase base para las vistas.

`public/`

- Carpeta destinada a archivos públicos (CSS, JS, imágenes, etc.). Se divide en:

    - assets/: Recursos multimedia como imágenes y videos.
    - css/: Archivos CSS específicos para cada vista.
    - js/: Scripts personalizados y plugins reutilizables.
    - scss/: Archivos SASS para organizar estilos.

`utils/`

- Recursos que no cambian frecuentemente:

    - Fuentes personalizadas.
    - Archivos del framework frontend (Foundation).
`vendor/`
- Librerias php necesarias para proyectos
    - FPDF -> libreria de pdf ligera para generar archivos tipo pdf
    - tcpdf -> libreria de pdf mucha mas pesada pero mas completa
    - phpmailer -> libreria de correo, gratiuto con una configuracion de la cuenta de gmail
    - 
`node_modules` 
- Librerias javascript necesarios para proyectos
    - chartjs -> genera graficos para muestras estadisticas

### 📜 Licencia

 `Este proyecto está licenciado bajo la Licencia MIT.`