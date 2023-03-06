<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'subject'    => 'test001',
                'description'     => 'test001',
                'datetime'=>'2023/02/28 09:00:08',
                'status' => '4',
            ],
            [
                'subject'    => 'test002',
                'description'     => 'test002',
                'datetime'=>'2023/02/28 09:20:38',
                'status' => '4',
            ],
            [
                'subject'    => 'test003',
                'description'     => 'test001',
                'datetime'=>'2023/02/28 09:10:08',
                'status' => '4',
            ],
            [
                'subject'    => 'test004',
                'description'     => 'test004',
                'datetime'=>'2023/02/28 09:15:08',
                'status' => '1',
            ],
            
        ];

        $builder = $this->db->table('article');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
