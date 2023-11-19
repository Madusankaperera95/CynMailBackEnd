<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_is_succesfull(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make($password = 'testme123!'),
        ]);

        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/login',['email' => $user->email,'password' => $password]);

        $response->assertStatus(200);
    }

    public function test_login_needs_email_and_password_as_credentials(): void
    {

        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/login');

        $response->assertJsonValidationErrors(['email','password']);
    }

    public function test_login_needs_correct_password_to_continue(): void
    {

        $user = User::factory()->create([
            'password' => Hash::make($password = 'testme123!'),
        ]);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->postJson('/api/login',['email' => $user->email,'password' => '12345']);

        $response->assertStatus(401);
        $this->assertArrayHasKey('message',$response->json());
    }
}
