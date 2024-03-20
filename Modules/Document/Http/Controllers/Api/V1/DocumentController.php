<?php

namespace Modules\Document\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Document\Entities\Document;
use Modules\Comptabilite\Http\Resources\DocumentResource;
use Modules\Comptabilite\Http\Resources\DocumentsResource;
use Modules\Document\Repositories\DocumentRepositoryEloquent;

class DocumentController extends \Modules\Document\Http\Controllers\DocumentController {

    /**
     * @var PostRepository
     */
    protected $documentRepositoryEloquent;

    public function __construct(DocumentRepositoryEloquent $documentRepositoryEloquent) {
        parent::__construct();
        $this->documentRepositoryEloquent = $documentRepositoryEloquent;
    }   
    
    /**
      * Display a listing of the resource.
      *
      * @return Response
    */
    public function index()
    {
        $donnees = $this->documentRepositoryEloquent->paginate($this->nombrePage);
        return new DocumentsResource($donnees);
    } 

    /**
     * Show a resource.
     *
     * @return Response
     */
    public function show($uuid)
    {
        $item = $this->documentRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        return new DocumentResource($item);
    }

    /**
     * Store a file.
     *
     * @return Response
    */
    public function store(Request $request)
    {
        // Validate and store the uploaded file
        $uploadedFile = $request->file('file');
        $fileOriginalName = $uploadedFile->getClientOriginalName();
        $fileMimeType = $uploadedFile->getClientMimeType();
        $fileSize = $uploadedFile->getSize();
        // $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $fileName = uniqid().$fileExtension;
        // $filePath = $uploadedFile->store('uploads');
        $filePath = $uploadedFile->storeAs('uploads', $fileName);

        // Create a new file information record
        $item = new Document();
        $item->model_type = $request->model_type;
        $item->model_id = $request->model_id;
        $item->name = $request->name;
        $item->file_original_name = $fileOriginalName;
        $item->file_name = $fileName;
        $item->file_path = $filePath;
        $item->mime_type = $fileMimeType;
        $item->size = $fileSize;
        $item->user_id = auth()->user()->id; // Replace with your user authentication logic
        $item->save();

        $data = [
            "message" => __("Document ajouté avec succès"),
        ];
        return reponse_json_transform($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return Response
    */
    public function destroy($uuid)
    {
        $data = ["message" => __("Document non supprimé"),];
        $item = $this->documentRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        $modelType = $item->model_type;
        //Suppression avec le fichier sur le disque
        (new $modelType())->find($item->model_id )->deleteDocument($item->id);
        
        $data = [
            "message" => __("Document supprimé avec succès"),
        ];
        return reponse_json_transform($data);
    }
}
