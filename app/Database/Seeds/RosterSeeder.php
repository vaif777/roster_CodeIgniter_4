<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;

class RosterSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('ru_RU'); // Создаем объект Faker с русскими данными
        $smallBusinessEntitiesCount = $this->db->table('small_business_entities')->countAll();
        $supervisoryAuthoritiessCount = $this->db->table('supervisory_authorities')->countAll();
       
        for ($i = 0; $i < 1000; $i++) {

            $from = $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d');
            $timestamp = strtotime($from) + (24 * 3600 * rand(1, 20));
            $before = date('Y-m-d', $timestamp );

            $data[] = [
                'small_business_entity_id' => rand(1, $smallBusinessEntitiesCount),
                'supervisory_authority_id' => rand(1, $supervisoryAuthoritiessCount),
                'planned_verification_period_from' => $from, 
                'planned_verification_period_before' => $before,
                'planned_duration_check' => rand(1, 20),
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
        }

        $this->db->table('rosters')->insertBatch($data);
    }
}
