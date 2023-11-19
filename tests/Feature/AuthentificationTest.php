<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthentificationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function test_can_create_an_account_succesfully(): void
    {
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register',['name' => 'Manoj Perera','email' => 'manoj@admin.com','password' => 'pass123','password_confirmation' => 'pass123' ]);
        $this->assertDatabaseHas('users',[
            'name' => 'Manoj Perera',
            'email' => 'manoj@admin.com'
        ]);
        $this->assertArrayHasKey('token',$response->json());
        $response->assertStatus(200);
    }

    public function  test_it_gives_validation_error_when_name_not_provided(){
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register',['email' => 'manoj@admin.com','password' => 'pass123','password_confirmation' => 'pass123' ]);
        $response->assertJsonValidationErrorFor('name');
    }

    public function  test_it_gives_validation_error_when_email_not_provided(){
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register',['name' => 'abc','password' => 'pass123','password_confirmation' => 'pass123' ]);
        $response->assertJsonValidationErrorFor('email');
    }

    public function  test_it_gives_validation_error_when_password_not_provided(){
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register',['name' => 'abc','email' => 'manoj@admin.com','password_confirmation' => 'pass123' ]);
        $response->assertJsonValidationErrorFor('password');
    }

    public function test_it_gives_validation_error_when_password_and_confirmation_does_not_match(){
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register',['name' => 'Manoj Perera','email' => 'manoj@admin.com','password' => 'pass123','password_confirmation' => 'abc' ]);
        $response->assertJsonValidationErrorFor('password');

    }


    public function test_it_need_the_required_parameters_for_registration(){

        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/register');
        $response->assertJsonValidationErrors(['name','email','password']);


    }
}
