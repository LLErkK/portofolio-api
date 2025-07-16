<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEducationRequest;
use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function get(){
        $educations = Education::all();
        return EducationResource::collection($educations);
    }

    public function store(UpdateEducationRequest $request){
        $data = $request->validated();

        $data['user_id'] = $request->user()->id;

        $education = Education::create($data);
        return new EducationResource($education);
    }
    public function update(UpdateEducationRequest $request, Education $education){
        $data = $request->validated();
        $education->update($data);
        return new EducationResource($education);
    }

    public function destroy(UpdateEducationRequest $request,$id){
        $education = Education::findOrFail($id);
        $education->delete();
        return response()->json([
            'message' => 'Education deleted successfully'
        ], 200);
    }
}
