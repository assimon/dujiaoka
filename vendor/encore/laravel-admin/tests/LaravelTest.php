<?php

class LaravelTest extends TestCase
{
    public function testLaravel()
    {
        $this->visit('/')
            ->assertResponseStatus(200)
            ->see('Laravel');
    }
}
