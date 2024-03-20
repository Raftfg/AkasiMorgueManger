{{-- NOUVELLE TRANSACTION --}}
<div class="modal fade" id="new-budget">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title">Ajout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="libelle">Libellé</label>
                        <input type="text" class="form-control" id="libelle" name="libelle" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="libelle">Montant</label>
                        <input type="text" class="form-control" id="libelle" name="libelle" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label for="compte_id">Exercice</label>
                        <select class="form-control select2" style="width: 100%;" name="compte_id">
                        {{-- <option selected="selected">N/A</option> --}}
                            <option>Exercice 2023</option>
                            <option>Exercice 2022</option>
                            <option>Exercice 2021</option>
                        </select>
                    </div>
                </div>
                <div class="row"><h6 class="bg-secondary w-50 text-center mx-auto p-2">Lignes budgétaires associées</h6></div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless" id="item_table">
                            <tr>
                                <th>Libellé</th>
                                <th>Montant</th>
                                <th><button type="button" name="add" class="btn btn-success btn-sm add"><span class="fa fa-plus"></span></button></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="compte_id[0]" class="form-control" required/></td>
                                <td><input type="text" name="montant[0]" class="form-control" required/></td>
                                <td><button type="button" name="remove" class="btn btn-danger btn-sm remove" disabled><span class="fa fa-minus"></span></button></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-success">Enregistrer</button>
            </div>
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
                                <td>Libellé</td>
                                <td>Budget de l'année 2023</td>
                            </tr>
                            <tr>
                                <td>Montant</td>
                                <td>25.000.000 FCFA</td>
                            </tr>
                            <tr>
                                <td>Dépense</td>
                                <td>15.000.000 FCFA</td>
                            </tr>
                        </tbody>
                    </table>
                </div> 
                <div class="form-group mt-3">
                    <h6 class="bg-secondary w-50 text-center mx-auto p-2">Lignes budgétaires associées</h6>
                    <table class="table table-striped table-borderless">
                        <thead>                            
                            <tr>
                                <th>Intitulé</th>
                                <th>Montant</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Construction d'un laboratoire</td>
                                <td>17.500.000</td>
                                <td>En cours</td>
                            </tr>
                            <tr>
                                <td>Achat et Installation d'un groupe électrogène</td>
                                <td>5.500.000</td>
                                <td>Exécutée</td>
                            </tr>
                            <tr>
                                <td>Confection de 200 blousons</td>
                                <td>2.000.000</td>
                                <td>Exécutée</td>
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
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Modification</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-warning">Enregistrer</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

{{-- DELETE TRANSACTION --}}
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3 text-center">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h5>Attention! Voulez-vous vraiment supprimer ce budget:
                        Budget de l'année 2023 ?</h5>
                </div> 
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-danger">Confirmer</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->