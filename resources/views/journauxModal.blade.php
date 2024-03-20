{{-- NOUVEAU JOURNAL --}}

<!-- /.modal -->
<div class="modal fade" id="new-examen-medical">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('journal.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout d'un examen médical</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                        <label for="id_morgue">Corps</label>
                        <select class="form-control" id="id_corps" name="corps_id" required>
                            <!-- Option pour sélectionner la morgue -->
                            @foreach ($corpss as $corps)
                                    <option value="{{$corps->uuid}}">{{$corps->nom_defunt}} {{$corps->prenom_defunt}} </option>
                                    @endforeach
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_examen">Date de l'examen</label>
                        <input type="date" class="form-control" id="date_examen" name="date_examen" required>
                    </div>
                    <div class="form-group">
                        <label for="resultat_examen">Résultat de l'examen</label>
                        <textarea class="form-control" id="resultat_examen" name="resultat_examen" cols="30" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="medecin">Médecin</label>
                        <input type="text" class="form-control" id="medecin" name="medecin" required>
                    </div>
                    {{-- <input type="hidden" name="id_corps" value="{{ $id_corps }}"> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>


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
                    <div class="form-group ">
                        <label for="id_morgue">Corps</label>
                        <select class="form-control" id="upd_corps_id" name="corps_id" required>
                            <!-- Option pour sélectionner la morgue -->
                            @foreach ($corpss as $corps)
                                    <option value="{{$corps->uuid}}">{{$corps->nom_defunt}} {{$corps->prenom_defunt}} </option>
                                    @endforeach
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_examen">Date d'examen</label>
                        <input type="date" class="form-control" id="upd_date_examen" name="date_examen" required>
                    </div>
                    <div class="form-group">
                        <label for="resultat_examen">Résultat de l'examen</label>
                        <textarea class="form-control" id="upd_resultat_examen" name="resultat_examen" cols="30" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="medecin">Médecin</label>
                        <input type="text" class="form-control" id="upd_medecin" name="medecin" required>
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