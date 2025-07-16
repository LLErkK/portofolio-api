<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Profile;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function get(){

        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    public function store(UpdateProjectRequest $request){
        $data = $request->validated();

        if($request->hasFile('images')){
            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('project_image', 'public');
            }
            $data['images'] = json_encode($paths);
        }

        $data['user_id']= $request->user()->id;

        $project = Project::create($data);
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        if ($request->hasFile('images')) {
            // Opsional: hapus gambar lama
            if ($project->images) {
                foreach (json_decode($project->images) as $path) {
                    Storage::disk('public')->delete($path);
                }
            }

            $paths = [];
            foreach ($request->file('images') as $image) {
                $paths[] = $image->store('project_image', 'public');
            }
            $data['images'] = json_encode($paths);
        }

        $project->update($data);
        return new ProjectResource($project);
    }
    public function destroy(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        // Hapus file gambar jika ada
        if ($project->images) {
            $images = json_decode($project->images, true);
            foreach ($images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        $project->delete();

        return response()->json([
            'message' => 'Project deleted successfully'
        ], 200);
    }



}
