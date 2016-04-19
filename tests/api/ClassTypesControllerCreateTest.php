<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\ClassType;

class ClassTypesControllerCreateTest extends TestCase
{
    use DatabaseTransactions;

    private $url = '/api/classTypes';

    public function testSuccess() {
        $name = factory(ClassType::class)->make()->name;
        $this->json('POST', $this->url, [
            'name' => $name
        ])->seeJsonStructure([
            'id', 'name', 'created_at', 'updated_at'
        ])->assertResponseStatus(201);
        $this->seeInDatabase('class_types', ['name' => $name]);
    }

    public function testFailedNameUnique() {
        $name = ClassType::orderByRaw("RAND()")->first()->name;
        $this->json('POST', $this->url, [
            'name' => $name
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
    }

    public function testFailedNameRequired()
    {
        $this->json('POST', $this->url, [
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
        /*
        ->seeJsonEquals([
            'name' => ['The name field is required.']

        ])
         */
    }

    public function testFailedNameMin()
    {
        $this->json('POST', $this->url, [
            'name' => 'a'
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
    }
}
