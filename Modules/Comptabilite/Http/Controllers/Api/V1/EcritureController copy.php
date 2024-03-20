<?php

namespace Modules\Comptabilite\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Comptabilite\Http\Requests\EcritureRequest;
use Modules\Comptabilite\Http\Resources\EcritureResource;
use Modules\Comptabilite\Http\Resources\EcrituresResource;
use Modules\Document\Repositories\DocumentRepositoryEloquent;
use Modules\Comptabilite\Repositories\MouvementRepositoryEloquent;
use Modules\Comptabilite\Repositories\JournalRepositoryEloquent;
use Modules\Comptabilite\Repositories\SaccountRepositoryEloquent;
use Modules\Comptabilite\Http\Controllers\ComptabiliteController;
use Modules\Comptabilite\Repositories\CorpsRepositoryEloquent;
use Modules\Comptabilite\Repositories\EcritureRepositoryEloquent;
use Modules\Comptabilite\Repositories\LigneRepositoryEloquent;

class EcritureController extends ComptabiliteController {

    /**
     * @var 
     */
    protected $ecritureRepositoryEloquent, $documentRepositoryEloquent, $corpsRepositoryEloquent, $mouvementRepositoryEloquent, $saccountRepositoryEloquent, $transactionRepositoryEloquent, $journalRepositoryEloquent, $ligneRepositoryEloquent;

    public function __construct(EcritureRepositoryEloquent $ecritureRepositoryEloquent, DocumentRepositoryEloquent $documentRepositoryEloquent, CorpsRepositoryEloquent $corpsRepositoryEloquent, DeviseRepositoryEloquent $deviseRepositoryEloquent, SaccountRepositoryEloquent $saccountRepositoryEloquent, JournalRepositoryEloquent $journalRepositoryEloquent, LigneRepositoryEloquent $ligneRepositoryEloquent) 
    {
        parent::__construct();
        $this->ligneRepositoryEloquent = $ligneRepositoryEloquent;
        $this->mouvementRepositoryEloquent = $mouvementRepositoryEloquent;
        $this->journalRepositoryEloquent = $journalRepositoryEloquent;
        $this->ecritureRepositoryEloquent = $ecritureRepositoryEloquent;
        $this->documentRepositoryEloquent = $documentRepositoryEloquent;
        $this->corpsRepositoryEloquent = $corpsRepositoryEloquent;
        $this->saccountRepositoryEloquent = $saccountRepositoryEloquent;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $donnees = $this->ecritureRepositoryEloquent->where([['exercice_id', parametre_api()->exercice_id]])->orderBy('id', 'DESC')->get();
        return new EcrituresResource($donnees);
    }
    
