<?php

namespace Database\Seeders;

use App\Models\detail_regu;
use App\Models\jabatan;
use App\Models\jabatan_tugas;
use App\Models\pangkat;
use App\Models\regu;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = jabatan::create([
            'name' => 'Bina Ketertiban Umum dan Ketentraman Masyarakat',
            'detail' => 'Staf Bidang'
        ]);

        $user = User::create([
            'name' => 'Puspita Sari',
            'nip' => '3129002016',
            'id_jabatan' => $jabatan->id,
            'email' => 'puspitasari@yopmail.com',
            'password' => bcrypt('puspita')
        ]);

        // $jabatan = jabatan::find(1);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::whereIn('id', [1, 2, 3, 4])->pluck('id')->toArray();
        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
