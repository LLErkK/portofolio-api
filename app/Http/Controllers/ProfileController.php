<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\Profileresource;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(Request $request)
{
    $user = $request->user(); 
    $profile = Profile::where('user_id', $user->id)->first();

    if (!$profile) {
        return response()->json([
            'errors' => ['message' => ['Profile not found']]
        ], 404);
    }

    return new Profileresource($profile);
}


    public function update(UpdateProfileRequest $request){
        $profile = Profile::where('user_id',$request->user()->id)->firstOrFail();
        $data =$request->validated();

        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }

        $profile->update($data);

        return response()->json($profile);

    }

    public function store(UpdateProfileRequest $request){
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profile_photos', 'public');
        }

        $data['user_id'] = $request->user()->id;

        $profile = Profile::create($data);

        return response()->json($profile, 201);
    }
}
