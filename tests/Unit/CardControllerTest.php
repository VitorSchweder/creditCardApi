<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

use App\Card;
use App\Category;
use Tests\TestCase;

class CardControllerTest extends TestCase {
    use DatabaseMigrations;

    public function testCanInsertCard() {
        $this->insertCategory();
        $this->insertCard();
    }

    public function testCanListCards() {
        $this->insertCategory();
        $this->insertCard();

        $token = $this->createUser();

        $response = $this->get('/cards', $this->headers($token));

        $response->assertStatus(200);
    }

    public function testCanShowCard() {
        $this->insertCategory();
        $this->insertCard();

        $token = $this->createUser();

        $response = $this->get('/cards/1/show', $this->headers($token));

        $response->assertStatus(200);
    }

    public function testCanDeleteCard() {
        $this->insertCategory();
        $this->insertCard();

        $token = $this->createUser();

        $response = $this->post('/cards/1/delete', [
            '_method'  => 'DELETE',
        ], $this->headers($token));

        $response->assertStatus(200);
    }

    public function testCanUpdateCard() {
        $this->insertCategory();
        $this->insertCard();

        $token = $this->createUser();

        $response = $this->post('/cards/1/update', [
            '_method'  => 'PUT',
            'name'     => 'Another',
            'brand'    => 'Mastercard',
            'category' => 1,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ], $this->headers($token));

        $response->assertStatus(200);
    }

    private function insertCategory() {
        $token = $this->createUser();

        $response = $this->post('/categories', [
            'name' => 'Lorem'
        ], $this->headers($token));

        $response->assertStatus(201);
    }

    private function insertCard() {
        $token = $this->createUser();

        $response = $this->post('/cards', [
            'name'     => 'Lorem',
            'brand'    => 'Visa',
            'category' => 1,
            'image' => $file = UploadedFile::fake()->image('image.jpg', 1, 1)
        ], $this->headers($token));

        $response->assertStatus(201);
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
