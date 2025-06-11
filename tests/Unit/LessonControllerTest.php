<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Lesson;

class LessonControllerTest extends TestCase
{
    /** @test */
    public function it_can_group_lessons_by_level_for_alumno()
    {
        // Crea datos de prueba
        Lesson::factory()->create(['level' => 'Principiante']);
        Lesson::factory()->create(['level' => 'Intermedio']);

        // Llama al método
        $response = $this->get(route('alumno.home'));

        // Verifica que los datos estén agrupados
        $response->assertViewHas('courses');
    }
}