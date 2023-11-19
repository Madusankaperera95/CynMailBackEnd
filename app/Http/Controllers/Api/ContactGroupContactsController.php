<?php

namespace App\Http\Controllers\Api;

use App\Events\NewContactRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Repositories\ContactRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class ContactGroupContactsController extends Controller
{

    private $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Store a Newly Created Contact and Trigger Event to send the Number of Contacts as a email
     *
     * @param  ContactRequest $request
     *  @param String $contactGroupId
     * @return mixed
     */
    public function store(ContactRequest $request, string $contactGroupId)
    {

        $contact = $this->contactRepository->createContact($contactGroupId,$request->all());

        event(new NewContactRegistered(auth()->user()->contactGroups()->where('id',$contactGroupId)->first(),$contact));

        return response()->json(['status' => true,'contact' =>$contact],Response::HTTP_CREATED);
    }

    /**
     * Get All Contacts
     *
     * @param  String $contactGroupId
     * @return mixed
     */

    public function getContacts(string $contactGroupId)
    {
        $contacts = $this->contactRepository->getContacts($contactGroupId);
        return  response()->json(['status' => true,'contacts' => $contacts],Response::HTTP_OK);


    }

    /**
     * Get Contact Details
     *
     * @param  string $contactGroupId
     * @param  string $contactId
     * @return mixed
     */

    public function getContactDetails(string $contactGroupId,string $contactId)
    {
          $contact = $this->contactRepository->getContactDetails($contactGroupId,$contactId);
          return response()->json(['status' => true,'contacts' => $contact],Response::HTTP_OK);
    }

    /**
     * Delete a Contact
     *
     * @param  string $contactGroupId
     * @param  string $contactId
     * @return mixed
     */

    public function destroy(string $contactGroupId,string $contactId)
    {
        $this->contactRepository->deleteContact($contactGroupId,$contactId);
        return response()->json(['status' => true,'message' => 'Record Deleted Successfully'],Response::HTTP_OK);
    }


    /**
     * Update a Contact
     *
     * @param  string $contactGroupId
     * @param  string $contactId
     * @return mixed
     */
    public function update(ContactRequest $request,$contactGroupId,$contactId)
    {
        $this->contactRepository->updateContact($contactGroupId,$contactId,$request->all());
        return response()->json(['status' => true,'contact' => 'Record Updated Successfully'],Response::HTTP_OK);
    }
}
