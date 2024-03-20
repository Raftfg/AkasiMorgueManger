{{-- NOUVELLE DEVISE --}}

<!-- /.modal -->

<div class="modal fade" id="new-mouvement-corps">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('devise.store') }}" method="post" enctype="multipart/form-data" onsubmit="return validateDates()">
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout d'un mouvement de corps</h5>
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
                        <label for="date_heure_depart">Date et heure de départ</label>
                        <input type="datetime-local" class="form-control" id="date_heure_depart" name="date_heure_depart" required>
                    </div>
                    <div class="form-group">
                        <label for="date_heure_arrivee">Date et heure d'arrivée</label>
                        <input type="datetime-local" class="form-control" id="date_heure_arrivee" name="date_heure_arrivee" required>
                    </div>
                    <div id="error-message" class="text-danger"></div>
                    <div class="form-group">
                        <label for="lieu_depart">Lieu de départ</label>
                        <input type="text" class="form-control" id="lieu_depart" name="Lieu_Départ" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lieu_arrivee">Lieu d'arrivée</label>
                        <input type="text" class="form-control" id="lieu_arrivee" name="lieu_arrivee" required>
                    </div>
                    <div class="form-group">
                        <label for="responsable_mouvement">Responsable du mouvement</label>
                        <input type="text" class="form-control" id="responsable_mouvement" name="responsable_mouvement" required>
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
                                <th>Corps</th>
                                <td id="see_corps_id"></td>
                            </tr>
                            <tr>
                                <th>Date et heure de départ</th>
                                <td id="see_date_heure_depart"></td>
                            </tr>
                            <tr>
                                <th>Date et heure d'arrivée</th>
                                <td id="see_date_heure_arrivee"></td>
                            </tr>
                            <tr>
                                <th>Lieu de départ</th>
                                <td id="see_Lieu_Départ"></td>
                            </tr>
                            
                            <tr>
                                <th>Lieu d'arrivée</th>
                                <td id="see_lieu_arrivee"></td>
                            </tr>
                            <tr>
                                <th>Responsable du mouvement </th>
                                <td id="see_responsable_mouvement"></td>
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
            <form id="upd_form" action="" method="post" enctype="multipart/form-data" onsubmit="return validateDate()">
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
                        <label for="date_heure_depart">Date et heure de départ</label>
                        <input type="datetime-local" class="form-control" id="upd_date_heure_depart" name="date_heure_depart" required>
                    </div>
                    <div class="form-group">
                        <label for="date_heure_arrivee">Date et heure d'arrivée</label>
                        <input type="datetime-local" class="form-control" id="upd_date_heure_arrivee" name="date_heure_arrivee" required>
                    </div>
                    <div id="errorr-message" class="text-danger"></div>
                    <div class="form-group">
                        <label for="lieu_depart">Lieu de départ</label>
                        <input type="text" class="form-control" id="upd_lieu_depart" name="Lieu_Départ" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lieu_arrivee">Lieu d'arrivée</label>
                        <input type="text" class="form-control" id="upd_lieu_arrivee" name="lieu_arrivee" required>
                    </div>
                    <div class="form-group">
                        <label for="responsable_mouvement">Responsable du mouvement</label>
                        <input type="text" class="form-control" id="upd_responsable_mouvement" name="responsable_mouvement" required>
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

{{-- DELETE DEVISE --}}
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
<script>
    function validateDates() {
        var dateNaissance = new Date(document.getElementById("date_heure_depart").value);
        var dateDeces = new Date(document.getElementById("date_heure_arrivee").value);

        if (dateDeces < dateNaissance) {
            document.getElementById("error-message").innerHTML = "La date d'arrivée ne peut pas être antérieure à la date de départ.";
            return false; // Empêche la soumission du formulaire
        } else {
            document.getElementById("error-message").innerHTML = ""; // Réinitialise le message d'erreur
            return true; // Permet la soumission du formulaire
        }
    }

    function validateDate() {
    var dateNaissance = new Date(document.getElementById("upd_date_heure_depart").value);
    var dateDeces = new Date(document.getElementById("upd_date_heure_arrivee").value);

    if (dateDeces < dateNaissance) {
        document.getElementById("errorr-message").innerHTML = "La date d'arrivée ne peut pas être antérieure à la date de départ.";
        return false; // Empêche la soumission du formulaire
    } else {
        document.getElementById("errorr-message").innerHTML = ""; // Efface le message d'erreur s'il n'y a pas d'erreur
        return true; // Permet la soumission du formulaire
    }
}
</script>