{{-- NOUVELLE ECRITURE --}}
<div class="modal fade" id="new-ecriture">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{route('ecriture.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-12">
                            <label>Libellé</label>
                            <input type="text" class="form-control" id="add_libelle" name="libelle" required>
                            <input type="hidden" class="form-control" id="add_code" name="code">
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Montant ({{$parametre->devise->libelle}})</label>
                            <input type="number" class="form-control" id="add_montant" name="montant" min="1" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Taxe (%)</label>
                            <input type="number" class="form-control" id="add_taxe" name="taxe" min="0" max="100">
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Date</label>
                            <input type="datetime-local" class="form-control" id="add_date" name="date" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="add_description" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Compte débit </label>
                            <select class="form-control select2" name="compte_debit_id" id="add_compte_debit_id" style="width: 100%;">
                                <option value="" selected>Sélectionnez un compte</option>
                                @foreach ($comptes as $compte)
                                <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                                @endforeach
                            </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Compte crédit </label>
                            <select class="form-control select2" name="compte_credit_id" id="add_compte_credit_id" style="width: 100%;">
                                <option value="" selected>Sélectionnez un compte</option>
                                @foreach ($comptes as $compte)
                                <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                                @endforeach
                            </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Exercice</label>
                            <input type="text" class="form-control" value="{{$parametre->exercice->libelle}}" readonly required>
                            <input type="hidden" class="form-control" name="exercice_id" value="{{$parametre->exercice->uuid}}" readonly required>
                            <input type="hidden" class="form-control" name="devise_id" value="{{$parametre->devise->uuid}}" required>
                            <input type="hidden" class="form-control" name="journal_id" value="{{$journal}}" required>
                        </div>
                        {{-- <div class="form-group col-lg-6">
                            <label>Journal </label>
                            <select class="form-control select2" name="journal_id" id="add_journal_id" style="width: 100%;" required>
                                <option value="" selected>Sélectionnez un compte</option>
                                @foreach ($journaux as $journal)
                                <option value="{{$journal->uuid}}">{{$journal->libelle}}</option>
                                @endforeach
                            </select>  
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Ligne budgétaire </label>
                            <select class="form-control select2" name="ligne_id" id="add_ligne_id" style="width: 100%;">
                                <option value="" selected>Sélectionnez une ligne budgétaire</option>
                                @foreach ($lignes as $ligne)
                                <option value="{{$ligne->uuid}}">{{$ligne->libelle}}</option>
                                @endforeach
                            </select>  
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- DETAILS --}}
<div class="modal fade" id="details">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Détails</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3">
                    <table class="table table-striped table-borderless">
                        <tbody>
                            <tr>
                                <td>Code</td>
                                <td id="see_code"></td>
                            </tr>
                            <tr>
                                <td>Libellé</td>
                                <td id="see_libelle"></td>
                            </tr>
                            <tr>
                                <td>Montant (devise)</td>
                                <td id="see_montant"></td>
                            </tr>
                            <tr>
                                <td>Description/Référence</td>
                                <td id="see_description"></td>
                            </tr>
                            <tr>
                                <td>Taxe</td>
                                <td id="see_taxe"></td>
                            </tr>
                            <tr>
                                <td>Compte débit</td>
                                <td id="see_compte_debit_id"></td>
                            </tr>
                            <tr>
                                <td>Compte crédit</td>
                                <td id="see_compte_credit_id"></td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td id="see_date"></td>
                            </tr>
                            <tr>
                                <td>Exercice</td>
                                <td id="see_exercice_id"></td>
                            </tr>
                            <tr>
                                <td>Journal</td>
                                <td id="see_journal_id"></td>
                            </tr>
                            {{-- <tr>
                                <td>Budget</td>
                                <td id="see_budget_id"></td>
                            </tr>
                            <tr>
                                <td>Ligne</td>
                                <td id="see_ligne_id"></td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                {{-- <button type="button" class="btn btn-success">Save changes</button> --}}
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- UPDATE --}}
<div class="modal fade" id="update">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="upd_form" action="" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Modification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-lg-2">
                            <label for="code">Code</label>
                            <input type="text" class="form-control" id="upd_code" name="code" readonly required>
                        </div>
                        <div class="form-group col-lg-10">
                            <label for="libelle">Libellé</label>
                            <input type="text" class="form-control" id="upd_libelle" name="libelle" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Montant ({{$parametre->devise->libelle}})</label>
                            <input type="number" class="form-control" id="upd_montant" name="montant" min="1" required>
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Taxe (%)</label>
                            <input type="number" class="form-control" id="upd_taxe" name="taxe" min="1" max="100">
                        </div>
                        <div class="form-group col-lg-4">
                            <label>Date</label>
                            <input type="datetime-local" class="form-control" id="upd_date" name="date" required>
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="upd_description" cols="30" rows="2"></textarea>
                        </div>
                        <div class="form-group col-lg-6">
                        <label>Compte débit </label>
                        <select class="form-control select2" name="compte_debit_id" id="upd_compte_debit_id" style="width: 100%;">
                            <option value="" selected>Sélectionnez un compte</option>
                            @foreach ($comptes as $compte)
                            <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                            @endforeach
                        </select>  
                        </div>
                        <div class="form-group col-lg-6">
                        <label>Compte crédit </label>
                        <select class="form-control select2" name="compte_credit_id" id="upd_compte_credit_id" style="width: 100%;">
                            <option value="" selected>Sélectionnez un compte</option>
                            @foreach ($comptes as $compte)
                            <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                            @endforeach
                        </select>  
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Exercice</label>
                            <input type="text" class="form-control" value="{{$parametre->exercice->libelle}}" readonly required>
                            <input type="hidden" class="form-control" name="exercice_id" value="{{$parametre->exercice->uuid}}" readonly required>
                            <input type="hidden" class="form-control" name="devise_id" value="{{$parametre->devise->uuid}}" required>
                            <input type="hidden" class="form-control" name="journal_id" value="{{$journal}}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-warning">Enregistrer</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- DELETE EXERCICE --}}
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="del_form" action="" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('DELETE') }}
                <div class="modal-header bg-danger">
                    <h5 class="modal-title">Suppression</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mt-3 text-center">
                        <i class="fas fa-exclamation-triangle"></i>
                        <h5>Attention! Voulez-vous vraiment supprimer cette ligne:
                            <span id="del_libelle"></span> ?</h5>
                    </div> 
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-danger">Confirmer</button>
                </div>
            </form>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->