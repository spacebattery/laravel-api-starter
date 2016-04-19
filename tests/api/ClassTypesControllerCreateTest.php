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
        $token = $this->login('admin');

        $name = factory(ClassType::class)->make()->name;
        $this->json('POST', $this->url, [
            'name' => $name
        ], [
            'Authorization' => 'Bearer '.$token
        ])->seeJsonStructure([
            'id', 'name', 'created_at', 'updated_at'
        ])->assertResponseStatus(201);
        $this->seeInDatabase('class_types', ['name' => $name]);
    }

    public function testFailedNameUnique() {
        $token = $this->login('admin');

        $name = ClassType::orderByRaw("RAND()")->first()->name;
        $this->json('POST', $this->url, [
            'name' => $name
        ], [
            'Authorization' => 'Bearer ' . $token
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
    }

    public function testFailedNameRequired() {
        $token = $this->login('admin');

        $this->json('POST', $this->url, [
        ], [
            'Authorization' => 'Bearer ' . $token
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
        /*
        ->seeJsonEquals([
            'name' => ['The name field is required.']

        ])
         */
    }

    public function testFailedNameMin() {
        $token = $this->login('admin');

        $this->json('POST', $this->url, [
            'name' => 'a'
        ], [
            'Authorization' => 'Bearer ' . $token
        ])->seeJsonStructure([
            'name' => ['*' => []]
        ])->assertResponseStatus(422);
    }

    public function testFailedAuthentication() {
        $name = factory(ClassType::class)->make()->name;
        $this->json('POST', $this->url, [
            'name' => $name
        ])->assertResponseStatus(400);

        $this->json('POST', $this->url, [
            'name' => $name
        ], [
            'Authorization' => 'Bearer ' . 'abcd'
        ])->assertResponseStatus(400);
    }
}
