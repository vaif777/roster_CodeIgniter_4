<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class SupervisoryAuthoritySeeder extends Seeder
{
    public function run()
    {

        $data = [
            ['title' => 'Федеральная налоговая служба', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по труду и занятости', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по техническому и экспортному контролю', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба безопасности транспорта', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по ветеринарии', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по защите прав потребителей', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Роспотребнадзор', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по финансовому мониторингу', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Роскомнадзор', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по финансовым рынкам', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по тарифам', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по безопасности в транспортной сфере', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Росприроднадзор', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по техническому регулированию и метрологии', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по военно-техническому сотрудничеству', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Росстандарт', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Роспечать', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по контролю за оборотом наркотиков', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по управлению государственным имуществом', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Росгидромет', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Роспромнадзор', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Федеральная служба по гидрометеорологии и мониторингу окружающей среды', 'created_at' => Time::now(), 'updated_at' => Time::now()],
            ['title' => 'Росаккредитация', 'created_at' => Time::now(), 'updated_at' => Time::now()],
        ];

        $this->db->table('supervisory_authorities')->insertBatch($data);
    }
}
