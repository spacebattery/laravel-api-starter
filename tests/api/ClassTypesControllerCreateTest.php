<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\ClassType;

class ClassTypesControllerCreateTest extends TestCase
{
    use DatabaseTransactions;

    public function testSuccess() {
        $name = factory(ClassType::class)->make()->name;
        $this->json('POST', '/api/classTypes', [
            'name' => $name
        ])->seeJsonStructure([
            'id', 'name', 'created_at', 'updated_at'
        ])->assertResponseStatus(201);
        $this->seeInDatabase('class_types', ['name' => $name]);
    }

    public function testFailedNameUnique() {
        $name = ClassType::orderByRaw("RAND()")->first()->name;
        $this->json('POST', '/api/classTypes', [
            'name' => $name
        ])->seeJsonStructure([
            'name'
        ])->assertResponseStatus(422);
    }

    public function testFailedNameRequired()
    {
        $this->json('POST', '/api/classTypes', [
        ])->seeJsonStructure([
            'name'
        ])->assertResponseStatus(422);
        /*
        ->seeJsonEquals([
            'name' => ['The name field is required.']

        ])
         */
    }

    public function testFailedNameMin()
    {
        $this->json('POST', '/api/classTypes', [
            'name' => 'a'
        ])->seeJsonStructure([
            'name'
        ])->assertResponseStatus(422);
    }
}
