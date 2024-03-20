{{-- NOUVEAU COMPTE --}}
<div class="modal fade" id="new-compte">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('compte.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Numéro</label>
                                <input type="number" class="form-control" id="add_num" name="num" minlength="3" maxlength="8" required>
                            </div>
                            <div class="form-group">
                                <label>Libellé</label>
                                <textarea class="form-control" id="add_libelle" name="libelle" rows="2" maxlength="100" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Compte parent </label>
                                <select class="form-control select2" id="add_parent_id" name="parent_id" style="width: 100%;" required>
                                    <option value="" selected>Sélectionnez un compte parent</option>
                                    @foreach ($comptes as $compte)
                                    <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                                    @endforeach
                                </select>  
                            </div>
                            <div class="form-group">
                                <label>Classe de compte </label>
                                <select class="form-control select2" id="add_saccount_class_id" name="saccount_class_id" style="width: 100%;" required>
                                    <option value="" selected>Sélectionnez une classe de compte</option>
                                    @foreach ($classes as $classe)
                                    <option value="{{$classe->uuid}}">({{$classe->num}}) - {{$classe->libelle}}</option>
                                    @endforeach
                                </select>  
                            </div>
                        </div>
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
                                <td>Numéro</td>
                                <td id="see_num"></td>
                            </tr>
                            <tr>
                                <td>Libellé</td>
                                <td id="see_libelle"></td>
                            </tr>
                            <tr>
                                <td>Compte parent</td>
                                <td id="see_parent_id"></td>
                            </tr>
                            <tr>
                                <td>Classe</td>
                                <td id="see_saccount_class_id"></td>
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
    <div class="modal-dialog">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Numéro</label>
                                <input type="number" class="form-control" id="upd_num" name="num" minlength="3" maxlength="8" required>
                            </div>
                            <div class="form-group">
                                <label>Libellé</label>
                                <textarea class="form-control" id="upd_libelle" name="upd_libelle" rows="2" maxlength="100" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Compte parent </label>
                                <select class="form-control select2" id="upd_parent_id" name="parent_id" style="width: 100%;" required>
                                    <option value="" selected>Sélectionnez un compte parent</option>
                                    @foreach ($comptes as $compte)
                                    <option value="{{$compte->uuid}}">({{$compte->num}}) - {{$compte->libelle}}</option>
                                    @endforeach
                                </select>  
                            </div>
                            <div class="form-group">
                                <label>Classe de compte </label>
                                <select class="form-control select2" id="upd_saccount_class_id" name="saccount_class_id" style="width: 100%;" required>
                                    <option value="" selected>Sélectionnez une classe de compte</option>
                                    @foreach ($classes as $classe)
                                    <option value="{{$classe->uuid}}">({{$classe->num}}) - {{$classe->libelle}}</option>
                                    @endforeach
                                </select>  
                            </div>
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

{{-- DELETE COMPTE --}}
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