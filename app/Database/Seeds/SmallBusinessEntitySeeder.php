<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;

class SmallBusinessEntitySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ru_RU');

        for ($i = 0; $i < 40; $i++) {
            $data[] = [
                'title' => $faker->unique()->company(),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        $this->db->table('small_business_entities')->insertBatch($data);
    }
}
