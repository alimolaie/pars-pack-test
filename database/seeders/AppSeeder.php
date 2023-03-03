<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = array(
            array('id' =>1, 'app_name' => 'Vison', 'platform_id' => 2),
            array('id' =>2, 'app_name' => 'sib app', 'platform_id' =>1),
        );
        foreach ($resource as $item) {
            DB::table('application')->insert($item);
        }
    }
}
