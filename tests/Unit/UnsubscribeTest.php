<?php

namespace QuadStudio\Service\Test\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use QuadStudio\Service\Site\Models\Unsubscribe;
use QuadStudio\Service\Test\TestCase;

class UnsubscribeTest extends TestCase
{

    use DatabaseTransactions;


    /** @test */
    public function test(){

        $unsubscribe = Unsubscribe::create(['email' => 'test@test.ru']);
        $this->assertEquals('test@test.ru', $unsubscribe->email);
    }
}