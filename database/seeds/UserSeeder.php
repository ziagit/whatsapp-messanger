<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'admin@tingsapp.com',
            'password'=>Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'name'=>'Support 1',
            'email'=>'support1@tingsapp.com',
            'password'=>Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'name'=>'Support 2',
            'email'=>'support2@tingsapp.com',
            'password'=>Hash::make('12345678'),
        ]);
        DB::table('users')->insert([
            'name'=>'Mover A',
            'email'=>'Mover@gmail.com',
            'password'=>Hash::make('12345678'),
        ]);

        $admin = User::find(1);
        $admin_role = Role::find(1);
        $admin->roles()->attach($admin_role);

        $support1 = User::find(2);
        $support2 = User::find(3);
        $support_role = Role::find(2);
        $support1->roles()->attach($support_role);
        $support2->roles()->attach($support_role);

        $mover = User::find(4);
        $user_role = Role::find(3);
        $mover->roles()->attach($user_role);
    }
}
