<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddSuccess()
    {
        $this->post('/api/inventories', [
            'name' => 'Inventory1',
            'price' => 100000,
            'amount' => 25,
            'unit' => 'kg'
        ])->assertJson([
            'data' => [
                'name' => 'Inventory1',
                'price' => 100000,
                'amount' => 25,
                'unit' => 'kg'
            ]
        ]);
    }

    public function testAddFailed()
    {
        
    }
}
