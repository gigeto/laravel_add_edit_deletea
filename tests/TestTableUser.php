<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestTableUser extends TestCase {
    
    public function testUserTable($param) {

        $this->assertDatabaseHas('products', [
            'id' => '1'
        ]);
    }
    
}
