<?php

namespace Tests\Unit;


use App\Models\User;
use App\Rules\CheckDuplicatesAttributes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CheckDuplicateValidation extends TestCase
{
  use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_it_fails_when_phone_from_same_contact_group_is_inputed_as_validtion(): void
    {
        $user = User::factory()->create();
        $contactGroup = $user->contactGroups()->create(['groupName' => 'ABC Group']);
        $phone = '0912259966';
        $contact = $contactGroup->contacts()->create(['firstName' => 'Dunesh','lastName' => 'Sharma','phone' => $phone,'photo' => 'sample.jpg','email' => 'ddsharna@gmail.com','address' => 'No 10, Gamini Rd,Colombo']);
        $validator = Validator::make(['phone' => $phone],['phone'=> ['required',new CheckDuplicatesAttributes($contactGroup->id,)]]);
        $this->assertTrue($validator->fails());

    }

    public function test_it_passes_when_phone_form_diffrent_contact_group_is_inputed_as_validtion(){
        $user = User::factory()->create();
        $contactGroup1 = $user->contactGroups()->create(['groupName' => 'ABC Group']);
        $contactGroup2 = $user->contactGroups()->create(['groupName' => 'XYZ Group']);
        $phone = '0912259966';
        $contact = $contactGroup1->contacts()->create(['firstName' => 'Dunesh','lastName' => 'Sharma','phone' => $phone,'photo' => 'sample.jpg','email' => 'ddsharna@gmail.com','address' => 'No 10, Gamini Rd,Colombo']);
        $validator = Validator::make(['phone' => $phone],['phone'=> ['required',new CheckDuplicatesAttributes($contactGroup2->id)]]);
        $this->assertTrue($validator->passes());
    }

    public function test_it_fails_when_email_from_same_contact_group_is_inputed_as_validtion(): void
    {
        $user = User::factory()->create();
        $contactGroup = $user->contactGroups()->create(['groupName' => 'ABC Group']);
        $phone = '0912259966';
        $email = 'admin@gmail.com';
        $contact = $contactGroup->contacts()->create(['firstName' => 'Dunesh','lastName' => 'Sharma','phone' => $phone,'photo' => 'sample.jpg','email' => $email,'address' => 'No 10, Gamini Rd,Colombo']);
        $validator = Validator::make(['email' => $email],['phone'=> ['required',new CheckDuplicatesAttributes($contactGroup->id,)]]);
        $this->assertTrue($validator->fails());
    }

    public function test_it_fails_when_email_from_diffrent_contact_group_is_inputed_as_validtion(): void
    {
        $user = User::factory()->create();
        $contactGroup1 = $user->contactGroups()->create(['groupName' => 'ABC Group']);
        $contactGroup2 = $user->contactGroups()->create(['groupName' => 'XYZ Group']);
        $phone = '0912259966';
        $email = 'admin@gmail.com';
        $contact = $contactGroup1->contacts()->create(['firstName' => 'Dunesh','lastName' => 'Sharma','phone' => $phone,'photo' => 'sample.jpg','email' => $email,'address' => 'No 10, Gamini Rd,Colombo']);
        $validator = Validator::make(['email' => $email],['email'=> ['required',new CheckDuplicatesAttributes($contactGroup2->id)]]);
        $this->assertTrue($validator->passes());
    }
}
