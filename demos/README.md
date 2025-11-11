# 🌟 Demos Visuales - Centro Wellness Dance & Spa

Esta carpeta contiene demos HTML estáticos que muestran el diseño y funcionalidad de todas las vistas de la aplicación.

## 📂 Archivos Incluidos

### 🏠 index.html
**Página principal de navegación**
- Portal de acceso a todos los demos
- Descripción de características
- Stack tecnológico

### 1️⃣ 1-clases-de-baile.html
**Vista: Catálogo de Clases de Baile**
- Listado de clases: Salsa, Bachata, Tango
- Múltiples horarios por clase
- Indicador de disponibilidad (cupos libres/ocupados)
- Botones de inscripción
- Diseño con gradiente indigo/purple

### 2️⃣ 2-servicios-spa.html
**Vista: Catálogo de Servicios de Spa**
- Servicios disponibles: Masajes, Faciales, Manicure, Pedicure
- Cards con información detallada
- Precios y duración
- Botones para agendar cita
- Diseño con gradiente teal/cyan
- Banner promocional de paquetes

### 3️⃣ 3-tienda-productos.html
**Vista: Tienda**
- **Membresías**: Básica, Premium, VIP con comparación de beneficios
- **Paquetes especiales**: Relajación, Belleza, Parejas, Iniciación al Baile
- **Productos**: Cremas, accesorios, merchandise
- Diseño con gradiente amber/orange
- Indicadores de ahorro en paquetes

### 4️⃣ 4-agenda-profesional.html
**Vista: Agenda del Profesional**
- Resumen del día (citas, completadas, pendientes)
- Listado de citas próximas con estado
- Calendario de próximas citas
- Tabla de clases programadas con inscritos
- Botones para marcar citas como completadas
- Estadísticas mensuales

### 5️⃣ 5-dashboard-cliente.html
**Vista: Dashboard del Cliente**
- Tarjetas de servicios principales (Clases, Spa, Tienda)
- Accesos rápidos (Mis Clases, Mis Citas, Mis Órdenes)
- Próximas clases inscritas
- Próximas citas de spa
- Banner promocional
- Estadísticas personales de progreso

## 🚀 Cómo Ver los Demos

### Opción 1: Abrir directamente en el navegador
1. Navega a la carpeta `demos/`
2. Abre `index.html` en tu navegador favorito
3. Haz clic en cualquier demo para verlo

### Opción 2: Usar un servidor local
```bash
cd demos
python3 -m http.server 8080
# Luego abre: http://localhost:8080
```

### Opción 3: Abrir archivos individuales
Puedes abrir cualquier archivo `.html` directamente haciendo doble clic.

## 🎨 Características de Diseño

### Paleta de Colores por Módulo
- **Clases de Baile**: Gradiente Indigo → Purple (`from-indigo-600 to-purple-600`)
- **Servicios Spa**: Gradiente Teal → Cyan (`from-teal-500 to-cyan-600`)
- **Tienda**: Gradiente Amber → Orange (`from-amber-500 to-orange-600`)
- **Navegación**: Gradiente Indigo → Purple (`from-indigo-600 to-purple-600`)

### Elementos de UI
- ✅ Cards con hover effects (shadow y scale)
- ✅ Badges de estado (confirmada, completada, pendiente)
- ✅ Barras de progreso animadas
- ✅ Botones con gradientes y efectos hover
- ✅ Emojis para mejor UX visual
- ✅ Diseño responsive (mobile-first)
- ✅ Navegación consistente en todas las vistas

## 📱 Responsive Design

Todos los demos son 100% responsive con breakpoints:
- **Móvil**: `< 640px` (sm)
- **Tablet**: `640px - 1024px` (md, lg)
- **Desktop**: `> 1024px` (xl)

## 🛠️ Tecnologías Utilizadas en los Demos

- **HTML5**: Estructura semántica
- **Tailwind CSS**: Framework CSS (via CDN)
- **Iconografía**: Heroicons (SVG) + Emojis

## 📝 Notas Importantes

1. **Estos son demos estáticos**: No tienen funcionalidad backend real
2. **No se conectan a base de datos**: Los datos son hardcoded
3. **No hay JavaScript funcional**: Los botones no ejecutan acciones
4. **Solo para visualización**: El objetivo es mostrar el diseño y layout

## 🔗 Relación con la Aplicación Real

Estos demos reflejan fielmente las vistas reales de Laravel ubicadas en:
- `resources/views/client/classes/index.blade.php` → `1-clases-de-baile.html`
- `resources/views/client/appointments/index.blade.php` → `2-servicios-spa.html`
- `resources/views/client/shop/index.blade.php` → `3-tienda-productos.html`
- `resources/views/professional/agenda/index.blade.php` → `4-agenda-profesional.html`
- `resources/views/dashboard.blade.php` → `5-dashboard-cliente.html`

## 💡 Sugerencias de Uso

1. **Presentaciones a clientes**: Muestra estos demos antes de ejecutar el proyecto Laravel
2. **Pruebas de diseño**: Verifica que el diseño sea el esperado
3. **Documentación visual**: Referencia rápida de cómo se ve cada módulo
4. **Testing de UI**: Prueba en diferentes navegadores y tamaños de pantalla

## 🎯 Siguiente Paso

Para ver la aplicación real con funcionalidad completa:

```bash
# Volver al directorio principal
cd ..

# Ejecutar migraciones y seeders
php artisan migrate:fresh --seed

# Iniciar servidor
php artisan serve

# Abrir en navegador
# http://localhost:8000
```

**Credenciales de prueba**:
- Cliente: `cliente1@wellness.com` / `password`
- Profesional: `maria.garcia@wellness.com` / `password`
- Admin: `superadmin@wellness.com` / `password`

---

✨ **Disfruta explorando los demos!** ✨
