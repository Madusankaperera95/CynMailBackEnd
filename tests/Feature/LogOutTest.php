<?php

namespace Tests\Feature;



use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\TestCase;

class LogOutTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_succesfully_logout(): void
    {
        $user = User::factory()->create();
        $response=$this->actingAs($user)->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->delete('/api/logout');
        $response->assertStatus(200);
    }

    public function test_should_user_should_logged_in_before_logout()
    {
        $user = User::factory()->create();
        $response=$this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->delete('/api/logout');
        $response->assertStatus(401);

    }
}
