{{-- NOUVEL EXERCICE --}}
<!-- <div class="modal fade" id="new-exercice">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('exercice.store')}}" method="post" enctype="multipart/form-data">
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
                                <label for="libelle">Libellé</label>
                                <input type="text" class="form-control" id="add_libelle" name="libelle" required>
                                <input type="hidden" class="form-control" id="code" name="code">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="add_description" cols="30" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="date_debut">Début</label>
                                <input type="date" class="form-control" id="add_date_debut" name="date_debut" required>
                            </div>
                            <div class="form-group">
                                <label for="date_fin">Fin</label>
                                <input type="date" class="form-control" id="add_date_fin" name="date_fin" required>
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
   
    </div>
 
</div> -->
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
                                <td>Date de début</td>
                                <td id="see_date_debut"></td>
                            </tr>
                            <tr>
                                <td>Date de fin</td>
                                <td id="see_date_fin"></td>
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
                        <textarea class="form-control" name="description" id="upd_description" cols="30" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="date_debut">Début</label>
                        <input type="date" class="form-control" id="upd_date_debut" name="date_debut" required>
                    </div>
                    <div class="form-group">
                        <label for="date_fin">Fin</label>
                        <input type="date" class="form-control" id="upd_date_fin" name="date_fin" required>
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

{{-- ACTIVATION EXERCICE --}}
<div class="modal fade" id="activation">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Ouverture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3 text-center">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h5>Confirmez l'ouverture de :
                        <span id="act_libelle"></span> ?</h5>
                </div> 
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <a type="button" id="act_link" href="" class="btn btn-success">Confirmer</a>
                {{-- <button type="submit" class="btn btn-danger">Confirmer</button> --}}
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->