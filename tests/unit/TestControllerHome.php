<?php

namespace CodeIgniter;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class TestControllerHome extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    public function testPageHome()
    {
        $result = $this->withURI('http://locahost:8080')
            ->controller(\App\Controllers\Home::class)
            ->execute('index');

        $this->assertTrue($result->isOK());
    }
}