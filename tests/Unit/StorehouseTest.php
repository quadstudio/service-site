<?php

namespace QuadStudio\Service\Test\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use QuadStudio\Service\Site\Models\Storehouse;
use QuadStudio\Service\Site\Models\User;
use QuadStudio\Service\Test\TestCase;

class StorehouseTest extends TestCase
{

    //use DatabaseTransactions;


    /** @test */
    public function test(){

        $storehouse = Storehouse::query()->create();
        $this->assertInstanceOf(User::class, $storehouse->user);
    }
}