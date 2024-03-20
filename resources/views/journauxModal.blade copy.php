{{-- NOUVEAU JOURNAL --}}
<div class="modal fade" id="new-journal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{route('journal.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="libelle">Libellé</label>
                        <input type="text" class="form-control" id="add_libelle" name="libelle" required>
                        <input type="hidden" class="form-control" id="add_code" name="code">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="add_description" cols="30" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                    <label>Compte débit </label>
                    <select class="form-control select2" name="compte_debit_id" id="add_compte_debit_id" style="width: 100%;">
                        <option value="" selected>Sélectionnez un compte</option>
                        @foreach ($comptes as $compte)
                        <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                        @endforeach
                    </select>  
                    </div>
                    <div class="form-group">
                    <label>Compte crédit </label>
                    <select class="form-control select2" name="compte_credit_id" id="add_compte_credit_id" style="width: 100%;">
                        <option value="" selected>Sélectionnez un compte</option>
                        @foreach ($comptes as $compte)
                        <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                        @endforeach
                    </select>  
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
                                <td>Description</td>
                                <td id="see_description"></td>
                            </tr>
                            <tr>
                                <td>Ecritures</td>
                                <td id="see_ecritures"></td>
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
                                <td>Date d'ajout</td>
                                <td id="see_created_at"></td>
                            </tr>
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
    <div class="modal-dialog modal-lg">
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
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" class="form-control" id="upd_code" name="code" readonly required>
                    </div>
                    <div class="form-group">
                        <label for="libelle">Libellé</label>
                        <input type="text" class="form-control" id="upd_libelle" name="libelle" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="upd_description" cols="30" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                      <label>Compte débit </label>
                      <select class="form-control select2" name="compte_debit_id" id="upd_compte_debit_id" style="width: 100%;">
                        <option value="">Sélectionnez un compte</option>
                        @foreach ($comptes as $compte)
                          <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Compte crédit </label>
                      <select class="form-control select2" name="compte_credit_id" id="upd_compte_credit_id" style="width: 100%;">
                        <option value="">Sélectionnez un compte</option>
                        @foreach ($comptes as $compte)
                          <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                        @endforeach
                      </select>  
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