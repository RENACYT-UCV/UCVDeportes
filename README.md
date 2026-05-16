# UCVDeportes

Sistema de gestión deportiva de la Universidad Central de Venezuela (UCV). Permite administrar actividades deportivas, atletas, entrenadores, horarios, inscripciones, videos y rankings.

## Tecnologías

| Capa | Tecnología |
|---|---|
| API | Laravel 11 + Laravel Sanctum |
| Frontend | PHP + Apache |
| Base de datos | PostgreSQL (Supabase) |
| Autenticación | Token Bearer (Sanctum) + Google OAuth |
| Contenedores | Docker Compose |

## Acceso al sistema

| Servicio | URL |
|---|---|
| Frontend | http://localhost:3000 |
| API | http://localhost:8000 |

### Credenciales de prueba

| Campo | Valor |
|---|---|
| username | `admin` |
| contraseña | `Admin1234!` |
| rol | Administrador |

> El login redirige al panel de **Administrador** o **Cliente** según el `rol_id` del usuario.

### Google OAuth

El sistema soporta inicio de sesión con Google. Para activarlo en local se necesita registrar `http://localhost:8000/api/auth/google/callback` como URI de redirección autorizada en Google Cloud Console.

## Levantar el sistema

```bash
docker compose up -d
```

Para reconstruir imágenes tras cambios de código:

```bash
docker compose up --build -d
```

Para detener y eliminar volúmenes (reinicio limpio de BD):

```bash
docker compose down -v
```

## Estructura del proyecto

```
UCVDeportes/
├── API/                        # Laravel 11 (backend)
│   ├── app/
│   │   ├── Http/Controllers/
│   │   │   ├── AuthController.php          # Login, registro, recuperación
│   │   │   ├── GoogleController.php        # OAuth Google
│   │   │   └── Admin/
│   │   │       ├── Activities/
│   │   │       │   ├── CategoriaController.php
│   │   │       │   ├── SubcategoriaController.php
│   │   │       │   └── HorarioController.php
│   │   │       ├── HabilidadController.php
│   │   │       ├── InscripcionController.php
│   │   │       ├── RankingController.php
│   │   │       ├── ReporteController.php
│   │   │       ├── UserController.php
│   │   │       └── VideoController.php
│   │   └── Models/
│   │       └── Usuario.php
│   ├── database/migrations/    # 17 migraciones
│   ├── database/seeders/       # Crea roles y usuario admin
│   ├── entrypoint.sh           # Configura .env, migra y seed al iniciar
│   └── Dockerfile
├── Login/                      # Páginas de autenticación
├── Admin/                      # Panel administrador
├── Cliente/                    # Panel cliente/atleta
├── docker-compose.yml
└── Dockerfile.frontend
```

## API — Endpoints

Todos los endpoints (excepto login, registro y OAuth) requieren header:
```
Authorization: Bearer {token}
```

### Autenticación

| Método | Endpoint | Descripción |
|---|---|---|
| POST | `/api/login` | Iniciar sesión → devuelve token |
| POST | `/api/register` | Registrar nuevo usuario |
| GET | `/api/logout` | Cerrar sesión |
| GET | `/api/profile` | Perfil del usuario autenticado |
| PATCH | `/api/profile/update/{id}` | Actualizar perfil |
| POST | `/api/recover-password` | Solicitar recuperación de contraseña |
| POST | `/api/validate-otp` | Validar código OTP |
| POST | `/api/reset-password` | Restablecer contraseña |
| GET | `/api/auth/google` | Redirigir a Google OAuth |
| GET | `/api/auth/google/callback` | Callback de Google OAuth |

