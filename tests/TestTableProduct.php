<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TestTableProducts extends TestCase {
    
    public function testProductsTable($param) {

        $this->assertDatabaseHas('products', [
            'id' => '2',
            'name' => 'Pepsi Cola'
        ]);
    }
    
}
