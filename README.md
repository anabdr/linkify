# LINKIFY
---

## Descripción del Proyecto
Este proyecto es un acortador de URLs que permite a los usuarios acortar enlaces largos, realizar un seguimiento de los clics por día y generar gráficos estadísticos.  
Está compuesto por dos aplicaciones independientes:  

- **Backend**: Desarrollado con Laravel 11.  
- **Frontend**: Desarrollado con Vue 3.  

Ambas aplicaciones se comunican a través de una API y utilizan JSON Web Tokens (JWT) para la autenticación y autorización.  
Los datos se almacenan en una base de datos SQL para garantizar la persistencia y la consulta eficiente de la información.

---

## Tecnologías Utilizadas

### Backend  
- **Framework**: Laravel 11  
- **Autenticación**: JWT  
- **Base de datos**: SQL (MySQL por defecto, pero compatible con otros motores soportados por Laravel)  
- **Validación y Controladores**: Estándar de Laravel  
- **Migraciones y Seeds**: Gestión de estructura y datos iniciales  

### Frontend  
- **Framework**: Vue 3  
- **Estilos**: SCSS y Bootstrap  
- **Estado global**: Vuex  
- **Ruteo**: Vue Router  
- **Gráficos**: ApexCharts  

---

## Funcionalidades

### Backend  
- Registro y autenticación de usuarios mediante JWT.  
- Generación de URLs cortas.  
- Seguimiento de clics por URL con almacenamiento por día en una base de datos SQL.  
- Endpoints RESTful API para consumir desde el frontend.  
- Validación de entradas del usuario.  

### Frontend  
- Interfaz de usuario intuitiva y responsiva gracias a SCSS y Bootstrap.  
- Gestión de sesiones mediante Vuex y JWT.  
- Generación de gráficos estadísticos interactivos con ApexCharts.  
- Listados y gestión de URLs acortadas.  
- Copiado y eliminación rápida de enlaces.  

---

## Requisitos Previos

### General  
- **Node.js** (v16 o superior)  
- **Composer** (para dependencias de Laravel)  
- **PHP** (v8.2 o superior)  
- **MySQL** o cualquier base de datos SQL compatible con Laravel  

### Instalaciones  
1. **Clonar el repositorio**:  
   ```bash
   git clone https://github.com/usuario/acortador-urls.git
2. **Configurar el backend**:  
   ```bash
   cd backend
3. **Instalar dependencias de laravel**:  
   ```bash
   composer install
4. **Renombra el archivo .env.example a .env en ambos proyectos**:
5. **Generar la clave JWT**:
   ```bash
   php artisan jwt:secret
6. **Ejecutar migraciones**:
   ```bash
   php artisan migrate --seed
7. **Iniciar el servidor**:
   ```bash
   php artisan serve
   
### Configurar el Frontend
1. **Accede al directorio frontend**:  
   ```bash
   cd frontend
2. **Instalar dependencias**:  
   ```bash
   npm install
3. **Configura las variables de entorno en .env**:  
4. **Iniciar la aplicación**:  
   ```bash
   npm run dev

## Uso
1. Accede al frontend en el navegador:
   [http://localhost:3000](http://localhost:3000)
2. Regístrate o inicia sesión.
3. Acorta una URL desde el panel de usuario.
4. Visualiza estadísticas y gráficos de los clics por día para cada URL.

---

## Estructura de los Proyectos

### Backend (Laravel)
```plaintext
backend/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── seeders/
├── public/
├── routes/
│   ├── api.php
│   ├── web.php
├── tests/
├── .env
├── composer.json
└── artisan

### Frontend (Vue)
frontend/
├── src/
│   ├── assets/
│   ├── components/
│   ├── composables/
│   ├── store/
│   ├── views/
│   ├── App.vue
│   ├── main.js
├── public/
├── .env
├── package.json
└── vite.config.js


## Contribuciones
Las contribuciones son bienvenidas. Si deseas colaborar:
1. Haz un fork del proyecto.
2. Crea una nueva rama (`feature/nueva-funcionalidad`).
3. Envía un pull request.

---

## Licencia
Este proyecto está licenciado bajo la [MIT License](LICENSE).

---

## Contacto
Si tienes preguntas o sugerencias, no dudes en contactarme:

- **Correo**: [ana.bdr.7@gmail.com](mailto:ana.bdr.7@gmail.com)
- **GitHub**: [anabdr](https://github.com/anabdr)




