<?php

namespace Tests\Support\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $factories = [
            [
                'name'    => 'test001',
                'firstname'     => 'test001',
                'type'   => '44',
                'mail'=>"user01@lesite.fr",
                'password'=>'$2y$10$v4jEyeYBxzdwamHHvST5lukQE3j4OXEQDIBl5Mi06SaP587HJgctK',                
                'status' => '1',
            ],
            [
                'name'    => 'test002',
                'firstname'     => 'test002',
                'type'   => '44',
                'mail'=>"user02@lesite.fr",
                'password'=>'$2y$10$v4jEyeYBxzdwamHHvST5lukQE3j4OXEQDIBl5Mi06SaP587HJgctK',                
                'status' => '1',
            ],
            [
                'name'    => 'test003',
                'firstname'     => 'test003',
                'type'   => '44',
                'mail'=>"user03@lesite.fr",
                'password'=>'$2y$10$v4jEyeYBxzdwamHHvST5lukQE3j4OXEQDIBl5Mi06SaP587HJgctK',                
                'status' => '1',
            ],
            
        ];

        $builder = $this->db->table('user');

        foreach ($factories as $factory) {
            $builder->insert($factory);
        }
    }
}
