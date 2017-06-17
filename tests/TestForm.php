<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestForm extends TestCase {
    
    public function testGetInput()
    {
        $requestParams = [
            'links' => "http://adcash/"
        ];

        \Request::shouldReceive('all')->once()->andReturn($requestParams);

        $class = App::make('HomeController');

        $return = $class->getInput();

        $this->assertInstanceOf('HomeController', $return);

        // Now test all the things.
        $this->assertTrue(isset($return->startLinks));
        $this->assertTrue(is_array($return->startLinks));
        $this->assertTrue(in_array('http://adcash/', $return->startLInks));

    }
}
