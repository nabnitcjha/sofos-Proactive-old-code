<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where('email','admin@proactive.com')->first();
        if(!$user){
            $user = new User();
        }
        $user->name = 'Sofos Software';
        $user->email = 'admin@proactive.com';
        $user->password = bcrypt('proactive@admin123');
        $user->user_status = 1;
        $user->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        $user->assignRole('admin');
        $role = Role::findByName('admin');
        $role->givePermissionTo(['create','read','update','delete']);
    }
}