    /**
     * Display a listing of the resource by JOURNAL.
     *
     * @return Response
     */
    public function journal_index($journal)
    {
        $journal = $this->journalRepositoryEloquent->findByUuid($journal)->first();
        $donnees = $this->ecritureRepositoryEloquent->where([['journal_id', $journal->id], ['exercice_id', parametre_api()->exercice_id]])->orderBy('id', 'DESC')->get();
        return new EcrituresResource($donnees);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($uuid) 
    {
        try {
            $item = $this->ecritureRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            $data = [
                "message" => __("Ecriture non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }
        return new EcritureResource($item);
    }
    
   /**
     * Create a resource.
     *
     * @return Response
     */
    public function store(EcritureRequest $request)
    {
        $attributs = $request->all();

        try {
            $item = DB::transaction(function () use ($attributs, $request) {
                $attributs['user_id'] = user_api()->id;
                // $attributs['user_id'] = 4;
                unset($attributs['document_id']);

                if(isset($attributs['exercice_id'])) {
                    $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
                    $attributs['exercice_id'] = $exercice->id;
                }
                
                if (isset($attributs['devise_id'])) {
                    $devise = $this->mouvementRepositoryEloquent->findByUuid($attributs['devise_id'])->first();
                    $attributs['devise_id'] = $devise->id;
                }
                                
                if (isset($attributs['journal_id'])) {
                    $journal = $this->journalRepositoryEloquent->findByUuid($attributs['journal_id'])->first();
                    $attributs['journal_id'] = $journal->id;
                } else {
                    $attributs['journal_id'] = null;
                }
                
                if (isset($attributs['ligne_id'])) {
                    $ligne = $this->ligneRepositoryEloquent->findByUuid($attributs['ligne_id'])->first();
                    $attributs['ligne_id'] = $ligne->id;
                } else {
                    $attributs['ligne_id'] = null;
                }

                if(isset($attributs['compte_debit_id'])) {
                    $compte_debit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_debit_id'])->first();
                    $attributs['compte_debit_id'] = $compte_debit->id;
                } else {
                    $attributs['compte_debit_id'] = null;
                }

                if(isset($attributs['compte_credit_id'])) {
                    $compte_credit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_credit_id'])->first();
                    $attributs['compte_credit_id'] = $compte_credit->id;
                } else {
                    $attributs['compte_credit_id'] = null;
                }
                // \Log::info($attributs);
                $item = $this->ecritureRepositoryEloquent->create($attributs);
                return $item;
            });
            $item = $item->fresh();
            $data = [
                "message" => __("Ecriture ajoutée avec succès"),
                "resultat" => __(1),
            ]; 

            // if(isset($request->document_id)){
            //     // Validate and store the uploaded file
            //     $uploadedFile = $request->file('document_id');
            //     $fileOriginalName = $uploadedFile->getClientOriginalName();
            //     $fileMimeType = $uploadedFile->getClientMimeType();
            //     $fileSize = $uploadedFile->getSize();
            //     // $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            //     $fileExtension = $uploadedFile->getClientOriginalExtension();
            //     $fileName = uniqid().'.'.$fileExtension;
            //     // $filePath = $uploadedFile->store('uploads');
            //     $filePath = $uploadedFile->storeAs('uploads', $fileName);

            //     // Create a new file information record
            //     $document['model_type'] = "Modules\Comptabilite\Entities\Ecriture";
            //     $document['model_id'] = intval($item->id);
            //     $document['name'] = "Justificatif";
            //     $document['file_original_name'] = $fileOriginalName;
            //     $document['file_name'] = $fileName;
            //     $document['file_path'] = $filePath;
            //     $document['mime_type'] = $fileMimeType;
            //     $document['size'] = $fileSize;
            //     $document['user_id'] = user_api()->id;
            //     $this->documentRepositoryEloquent->create($document);
            // }
        
        } catch (\Exception $e) {
            $data = [
                "message" => __("Une erreur inattendue a été rencontrée. Veuillez réessayer"),
                "resultat" => __(0),
            ]; // Internal Server Error
        }
            
        return reponse_json_transform($data);
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function update(EcritureRequest $request, $uuid)
    {
        try {
            $item = $this->ecritureRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Ecriture non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }        
        $attributs = $request->all();
        $attributs['user_id'] = user_api()->id;
        // $attributs['user_id'] = 4;

        if(isset($attributs['exercice_id'])) {
            $exercice = $this->corpsRepositoryEloquent->findByUuid($attributs['exercice_id'])->first();
            $attributs['exercice_id'] = $exercice->id;
        }
        
        if (isset($attributs['devise_id'])) {
            $devise = $this->mouvementRepositoryEloquent->findByUuid($attributs['devise_id'])->first();
            $attributs['devise_id'] = $devise->id;
        }
                        
        if (isset($attributs['journal_id'])) {
            $journal = $this->journalRepositoryEloquent->findByUuid($attributs['journal_id'])->first();
            $attributs['journal_id'] = $journal->id;
        }
        
        if (isset($attributs['ligne_id'])) {
            $ligne = $this->ligneRepositoryEloquent->findByUuid($attributs['ligne_id'])->first();
            $attributs['ligne_id'] = $ligne->id;
        }

        if(isset($attributs['compte_debit_id'])) {
            $compte_debit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_debit_id'])->first();
            $attributs['compte_debit_id'] = $compte_debit->id;
        }

        if(isset($attributs['compte_credit_id'])) {
            $compte_credit = $this->saccountRepositoryEloquent->findByUuid($attributs['compte_credit_id'])->first();
            $attributs['compte_credit_id'] = $compte_credit->id;
        }

        try {
            unset($attributs['document_id']);
            $item = $this->ecritureRepositoryEloquent->update($attributs, $item->id);                
            $item = $item->fresh();
            $data = [
                "message" => __("Ecriture modifiée avec succès"),
                "resultat" => __(1),
            ]; 

            // if(isset($request->document_id)){
            //     // Validate and store the uploaded file
            //     $uploadedFile = $request->file('document_id');
            //     $fileOriginalName = $uploadedFile->getClientOriginalName();
            //     $fileMimeType = $uploadedFile->getClientMimeType();
            //     $fileSize = $uploadedFile->getSize();
            //     // $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            //     $fileExtension = $uploadedFile->getClientOriginalExtension();
            //     $fileName = uniqid().'.'.$fileExtension;
            //     // $filePath = $uploadedFile->store('uploads');
            //     $filePath = $uploadedFile->storeAs('uploads', $fileName);

            //     // Create a new file information record
            //     $document['model_type'] = "Modules\Comptabilite\Entities\Ecriture";
            //     $document['model_id'] = intval($item->id);
            //     $document['name'] = "Justificatif";
            //     $document['file_original_name'] = $fileOriginalName;
            //     $document['file_name'] = $fileName;
            //     $document['file_path'] = $filePath;
            //     $document['mime_type'] = $fileMimeType;
            //     $document['size'] = $fileSize;
            //     $document['user_id'] = user_api()->id;
            //     $this->documentRepositoryEloquent->create($document);
            // }
        
        } catch (\Exception $e) {
            $data = [
                "message" => __("Une erreur inattendue a été rencontrée. Veuillez réessayer"),
                "resultat" => __(0),
            ]; // Internal Server Error
        }
            
        return reponse_json_transform($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $ecriture = $this->ecritureRepositoryEloquent->findByUuidOrFail($uuid)->first();  //existe-il cet element?
        } catch (\Throwable $th) {
            // throw $th;            
            $data = [
                "message" => __("Ecriture non trouvée"),
                "resultat" => __(0),
            ];
            return reponse_json_transform($data);
        }

        $this->ecritureRepositoryEloquent->delete($ecriture->id);             
        $data = [
            "message" => __("Ecriture supprimée avec succès"),
            "resultat" => __(1),
        ];

        return reponse_json_transform($data);
    }    
}
