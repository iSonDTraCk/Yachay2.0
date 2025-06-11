<?php
namespace Tests\Feature;

use Tests\TestCase;

class LessonIntegrationTest extends TestCase
{
    /** @test */
    public function it_can_store_a_new_lesson()
    {
        $data = [
            'university' => 'Yachay Wasi',
            'level' => 'Principiante',
            'title' => 'Clase de Quechua',
            'description' => 'Aprenderás lo básico del idioma.',
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-30',
        ];

        $response = $this->post(route('lessons.store'), $data);
        $response->assertRedirect(route('profesor.home'));
        $this->assertDatabaseHas('lessons', $data);
    }
}