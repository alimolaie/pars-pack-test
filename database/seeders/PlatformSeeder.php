<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resource = array(
            array('id' => 1,'platform_os' => 'iOS'),
            array('id' => 2,'platform_os' => 'android'),
        );
        foreach ($resource as $item) {
            DB::table('platform')->insert($item);
        }
    }
}
