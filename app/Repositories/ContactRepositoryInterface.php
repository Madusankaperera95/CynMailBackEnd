<?php

namespace App\Repositories;

interface ContactRepositoryInterface
{

    public function createContact($contactGroupId, array $data);
    public function getContacts($contactGroupId);
    public function getContactDetails($contactGroupId, $contactId);
    public function deleteContact($contactGroupId, $contactId);
    public function updateContact($contactGroupId, $contactId, array $data);

}
