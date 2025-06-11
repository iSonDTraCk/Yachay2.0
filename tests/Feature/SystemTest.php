<?php
namespace Tests\Feature;

use Tests\TestCase;

class SystemTest extends TestCase
{
    /** @test */
    public function it_displays_home_page_correctly()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Ñawinchay');
    }
}