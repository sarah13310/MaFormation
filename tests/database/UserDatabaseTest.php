<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\UserSeeder;
use Tests\Support\Models\UserModelTest;

/**
 * @internal
 */
final class UserDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $seed = UserSeeder::class; // On fabrique les données ici pour les tests

    public function testModelFindAll()
    {
        $model = new UserModelTest();
        // Get every row created by ExampleSeeder
        $objects = $model->where('type', 44)->findAll();
        // ici 3 éléments attendu
        $this->assertCount(3, $objects);
    }

    public function testDeleteLeavesRow()
    {
        $model = new UserModelTest();
        //
        $model->where('type', 44)->delete();
        // ... but it should still be in the database
        $objects = $model->where('type', 44)->findAll();
        //
        $this->assertCount(0, $objects);
    }


}
