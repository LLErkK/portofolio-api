<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function get(){
        $experiences = Experience::all();
        return ExperienceResource::collection($experiences);
    }

    public function show($id){
        $experience = Experience::findOrFail($id);
        return new ExperienceResource($experience);
    }

    public function store(UpdateExperienceRequest $request){
        $data= $request->validated();

        $data['user_id'] = $request->user()->id;

        $experience = Experience::create($data);
        return new ExperienceResource($experience);
    }

    public function update(UpdateExperienceRequest $request,Experience $experience){
        $data = $request->validated();
        $experience->update($data);
        return new ExperienceResource($experience);
    }

    public function destroy(UpdateExperienceRequest $request,$id){
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json([
            'message' => 'Experienced deleted successfully'
        ], 200);
    }
}
