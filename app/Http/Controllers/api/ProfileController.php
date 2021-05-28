<?php

namespace App\Http\Controllers\api;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Http\Resources\Profile as ProfileResource;

class ProfileController extends BaseController
{
    public function index()
    {
        $profile = Profile::all();

        return $this->sendResponse(ProfileResource::collection($profile), 'Profile retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userName' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $profile = Profile::create($input);

        return $this->sendResponse(new ProfileResource($profile), 'Profile created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profile = Profile::find($id);

        if (is_null($profile)) {
            return $this->sendError('Profile not found.');
        }

        return $this->sendResponse(new ProfileResource($profile), 'Profile retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'userName' => 'required',
            'detail' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $profile->userName = $input['userName'];
        $profile->detail = $input['detail'];
        $profile->save();

        return $this->sendResponse(new ProfileResource($profile), 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $profile->delete();

        return $this->sendResponse([], 'Profile deleted successfully.');
    }
}
