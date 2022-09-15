<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StudentTest extends TestCase
{
    use DatabaseMigrations;

    private $student;

    protected function setUp(): void
    {
        parent::setUp();
        $this->student = Student::factory()->create();

    }

    public function testStoreStudentRecord(): void
    {
        $data = ['student' => [
            'first_name' => $this->student->first_name ,
            'last_name' => $this->student->last_name,
            'identification_no' => $this->student->identification_no,
            'country' => $this->student->country,
            'date_of_birth' => $this->student->date_of_birth,
            'registered_on' => $this->student->registered_on,
        ]];

        $response = $this->json('POST', 'api/store', $data['student'], ['Accept' => 'application/json']);
        $response->assertStatus(201);
        $this->assertDatabaseHas('students',
            [
                'first_name' => $data['student']['first_name'],
                'last_name' => $data['student']['last_name'],
                'identification_no' => $data['student']['identification_no'],
                'country' => $data['student']['country'],
                'date_of_birth' => $data['student']['date_of_birth'],
                'registered_on' => $data['student']['registered_on']
            ]
        );
    }

    public function testUpdateStudentRecord(): void
    {
        $data = ['student' => [
            'first_name' => $this->student->first_name ,
            'last_name' => $this->student->last_name,
            'identification_no' => $this->student->identification_no,
            'country' => $this->student->country,
            'date_of_birth' => $this->student->date_of_birth,
            'registered_on' => $this->student->registered_on,
        ]];

        $this->json('POST', 'api/upate', $data['student'], ['Accept' => 'application/json']);

        $student = Student::first();

        var_dump($student->id);

        $upDateData = ['student' => [
            'first_name' => "Jane" ,
            'last_name' => "Newman",
            'identification_no' => $this->student->identification_no,
            'country' => $this->student->country,
            'date_of_birth' => $this->student->date_of_birth,
            'registered_on' => $this->student->registered_on,
        ]];

        $response = $this->json('POST', 'api/update/'.$student->id, $upDateData['student'], ['Accept' => 'application/json']);
        $response->assertStatus(200);
    }
}
