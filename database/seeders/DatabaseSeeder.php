<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Professional;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Crear roles y permisos
        $this->createRolesAndPermissions();

        // 2. Crear usuarios
        $users = $this->createUsers();

        // 3. Crear categorías de servicio
        $categories = $this->createServiceCategories();

        // 4. Crear servicios
        $services = $this->createServices($categories);

        // 5. Crear profesionales
        $professionals = $this->createProfessionals($users, $categories);

        // 6. Crear horarios de clases
        $schedules = $this->createSchedules($services, $professionals);

        // 7. Crear inscripciones
        $this->createEnrollments($users, $schedules);

        // 8. Crear citas
        $this->createAppointments($services, $professionals, $users);

        // 9. Crear productos
        $products = $this->createProducts();

        // 10. Crear órdenes de ejemplo
        $this->createOrders($users, $services, $products);

        $this->command->info('¡Datos de ejemplo creados exitosamente!');
    }

    private function createRolesAndPermissions()
    {
        // Crear roles
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Administrador']);
        $professional = Role::create(['name' => 'Profesional']);
        $client = Role::create(['name' => 'Cliente']);

        // Crear permisos básicos
        $permissions = [
            'manage_users',
            'manage_services',
            'manage_professionals',
            'manage_appointments',
            'manage_enrollments',
            'manage_products',
            'manage_orders',
            'view_reports',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Asignar permisos a roles
        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo([
            'manage_services',
            'manage_professionals',
            'manage_appointments',
            'manage_enrollments',
            'manage_products',
            'manage_orders',
            'view_reports',
        ]);

        $this->command->info('Roles y permisos creados');
    }

    private function createUsers()
    {
        // Usuario Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@wellness.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Usuario Administrador
        $admin = User::create([
            'name' => 'María García',
            'email' => 'admin@wellness.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $admin->assignRole('Administrador');

        // Profesionales
        $prof1 = User::create([
            'name' => 'Carlos Mendoza',
            'email' => 'carlos@wellness.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $prof1->assignRole('Profesional');

        $prof2 = User::create([
            'name' => 'Ana Rodríguez',
            'email' => 'ana@wellness.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $prof2->assignRole('Profesional');

        $prof3 = User::create([
            'name' => 'Luis Hernández',
            'email' => 'luis@wellness.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $prof3->assignRole('Profesional');

        // Clientes
        $clients = [];
        for ($i = 1; $i <= 5; $i++) {
            $client = User::create([
                'name' => "Cliente $i",
                'email' => "cliente$i@example.com",
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $client->assignRole('Cliente');
            $clients[] = $client;
        }

        $this->command->info('Usuarios creados');

        return [
            'superadmin' => $superAdmin,
            'admin' => $admin,
            'professionals' => [$prof1, $prof2, $prof3],
            'clients' => $clients,
        ];
    }

    private function createServiceCategories()
    {
        $dance = ServiceCategory::create([
            'name' => 'Clases de Baile',
            'type' => 'DANCE_CLASSES',
            'slug' => 'clases-baile',
            'description' => 'Clases grupales de diferentes ritmos',
            'is_active' => true,
        ]);

        $spa = ServiceCategory::create([
            'name' => 'Spa y Belleza',
            'type' => 'SPA_SERVICES',
            'slug' => 'spa-belleza',
            'description' => 'Servicios de spa y tratamientos de belleza',
            'is_active' => true,
        ]);

        $products = ServiceCategory::create([
            'name' => 'Productos',
            'type' => 'PRODUCTS',
            'slug' => 'productos',
            'description' => 'Productos y membresías',
            'is_active' => true,
        ]);

        $this->command->info('Categorías de servicio creadas');

        return compact('dance', 'spa', 'products');
    }

    private function createServices($categories)
    {
        // Servicios de baile
        $salsa = Service::create([
            'service_category_id' => $categories['dance']->id,
            'name' => 'Salsa',
            'description' => 'Clase de salsa para todos los niveles',
            'price' => 50000,
            'duration' => 60,
            'type' => 'class',
            'max_capacity' => 20,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $bachata = Service::create([
            'service_category_id' => $categories['dance']->id,
            'name' => 'Bachata',
            'description' => 'Clase de bachata sensual y tradicional',
            'price' => 50000,
            'duration' => 60,
            'type' => 'class',
            'max_capacity' => 20,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $tango = Service::create([
            'service_category_id' => $categories['dance']->id,
            'name' => 'Tango',
            'description' => 'Clase de tango argentino',
            'price' => 60000,
            'duration' => 90,
            'type' => 'class',
            'max_capacity' => 15,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        // Servicios de spa
        $masaje = Service::create([
            'service_category_id' => $categories['spa']->id,
            'name' => 'Masaje Relajante',
            'description' => 'Masaje de relajación y descontractura',
            'price' => 80000,
            'duration' => 60,
            'type' => 'appointment',
            'max_capacity' => 1,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $facial = Service::create([
            'service_category_id' => $categories['spa']->id,
            'name' => 'Tratamiento Facial',
            'description' => 'Limpieza facial profunda e hidratación',
            'price' => 120000,
            'duration' => 90,
            'type' => 'appointment',
            'max_capacity' => 1,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $manicure = Service::create([
            'service_category_id' => $categories['spa']->id,
            'name' => 'Manicure',
            'description' => 'Manicure completo con esmaltado',
            'price' => 35000,
            'duration' => 45,
            'type' => 'appointment',
            'max_capacity' => 1,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $pedicure = Service::create([
            'service_category_id' => $categories['spa']->id,
            'name' => 'Pedicure',
            'description' => 'Pedicure completo con esmaltado',
            'price' => 40000,
            'duration' => 60,
            'type' => 'appointment',
            'max_capacity' => 1,
            'requires_professional' => true,
            'is_active' => true,
        ]);

        $this->command->info('Servicios creados');

        return compact('salsa', 'bachata', 'tango', 'masaje', 'facial', 'manicure', 'pedicure');
    }

    private function createProfessionals($users, $categories)
    {
        // Profesor de baile
        $prof1 = Professional::create([
            'user_id' => $users['professionals'][0]->id,
            'bio' => 'Instructor de baile con 10 años de experiencia',
            'phone' => '3001234567',
            'specialties' => ['salsa', 'bachata'],
            'is_available' => true,
        ]);
        $prof1->serviceCategories()->attach($categories['dance']->id);

        // Terapeuta
        $prof2 = Professional::create([
            'user_id' => $users['professionals'][1]->id,
            'bio' => 'Terapeuta certificada en masajes y tratamientos faciales',
            'phone' => '3007654321',
            'specialties' => ['masaje_relajante', 'facial', 'aromaterapia'],
            'is_available' => true,
        ]);
        $prof2->serviceCategories()->attach($categories['spa']->id);

        // Profesional mixto
        $prof3 = Professional::create([
            'user_id' => $users['professionals'][2]->id,
            'bio' => 'Instructor de tango y especialista en estética',
            'phone' => '3009876543',
            'specialties' => ['tango', 'manicure', 'pedicure'],
            'is_available' => true,
        ]);
        $prof3->serviceCategories()->attach([$categories['dance']->id, $categories['spa']->id]);

        $this->command->info('Profesionales creados');

        return [$prof1, $prof2, $prof3];
    }

    private function createSchedules($services, $professionals)
    {
        $schedules = [];

        // Salsa - Lunes y Miércoles 7pm
        $schedules[] = Schedule::create([
            'service_id' => $services['salsa']->id,
            'professional_id' => $professionals[0]->id,
            'day_of_week' => 1, // Lunes
            'start_time' => '19:00',
            'end_time' => '20:00',
            'room' => 'Sala A',
            'max_students' => 20,
            'recurrence_type' => 'weekly',
        ]);

        $schedules[] = Schedule::create([
            'service_id' => $services['salsa']->id,
            'professional_id' => $professionals[0]->id,
            'day_of_week' => 3, // Miércoles
            'start_time' => '19:00',
            'end_time' => '20:00',
            'room' => 'Sala A',
            'max_students' => 20,
            'recurrence_type' => 'weekly',
        ]);

        // Bachata - Martes y Jueves 8pm
        $schedules[] = Schedule::create([
            'service_id' => $services['bachata']->id,
            'professional_id' => $professionals[0]->id,
            'day_of_week' => 2, // Martes
            'start_time' => '20:00',
            'end_time' => '21:00',
            'room' => 'Sala B',
            'max_students' => 20,
            'recurrence_type' => 'weekly',
        ]);

        // Tango - Viernes 7pm
        $schedules[] = Schedule::create([
            'service_id' => $services['tango']->id,
            'professional_id' => $professionals[2]->id,
            'day_of_week' => 5, // Viernes
            'start_time' => '19:00',
            'end_time' => '20:30',
            'room' => 'Sala C',
            'max_students' => 15,
            'recurrence_type' => 'weekly',
        ]);

        $this->command->info('Horarios de clases creados');

        return $schedules;
    }

    private function createEnrollments($users, $schedules)
    {
        // Inscribir algunos clientes a las clases
        foreach ($users['clients'] as $index => $client) {
            if ($index < 3) {
                Enrollment::create([
                    'user_id' => $client->id,
                    'schedule_id' => $schedules[0]->id,
                    'enrollment_date' => now()->subDays(10),
                    'status' => 'active',
                    'expiration_date' => now()->addMonths(3),
                ]);
            }
        }

        $this->command->info('Inscripciones creadas');
    }

    private function createAppointments($services, $professionals, $users)
    {
        // Crear algunas citas de ejemplo
        Appointment::create([
            'service_id' => $services['masaje']->id,
            'professional_id' => $professionals[1]->id,
            'client_id' => $users['clients'][0]->id,
            'appointment_date' => now()->addDays(2)->toDateString(),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'status' => 'confirmed',
            'notes' => 'Primera vez',
        ]);

        Appointment::create([
            'service_id' => $services['facial']->id,
            'professional_id' => $professionals[1]->id,
            'client_id' => $users['clients'][1]->id,
            'appointment_date' => now()->addDays(3)->toDateString(),
            'start_time' => '14:00',
            'end_time' => '15:30',
            'status' => 'pending',
        ]);

        $this->command->info('Citas creadas');
    }

    private function createProducts()
    {
        $products = [];

        $products[] = Product::create([
            'name' => 'Membresía Mensual Completa',
            'description' => 'Acceso ilimitado a todas las clases de baile',
            'price' => 200000,
            'stock' => 999,
            'category' => 'memberships',
            'sku' => 'MEM-FULL-001',
            'is_active' => true,
        ]);

        $products[] = Product::create([
            'name' => 'Paquete 10 Clases',
            'description' => 'Paquete de 10 clases válido por 3 meses',
            'price' => 450000,
            'stock' => 100,
            'category' => 'packages',
            'sku' => 'PKG-10CLASS',
            'is_active' => true,
        ]);

        $products[] = Product::create([
            'name' => 'Kit de Productos Spa',
            'description' => 'Set completo de productos para el cuidado facial',
            'price' => 150000,
            'stock' => 25,
            'category' => 'cosmetics',
            'sku' => 'KIT-SPA-001',
            'is_active' => true,
        ]);

        $this->command->info('Productos creados');

        return $products;
    }

    private function createOrders($users, $services, $products)
    {
        // Crear una orden de ejemplo
        $order = Order::create([
            'user_id' => $users['clients'][0]->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total' => 450000,
            'status' => 'completed',
            'payment_method' => 'card',
            'order_type' => 'class_package',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'orderable_type' => Product::class,
            'orderable_id' => $products[1]->id,
            'quantity' => 1,
            'price' => 450000,
            'subtotal' => 450000,
        ]);

        $this->command->info('Órdenes creadas');
    }
}
