<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PublisheSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'subject'    => 'publishe01',
                'description'     => 'test001',
                'datetime'=>'2023/02/28 09:00:08',
                'status' => '4',
            ],
            [
                'subject'    => 'publishe02',
                'description'     => 'test002',
                'datetime'=>'2023/02/28 09:20:38',
                'status' => '4',
            ],
            [
                'subject'    => 'publishe03',
                'description'     => 'test003',
                'datetime'=>'2023/02/28 09:10:08',
                'status' => '4',
            ],
            [
                'subject'    => 'publishe04',
                'description'     => 'test004',
                'datetime'=>'2023/02/28 09:15:08',
                'status' => '1',
            ],
            
        ];

        $builder = $this->db->table('publication');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
