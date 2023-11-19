<?php

namespace App\Rules;

use App\Models\Contact;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckDuplicatesAttributes implements ValidationRule
{
    protected $groupId;



    public function __construct($groupId)
    {
        $this->groupId = $groupId;

    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $contact_exist = Contact::where('contact_group_id',$this->groupId)->where($attribute,$value)->exists();

            if($contact_exist)
            {
                $fail('This Phone Number is Already Exists for this Group');
            }
        //
    }
}
