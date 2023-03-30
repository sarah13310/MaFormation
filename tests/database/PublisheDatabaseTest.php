<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\PublisheSeeder;
use Tests\Support\Models\PublisheModelTest;

/**
 * @internal
 */
final class PublisheDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $seed = PublisheSeeder::class; // On fabrique les données ici pour les tests

    public function testModelFindAll()
    {
        $model = new PublisheModelTest();
        // Get every row created by ExampleSeeder
        $objects = $model->where('status', 4)->findAll();
        // ici 3 éléments attendu
        $this->assertCount(3, $objects);
    }

    public function testDeleteLeavesRow()
    {
        $model = new PublisheModelTest();
        //
        $model->where('status', 4)->delete();
        // ... but it should still be in the database
        $objects = $model->where('status', 4)->findAll();
        //
        $this->assertCount(0, $objects);
    }


}
