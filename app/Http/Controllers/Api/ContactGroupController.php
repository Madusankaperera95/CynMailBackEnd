<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactGroupRequest;
use App\Models\ContactGroup;
use App\Repositories\ContactGroupInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactGroupController extends Controller
{

    private $contactGroupRepository;

    public function __construct(ContactGroupInterface $contactGroupRepository)
    {
        $this->contactGroupRepository = $contactGroupRepository;
    }

    /**
     * Get All ContactGroupsBelongs to a user
     *
     * @return mixed
     */

    public function index()
    {

        return response()->json($this->contactGroupRepository->getAllContactGroups(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a Newly Created ContactGroup
     *
     * @param  ContactGroupRequest $request
     * @return mixed
     */
    public function store(ContactGroupRequest $request)
    {
        $contactGroup = $this->contactGroupRepository->create(['groupName'=> $request->groupName]);

        return response()->json(['status' => true , 'contactGroup' => $contactGroup],Response::HTTP_CREATED);
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }

    /**
     * Update ContactGroup
     *
     * @param  ContactGroupRequest $request
     * @param  string $id
     * @return mixed
     */
    public function update(ContactGroupRequest $request, string $id)
    {
       $this->contactGroupRepository->update($id,$request->all());

        return response()->json([
            'status' => true,
            'message' => 'Record Updated Successfully',
        ],200);

        //
    }

    /**
     * Remove ContactGroup
     *
     * @param  string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        $this->contactGroupRepository->delete($id);
        return response()->json(['status' => false,'message' => 'Record Deleted Successfully'],200);
    }
}
