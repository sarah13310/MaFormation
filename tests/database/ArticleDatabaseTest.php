<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\ArticleSeeder;
use Tests\Support\Models\ArticleModelTest;

/**
 * @internal
 */
final class ArticleDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $seed = ArticleSeeder::class; // On fabrique les données ici pour les tests

    public function testModelFindAll()
    {
        $model = new ArticleModelTest();
        // Get every row created by ExampleSeeder
        $objects = $model->where('status', 4)->findAll();
        // ici 3 éléments attendu
        $this->assertCount(3, $objects);
    }

    public function testDeleteLeavesRow()
    {
        $model = new ArticleModelTest();
        //
        $model->where('status', 4)->delete();
        // ... but it should still be in the database
        $objects = $model->where('status', 4)->findAll();
        //
        $this->assertCount(0, $objects);
    }


}
