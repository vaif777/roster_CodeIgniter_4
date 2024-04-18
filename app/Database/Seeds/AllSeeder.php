<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AllSeeder extends Seeder
{
    public function run()
    {
        $this->call('SupervisoryAuthoritySeeder');
        $this->call('SmallBusinessEntitySeeder');
        $this->call('RosterSeeder');
    }
}
