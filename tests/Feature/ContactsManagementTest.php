<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ContactsManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_it_can_create_a_contact_successfully(): void
    {
        $user = User::factory()->create();
        $contactgroup = $user->contactGroups()->create(['groupName' => 'ABC group']);
        Storage::fake('public');

        $image = UploadedFile::fake()->image('sample.jpg');
        $contactDetails = ['firstName' => 'Kamal','lastName' => 'Perera','phone' => '0782234567','email' => 'kamal@gmail.com', 'photo' => $image,'address' => 'Galle Rd,Colombo'];
        $response = $this->actingAs($user)->postJson("/api/contactGroup/{$contactgroup->id}/contact",$contactDetails);
        Storage::assertExists('Images/' . $image->hashName());
        $this->assertDatabaseHas('contacts',['firstName' => 'Kamal','lastName' => 'Perera']);
        $response->assertStatus(201);
    }

    public function test_it_retreive_all_contacts_for_a_contact_group(){
        $user = User::factory()->create();
        $contactGroup = ContactGroup::factory()->create(['user_id' => $user->id]);
        $contact1 = Contact::factory()->create(['contact_group_id' => $contactGroup->id]);
        $contact2 = Contact::factory()->create(['contact_group_id' => $contactGroup->id]);
        $response = $this->actingAs($user)->getJson("/api/contactGroup/{$contactGroup->id}/contacts");
        $this->assertDatabaseCount('contacts',2);
        $response->assertStatus(200);
   }

   public function test_it_retrieve_all_data_for_a_specific_contact_id()
 {
     $user = User::factory()->create();
     $contactGroup = ContactGroup::factory()->create(['user_id' => $user->id]);
     $contact = Contact::factory()->create(['contact_group_id' => $contactGroup->id]);
     $response = $this->actingAs($user)->get("/api/contactGroup/{$contactGroup->id}/contact/$contact->id");
     $response->assertStatus(200);
//     $response->assertJson(['status' => true, "contacts" => 'dsd']);

 }

 public function test_it_delete_a_record_sucessfully(){
     $user = User::factory()->create();
     $contactGroup = ContactGroup::factory()->create(['user_id' => $user->id]);
     $contact = Contact::factory()->create(['contact_group_id' => $contactGroup->id]);
     $response = $this->actingAs($user)->delete("/api/contactGroup/{$contactGroup->id}/contact/$contact->id");
     $response->assertStatus(200);
     $this->assertDatabaseCount('contacts',0);
}

    public function test_it_update_a_record_sucessfully(){
        $user = User::factory()->create();
        $contactGroup = ContactGroup::factory()->create(['user_id' => $user->id]);
        $contact = Contact::factory()->create(['contact_group_id' => $contactGroup->id]);
        $image = UploadedFile::fake()->image('sample.jpg');
        $contactDetails = ['firstName' => 'Kamal','lastName' => 'Perera','phone' => '0782234567','email' => 'kamal@gmail.com', 'photo' => $image,'address' => 'Galle Rd,Colombo'];
        $response = $this->actingAs($user)->putJson("/api/contactGroup/{$contactGroup->id}/contact/$contact->id",$contactDetails);
        $response->assertStatus(200);
        $this->assertDatabaseHas('contacts',['firstName' => 'Kamal']);
//        $this->assertDatabaseCount('contacts',0);
    }
}
