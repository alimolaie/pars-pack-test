<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscribeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = array(
            array('id' =>1, 'app_id' => 1, 'platform_id' => 2,'user_id'=>1,'subscription_status'=>'active'),
            array('id' =>2, 'app_id' => 2, 'platform_id' => 1,'user_id'=>2,'subscription_status'=>'pending'),
            array('id' =>3, 'app_id' => 3, 'platform_id' => 1,'user_id'=>3,'subscription_status'=>'expired'),
        );
        foreach ($resource as $item) {
            DB::table('application')->insert($item);
        }
    }
}
