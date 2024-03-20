<?php

namespace Modules\Document\Traits;

use Webpatser\Uuid\Uuid;

trait TeleverseTrait {

    /**
     * Sauvegarder les médias reçus depuis le frontend
     * 
     * @param type $item
     * @param type $documents
     * @param type $document_collection_name
     * @param type $document_disk
     * @param type $user_id
     */
    protected function saveDocumentApiTenant($item, $document, $document_collection_name, $document_disk, $user_id = null) {
        try {
            if (!$user_id) {
                $user_id = auth() ? user_api()->id : null;
            }

            $path_parts = pathinfo($document->getClientOriginalName());
            $extension = $path_parts['extension'];
            $prefixeTenant = tenant() ? tenant()->id."-" : "";
            $nomFichier = $prefixeTenant . Uuid::generate() . "-" . $user_id . ".$extension";
            \Storage::putFileAs('tmp', $document, "$nomFichier");

            $chemin = 'tmp/' . $nomFichier;
            $cheminTemp = storage_path("app/$chemin");

            $document = $item->addDocument($cheminTemp)->toDocumentCollection($document_collection_name, $document_disk);
            //$document->user_id = $user_id;
            //$document->save();
        } catch (\Exception $ex) {
            \Log::error($ex->getTraceAsString());
        }
    }

    /**
     * Sauvegarder les médias reçus depuis le frontend
     * 
     * @param type $item
     * @param type $documents
     * @param type $document_collection_name
     * @param type $document_disk
     * @param type $user_id
     */
    protected function saveDocumentsApiTenant($item, $documents, $document_collection_name, $document_disk, $user_id = null) {
        try {
            if (!$user_id) {
                $user_id = auth() ? user_api()->id : null;
            }

            $prefixeTenant = tenant() ? tenant()->id."-" : "";
            foreach ($documents as $document) {
                $path_parts = pathinfo($document->getClientOriginalName());
                $extension = $path_parts['extension'];
                $nomFichier = $prefixeTenant . Uuid::generate() . "-" . $user_id . ".$extension";
                \Storage::putFileAs('tmp', $document, "$nomFichier");

                $chemin = 'tmp/' . $nomFichier;
                $cheminTemp = storage_path("app/$chemin");
                
                $document = $item->addDocument($cheminTemp)->toDocumentCollection($document_collection_name, $document_disk);
            }
        } catch (\Exception $ex) {
            \Log::error($ex->getTraceAsString());
        }
    }

    /**
     * Supprimer le média reçu depuis le frontend
     * 
     * @param type $item
     * @param type $documents
     * @param type $document_collection_name
     * @param type $document_disk
     * @param type $user_id
     */
    protected function destroyDocumentsApi($item, $documents, $document_collection_name, $document_disk, $user_id = null) {
        
    }

//    protected function saveDocuments($item, $documentNames, $document_collection_name, $document_disk) {
//        //https://laraveldaily.com/multiple-file-upload-with-dropzone-js-and-laravel-documentlibrary-package/
//        $documentsAssocies = $item->getDocument($document_collection_name);
//        $existDocumentsNames = [];
//        try {
//            if ($documentsAssocies && count($documentsAssocies) > 0) {
//                foreach ($documentsAssocies as $document) {
//                    if (!in_array($document->file_name, $documentNames)) {
//                        if ($document->user_id == user_web()->id) {  //supprimer seulement si c'est lui qui a téléversé
//                            $document->delete();
//                        }
//                    }
//                }
//
//                $existDocumentsNames = $documentsAssocies->pluck('file_name')->toArray();
//            }
//
//            foreach ($documentNames as $file) {
//                if (count($existDocumentsNames) === 0 || !in_array($file, $existDocumentsNames)) {
//                    $chemin = 'tmp/' . $file;
//                    //En mode édition, les anciens médias ne seront pas trouvées dans le temp, alors évirier l'exsitance du chemin d'abord
//                    if (!\Storage::disk('local')->exists($chemin)) {
//                        continue;
//                    }
//                    $document = $item->addDocument(storage_path("app/$chemin"))->toDocumentCollection($document_collection_name, $document_disk);
//                    $document->user_id = user_web()->id;
//                    $document->save();
//                }
//            }
//        } catch (\Exception $ex) {
//            \Log::error($ex->getTraceAsString());
//        }
//    }

//    protected function associerDocuments($item, $documentNames, $document_collection_name, $document_disk, $folder) {
//        //https://laraveldaily.com/multiple-file-upload-with-dropzone-js-and-laravel-documentlibrary-package/
//        $documentsAssocies = $item->getDocument($document_collection_name);
//        $existDocumentsNames = [];
//        try {
//            //Supprimer les fichier existant mais qui ne sont plus dans le request actuel
//            if ($documentsAssocies && count($documentsAssocies) > 0) {
//                foreach ($documentsAssocies as $document) {
//                    if (!in_array($document->file_name, $documentNames)) {
//                        if (user_admin()->isSuperOrAdmin()) {  //supprimer si c'est un admin ou superadmin
//                            $document->delete();
//                        }
//                    }
//                }
//
//                $existDocumentsNames = $documentsAssocies->pluck('file_name')->toArray();
//            }
//
//            foreach ($documentNames as $file) {
//
//                if (count($existDocumentsNames) === 0 || !in_array($file, $existDocumentsNames)) {//si aucun ancien fichier n'existe ou si le fichier courant du request n'existait pas déjà 
//                    $chemin = $folder . $item->id . '-bp/' . $file;
//                    if (!\Storage::disk('local')->exists($chemin)) {
//                        continue;
//                    }
//                    $document = $item->addDocument(storage_path("app/$chemin"))
//                            ->preservingOriginal()
//                            ->toDocumentCollection($document_collection_name, $document_disk);
//                }
//            }
//        } catch (\Exception $ex) {
//            \Log::error($ex->getTraceAsString());
//        }
//    }

}
