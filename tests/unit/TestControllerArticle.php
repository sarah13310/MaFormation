<?php

namespace CodeIgniter;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class TestControllerArticle extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testPageArticle()
    {
        $result = $this->withURI('http://locahost:8080/article/list')
            ->controller(\App\Controllers\News::class)
            ->execute('list_articles_home');

        $this->assertTrue($result->isOK());
    }
}