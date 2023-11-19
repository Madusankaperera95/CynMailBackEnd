<?php

namespace App\Repositories;

class ContactRepository implements ContactRepositoryInterface
{

    public function createContact($contactGroupId, array $data)
    {
        $path = $data['photo'] ? $data['photo']->store('Images', 'public') : null;

        return auth()->user()
            ->contactGroups()
            ->where('id', $contactGroupId)
            ->first()
            ->contacts()
            ->create([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'photo' => $path,
                'address' => $data['address'],
            ]);
    }

    public function getContacts($contactGroupId)
    {
        $contacts = auth()->user()
            ->contactGroups()
            ->where('id', $contactGroupId)
            ->first()
            ->contacts()
            ->get();

        return $contacts->map(function ($contact) {
            $contact->photo = asset('storage/' . $contact->photo);
            return $contact;
        });
    }

    public function getContactDetails($contactGroupId, $contactId)
    {
        return auth()->user()
            ->contactGroups()
            ->where('id', $contactGroupId)
            ->first()
            ->contacts()
            ->where('id', $contactId)
            ->first();
    }

    public function deleteContact($contactGroupId, $contactId)
    {
        auth()->user()
            ->contactGroups()
            ->where('id', $contactGroupId)
            ->first()
            ->contacts()
            ->where('id', $contactId)
            ->delete();
    }

    public function updateContact($contactGroupId, $contactId, array $data)
    {
        $path = $data['photo'] ? $data['photo']->store('Images', 'public') : null;

        auth()->user()
            ->contactGroups()
            ->where('id', $contactGroupId)
            ->first()
            ->contacts()
            ->where('id', $contactId)
            ->update([
                'firstName' => $data['firstName'],
                'lastName' => $data['lastName'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'photo' => $path,
                'address' => $data['address'],
            ]);
    }
}
