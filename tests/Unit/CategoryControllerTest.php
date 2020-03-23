<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Category;
use Tests\TestCase;

class CategoryControllerTest extends TestCase {
    use DatabaseMigrations;

    private function insertCategory() {
        $token = $this->createUser();

        $response = $this->post('/categories', [
            'name' => 'Lorem'
        ], $this->headers($token));

        $response->assertStatus(201);
    }

    public function testCanListCategories() {
        $this->insertCategory();

        $token = $this->createUser();

        $response = $this->get('/categories', $this->headers($token));

        $response->assertStatus(200);
    }

    private function createUser() {
        $response = $this->post('/register', [
            'name' => 'Lorem',
            'email' => rand().'@test.com',
            'password' => 'test',
        ]);

        $content = json_decode($response->getContent());

        return $content->token;
    }

    protected function headers($token = null) {
        $headers['Authorization'] = 'Bearer '.$token;

        return $headers;
    }
}
