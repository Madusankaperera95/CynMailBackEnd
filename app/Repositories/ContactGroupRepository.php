<?php

namespace App\Repositories;

use App\Models\ContactGroup;

class ContactGroupRepository implements ContactGroupInterface
{

    public function getAllContactGroups()
    {
        return auth()->user()->contactGroups()->get();
    }

    public function create(array $data)
    {
        return auth()->user()->contactGroups()->create($data);
    }

    public function update(string $id, array $data)
    {
        ContactGroup::where('id', $id)->update($data);
    }

    public function delete(string $id)
    {
        ContactGroup::where('id', $id)->delete();
    }

}
