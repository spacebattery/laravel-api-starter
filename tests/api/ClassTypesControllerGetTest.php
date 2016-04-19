<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\ClassType;

class ClassTypesControllerGetTest extends TestCase
{
    use DatabaseTransactions;

    private $url = '/api/classTypes';

    public function testDefaultSearch() {
        $token = $this->login('admin');

        $this->json('GET', $this->url, [], [
            'Authorization' => 'Bearer '.$token
        ])->seeJsonStructure([
            'total', 'per_page', 'current_page', 'last_page',
            'next_page_url', 'prev_page_url', 'from', 'to',
            'data' => [
                '*' => [
                    'id', 'name', 'created_at', 'updated_at'
                ]
            ]
        ])->assertResponseStatus(200);
    }

    public function testFailedAuthentication() {
        $this->json('GET', $this->url)->assertResponseStatus(400);

        $this->json('GET', $this->url, [
            'Authorization' => 'Bearer ' . 'abcd'
        ])->assertResponseStatus(400);
    }
}
