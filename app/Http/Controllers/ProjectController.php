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

    public function show($id){
        $project = Project::findOrFail($id);
        return new ProjectResource($project);
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

        // Ambil gambar lama dari DB
        $currentImages = json_decode($project->images ?? '[]', true);

        // Hapus gambar yang ditandai
        if ($request->filled('deleted_images')) {
            foreach ($request->input('deleted_images') as $image) {
                Storage::disk('public')->delete($image);
            }

            // Buang yang dihapus dari array
            $currentImages = array_values(array_diff($currentImages, $request->input('deleted_images')));
        }

        // Tambahkan gambar baru
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $currentImages[] = $image->store('project_image', 'public');
            }
        }

        // Update kolom images
        $data['images'] = json_encode($currentImages);

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
