<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactGroupManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_it_can_create_a_contact_group_successfully(): void
    {
        $user = User::factory()->create();
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->postJson('/api/contactGroups',['groupName' => 'ABC Group']);
        $response->assertStatus(201);
        $this->assertDatabaseHas('contact_groups',['groupName' => 'ABC Group']);
    }

    public function test_it_cannot_create_a_contact_group_from_a_same_name()
    {
        $user = User::factory()->create();
        $user->contactGroups()->create(['groupName' => $group ='ABC Group']);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->postJson('/api/contactGroups',['groupName' => $group]);
        $response->assertJsonValidationErrorFor('groupName');

    }


    public function test_should_pass_group_name_as_parameter_when_creating_a_new_group_name()
    {
        $user = User::factory()->create();
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->postJson('/api/contactGroups');
        $response->assertJsonValidationErrorFor('groupName');
    }

    public function test_it_retrive_all_contacts_for_a_specifc_user(){
        $user = User::factory()->create();
        $group1 = 'ABC Group';
        $group2 = 'XYZ Group';
        $user->contactGroups()->create(['groupName' => $group1]);
        $user->contactGroups()->create(['groupName' => $group2]);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->getJson('/api/contactGroups');
        $response->assertStatus(200);
    }

    public function test_it_updates_a_record_successfully(){
        $user = User::factory()->create();
        $group1 = 'ABC Group';
        $group2 = 'XYZ Group';
        $contctgroup1 = $user->contactGroups()->create(['groupName' => $group1]);
        $contctgroup2 = $user->contactGroups()->create(['groupName' => $group2]);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->putJson("/api/contactGroups/{$contctgroup1->id}",['groupName' => 'LatestGroup']);
        $this->assertDatabaseHas('contact_groups',['groupName' => 'LatestGroup']);
        $response->assertStatus(200);
    }

    public function test_it_cannnot_update_same_name_groups(){
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $group1 = 'ABC Group';
        $group2 = 'XYZ Group';
        $contctgroup1 = $user1->contactGroups()->create(['groupName' => $group1]);
        $contctgroup2 = $user2->contactGroups()->create(['groupName' => $group2]);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user1)->deleteJson("/api/contactGroups/{$contctgroup1->id}",['groupName' => $group2]);
//        $this->assertDatabaseHas('contact_groups',['groupName' => 'LatestGroup']);
        $response->assertStatus(200);
    }

    public function test_it_cn_delete_a_group_name_succesfully(){
        $user = User::factory()->create();
        $contctgroup = $user->contactGroups()->create(['groupName' => 'ABC Group']);
        $response = $this->withHeaders(['Accept'=>'application/json','Content-Type' => 'application/json'])->actingAs($user)->deleteJson("/api/contactGroups/{$contctgroup->id}");
        $this->assertDatabaseMissing('contact_groups',['groupName' => 'ABC Group']);
     }
}
