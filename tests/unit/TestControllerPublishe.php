<?php

namespace CodeIgniter;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class TestControllerPublishe extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testPagePublishe()
    {
        $result = $this->withURI('http://locahost:8080/publishes/list')
            ->controller(\App\Controllers\News::class)
            ->execute('list_publishes_home');
        
        $this->assertTrue($result->isOK());
    }
}