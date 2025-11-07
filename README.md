# Centro Wellness Dance & Spa

Sistema de gestión integral para un centro wellness que combina:
- **Estudio de baile** con clases grupales
- **Spa y centro de belleza** con servicios por cita
- **Ecommerce** para productos y paquetes

## Características Principales

### Arquitectura Modular

El sistema está diseñado con tres categorías principales de servicios:

1. **DANCE_CLASSES**: Clases grupales con horarios fijos recurrentes
2. **SPA_SERVICES**: Servicios individuales con sistema de citas/appointments
3. **PRODUCTS**: Ecommerce tradicional para productos físicos

### Roles y Permisos

- **Super Admin**: Acceso total al sistema
- **Administrador**: Gestión completa de servicios, profesionales y reportes
- **Profesional**: Profesor de baile O Terapeuta/Esteticista
  - Ver su agenda y clientes asignados
  - Marcar asistencia/completar servicios
  - Un usuario puede ser ambos tipos
- **Cliente/Estudiante**:
  - Inscribirse a clases de baile
  - Agendar citas de spa
  - Comprar productos

## Stack Tecnológico

- **Framework**: Laravel 10.x
- **Base de datos**: MySQL
- **Autenticación**: Laravel Breeze
- **Roles y Permisos**: Spatie Laravel Permission
- **Panel Admin**: Filament 3.x
- **Idioma**: Español (Colombia)
- **Moneda**: COP (Pesos Colombianos)
- **Zona Horaria**: America/Bogota

## Instalación

### Requisitos Previos

- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone <repository-url>
cd dance-spa
```

2. **Instalar dependencias de PHP**
```bash
composer install
```

3. **Instalar dependencias de Node.js**
```bash
npm install
```

4. **Configurar el archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurar la base de datos en .env**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wellness_center
DB_USERNAME=root
DB_PASSWORD=
```

6. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

7. **Compilar assets**
```bash
npm run build
```

8. **Iniciar el servidor**
```bash
php artisan serve
```

## Usuarios de Prueba

Después de ejecutar los seeders, podrás acceder con:

### Super Admin
- Email: `superadmin@wellness.com`
- Password: `password`

### Administrador
- Email: `admin@wellness.com`
- Password: `password`

### Profesionales
- **Profesor de Baile**: `carlos@wellness.com` / `password`
- **Terapeuta**: `ana@wellness.com` / `password`
- **Profesional Mixto**: `luis@wellness.com` / `password`

### Clientes
- Email: `cliente1@example.com` hasta `cliente5@example.com`
- Password: `password` (todos)

## Acceso al Panel Administrativo

Accede al panel de Filament en: `http://localhost:8000/admin`

## Estructura del Proyecto

### Modelos Principales

- **ServiceCategory**: Categorías de servicio (Baile, Spa, Productos)
- **Service**: Servicios genéricos (clases, citas, productos)
- **Professional**: Profesionales (profesores y terapeutas)
- **Schedule**: Horarios fijos para clases recurrentes
- **Enrollment**: Inscripciones a clases grupales
- **Appointment**: Citas individuales para servicios de spa
- **Product**: Productos físicos
- **Order**: Órdenes de compra unificadas
- **OrderItem**: Items de órdenes (polimórfico)

### Service Classes

#### ClassEnrollmentService
Maneja las inscripciones a clases grupales:
- Validación de cupos
- Inscripción de estudiantes
- Gestión de estados (activo, pausado, cancelado)

#### AppointmentBookingService
Gestiona las citas de spa:
- Creación de citas
- Validación de disponibilidad
- Estados de citas (pending, confirmed, completed, etc.)

#### AvailabilityService
Verifica disponibilidad de profesionales:
- Evita citas superpuestas
- Valida horarios disponibles
- Genera slots de tiempo disponibles

#### OrderProcessingService
Procesa órdenes de compra:
- Creación de órdenes
- Gestión de pagos
- Historial de compras

## Funcionalidades Clave

### Para Clases de Baile
- ✅ Horarios recurrentes (ej: Salsa lunes y miércoles 7pm)
- ✅ Inscripción con validación de cupo
- ✅ Lista de asistencia por clase
- ✅ Paquetes de N clases con vigencia

### Para Spa
- ✅ Sistema de disponibilidad de profesionales
- ✅ Calendario de citas con bloques de tiempo
- ✅ Prevención de citas superpuestas
- ✅ Preparado para recordatorios automáticos
- ✅ Notas del servicio realizado

### Para Ecommerce
- ✅ Catálogo de productos con stock
- ✅ Sistema de órdenes
- ✅ Venta de paquetes especiales

## Validaciones Críticas Implementadas

- ❌ No permite inscripción si la clase está llena
- ❌ No permite citas superpuestas para un profesional
- ✅ Valida disponibilidad horaria del profesional
- ✅ Valida que un paquete no esté vencido al usarlo
- ✅ Previene conflictos en la agenda

## Base de Datos

### Tablas Principales

```
- users
- roles
- permissions
- service_categories
- services
- professionals
- professional_service_category (pivot)
- schedules
- enrollments
- appointments
- products
- orders
- order_items
```

## Comandos Útiles

### Desarrollo
```bash
# Limpiar caché
php artisan optimize:clear

# Ejecutar migraciones
php artisan migrate

# Refrescar base de datos
php artisan migrate:fresh --seed

# Compilar assets en desarrollo
npm run dev

# Compilar assets para producción
npm run build
```

### Testing
```bash
# Ejecutar tests
php artisan test
```

## Próximas Implementaciones Sugeridas

- [ ] Sistema de notificaciones (recordatorios de citas)
- [ ] Integración con pasarela de pagos
- [ ] API REST para aplicación móvil
- [ ] Sistema de calificaciones y reseñas
- [ ] Dashboard con estadísticas avanzadas
- [ ] Generación de reportes en PDF
- [ ] Sistema de membresías con pagos recurrentes
- [ ] Chat en tiempo real profesional-cliente

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la licencia MIT.

## Soporte

Para soporte y preguntas, contacta a través de:
- Email: soporte@wellness.com
- Issues: GitHub Issues

---

Desarrollado con ❤️ para el Centro Wellness Dance & Spa
