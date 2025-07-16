<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCertificateRequest;
use App\Http\Resources\SertificateResource;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function get(){
        $certicates= Certification::all();

        return SertificateResource::collection($certicates);
    }

    public function store(UpdateCertificateRequest $request){
        $data = $request->validated();

        if($request->hasFile('image')){
            $data['image']= $request->file('image')->store('certificate_image','public');
        }
        $data['user_id'] = $request->user()->id;

        $certificate = Certification::create($data);

        return new SertificateResource($certificate);
    }

    public function update(UpdateCertificateRequest $request,Certification $certificate){
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $data['image'] = $request->file('image')->store('certificate_image', 'public');
        }
        $certificate->update($data);
        return new SertificateResource($certificate);
    }

    public function destroy($id){
        $certificate = Certification::findOrFail($id);
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        $certificate->delete();
        return response()->json([
            'message' => 'Certificate deleted successfully'
        ], 200);
    }
}