### Categorías y Subcategorías

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/categories` | Listar categorías |
| POST | `/api/categories` | Crear categoría |
| GET | `/api/categories/{id}` | Ver categoría |
| PATCH | `/api/categories/{id}` | Actualizar categoría |
| DELETE | `/api/categories/{id}` | Eliminar categoría |
| GET | `/api/categories/{id}/subcategories` | Subcategorías de una categoría |
| GET | `/api/subcategories` | Listar subcategorías |
| POST | `/api/subcategories` | Crear subcategoría |
| GET | `/api/subcategories/{id}` | Ver subcategoría |
| PATCH | `/api/subcategories/{id}` | Actualizar subcategoría |
| DELETE | `/api/subcategories/{id}` | Eliminar subcategoría |

### Horarios

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/schedules` | Listar horarios |
| POST | `/api/schedules` | Crear horario |
| GET | `/api/schedules/{id}` | Ver horario |
| PATCH | `/api/schedules/{id}` | Actualizar horario |
| DELETE | `/api/schedules/{id}` | Eliminar horario |
| GET | `/api/subcategories/{id}/schedules` | Horarios de una subcategoría |
| POST | `/api/subcategories/{id}/schedules` | Agregar horario a subcategoría |
| GET | `/api/subcategories/{id}/vacancies` | Vacantes disponibles |

### Usuarios

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/users` | Listar usuarios |
| POST | `/api/users` | Crear usuario |
| GET | `/api/users/{id}` | Ver usuario |
| PATCH | `/api/users/{id}` | Actualizar usuario |
| DELETE | `/api/users/{id}` | Eliminar usuario |
| GET | `/api/users/{id}/habilities` | Habilidades del usuario |
| GET | `/api/users/{id}/habilities-with-position` | Habilidades con posición |

### Habilidades

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/habilities` | Listar habilidades |
| POST | `/api/habilities` | Crear habilidad |
| GET | `/api/habilities/{id}` | Ver habilidad |
| PATCH | `/api/habilities/{id}` | Actualizar habilidad |
| DELETE | `/api/habilities/{id}` | Eliminar habilidad |

### Inscripciones

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/inscripciones` | Listar inscripciones |
| POST | `/api/inscripciones` | Crear inscripción |
| GET | `/api/inscripciones/{id}` | Ver inscripción |
| PATCH | `/api/inscripciones/{id}` | Actualizar inscripción |
| DELETE | `/api/inscripciones/{id}` | Eliminar inscripción |

### Videos y Likes

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/videos` | Listar videos |
| POST | `/api/videos` | Subir video |
| GET | `/api/videos/{id}` | Ver video |
| PATCH | `/api/videos/{id}` | Actualizar video |
| DELETE | `/api/videos/{id}` | Eliminar video |
| POST | `/api/videos/{id}/like` | Dar like |
| DELETE | `/api/videos/{id}/like` | Quitar like |

### Ranking y Reportes

| Método | Endpoint | Descripción |
|---|---|---|
| GET | `/api/ranking` | Listar ranking |
| GET | `/api/ranking/{id}` | Ver ranking |
| DELETE | `/api/ranking/{id}` | Eliminar del ranking |
| GET | `/api/reportes` | Listar reportes |
| POST | `/api/reportes` | Crear reporte |
| GET | `/api/reportes/{id}` | Ver reporte |
| DELETE | `/api/reportes/{id}` | Eliminar reporte |
| POST | `/api/reportes/preview` | Vista previa del reporte |
| GET | `/api/reportes/download/{id}` | Descargar reporte (PDF) |

## Base de datos

Alojada en **Supabase** (PostgreSQL). Las migraciones corren automáticamente al iniciar el contenedor.

### Tablas principales

| Tabla | Descripción |
|---|---|
| `roles` | Roles del sistema (Administrador, Entrenador, Atleta) |
| `usuarios` | Usuarios registrados |
| `password_resets` | Tokens de recuperación de contraseña |
| `categorias` | Categorías deportivas |
| `subcategorias` | Subcategorías dentro de cada categoría |
| `horarios` | Horarios de actividades |
| `habilidades` | Habilidades deportivas |
| `videos` | Videos subidos por usuarios |
| `inscripciones` | Inscripciones a actividades |
| `likes` | Likes en videos |
| `reportes` | Reportes generados |
| `personal_access_tokens` | Tokens Sanctum |

## Variables de entorno

Crea un archivo `.env` en la raíz del proyecto con estos valores:

```env
APP_KEY=base64:d9bJfEEL/p4LQh5PHRb5Epfhvif6AcoZhGvRq6F9VRE=

DB_HOST=aws-1-us-west-2.pooler.supabase.com
DB_USERNAME=postgres.zmlxbhofscglrqrokiae
DB_PASSWORD=6udzchjFFKh5svq0

GOOGLE_CLIENT_ID=177746689868-snrc1mp8astvj74vqe5uchkginh1r6md.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
```
