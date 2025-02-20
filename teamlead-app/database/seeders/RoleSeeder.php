<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Создаем роли
        $admin = Role::create(['name' => 'admin']);
        $teamlead = Role::create(['name' => 'teamlead']);
        $member = Role::create(['name' => 'member']);

        // Создаем разрешения
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage teams']);
        Permission::create(['name' => 'manage projects']);
        Permission::create(['name' => 'manage tasks']);

        // Назначаем разрешения ролям
        $admin->givePermissionTo(['manage users', 'manage teams', 'manage projects', 'manage tasks']);
        $teamlead->givePermissionTo(['manage teams', 'manage projects', 'manage tasks']);
        $member->givePermissionTo(['manage tasks']);
    }
}

