<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
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

    public function show($id)
    {
        $certificate = Certification::findOrFail($id);

        return new SertificateResource($certificate);
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



public function update(UpdateCertificateRequest $request, Certification $certificate)
{
    
    Log::info('--- Mulai update certificate ---');
    Log::info('Certificate ID:', ['id' => $certificate->id]);

    $data = $request->validated();
    Log::debug('Validated data:', $data);

    if ($request->hasFile('image')) {
        Log::info('Ada file image baru');

        if ($certificate->image && Storage::disk('public')->exists($certificate->image)) {
            Log::info('Menghapus gambar lama:', ['path' => $certificate->image]);
            Storage::disk('public')->delete($certificate->image);
        }

        $data['image'] = $request->file('image')->store('certificate_image', 'public');
        Log::info('Gambar baru disimpan:', ['path' => $data['image']]);
    } else {
        Log::info('Tidak ada gambar baru diupload');
    }

    $certificate->update($data);
    Log::info('Certificate berhasil diupdate');
    Log::info('Certificate ditemukan:', ['data' => $certificate]);

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
