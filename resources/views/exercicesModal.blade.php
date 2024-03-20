{{-- NOUVEL EXERCICE --}}
{{-- <div class="modal fade" id="new-exercice">
    <div class="modal-dialog"
    
    </div>
   
</div> --}}
<!-- /.modal -->

<!-- nouveau corps -->
<div class="modal fade" id="new-corps">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('exercice.store') }}" method="post"  onsubmit="return validateDates()">
                {{-- <form action="{{ route('exercice.store') }}" method="post"> --}}
                @csrf
                <div class="modal-header bg-secondary">
                    <h5 class="modal-title">Ajout d'un nouveau corps</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nom_defunt">Nom du défunt</label>
                                    <input type="text" class="form-control" id="nom_defunt" name="nom_defunt" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="prenom_defunt">Prénom du défunt</label>
                                    <input type="text" class="form-control" id="prenom_defunt" name="prenom_defunt" required>
                                </div>
                            </div>
                           <div class="row">
                            <div class="form-group col-md-6">
                                <label for="date_naissance">Date de naissance</label>
                                <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_deces">Date de décès</label>
                                <input type="date" class="form-control" id="date_deces" name="date_deces" required>
                            </div>
                            <div id="error-message" class="text-danger"></div>
                           </div>
                           <div class="row">
                            <div class="form-group col-md-12">
                                <label for="lieu_deces">Lieu de décès</label>
                                <input type="text" class="form-control" id="lieu_deces" name="lieu_deces" required>
                            </div>
                            
                           </div>
                           <div class="row">
                            <div class="form-group col-md-6">
                                <label for="id_morgue">Morgue</label>
                                <select class="form-control" id="id_morgue" name="morgue_id" required>
                                    <!-- Option pour sélectionner la morgue -->
                                    @foreach ($morgues as $morgue)
                                    <option value="{{$morgue->uuid}}">{{$morgue->libelle}}</option>
                                    @endforeach
                                   
                                   
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="id_etat_corps">État du corps</label>
                                <select class="form-control" id="id_etat_corps" name="etat_corps" required>
                                    <!-- Option pour sélectionner l'état du corps -->
                                    <option value="En attente d'examen">En attente d'examen</option>
                                    <option value="Prêt pour la libération">Prêt pour la libération</option>
                                </select>
                            </div>
                           </div>
                           <div class="row">
                            <div class="form-group col-md-12">
                                <label for="cause_deces">Cause de décès</label>
                                <textarea type="text" class="form-control" id="cause_deces" name="cause_décès" required></textarea> 
                            </div>
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
</div>
{{-- DETAILS --}}
{{-- <div class="modal fade" id="details">
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
            </div>
        </div>
     
    </div>
    
</div> --}}
<div class="modal fade" id="details">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title">Détails d'un corps</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mt-3">
                    <table class="table table-striped table-borderless">
                        <tbody>
                            <tr>
                                <th>Nom du défunt</th>
                                <td id="see_nom_defunt"></td>
                            </tr>
                            <tr>
                                <th>Prénom du défunt</th>
                                <td id="see_prenom_defunt"></td>
                            </tr>
                            <tr>
                                <th>Date de naissance</th>
                                <td id="see_date_naissance"></td>
                            </tr>
                            <tr>
                                <th>Date de décès</th>
                                <td id="see_date_deces"></td>
                            </tr>
                            <tr>
                                <th>Lieu de décès</th>
                                <td id="see_lieu_deces"></td>
                            </tr>
                            <tr>
                                <th>État du corps</th>
                                <td id="see_etat_corps"></td>
                            </tr>
                            <tr>
                                <th>Cause de décès</th>
                                <td id="see_cause_deces"></td>
                            </tr>
                            <tr>
                                <th>Morgue</th>
                                <td id="see_morgue_id"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /.modal -->

{{-- UPDATE --}}
{{-- <div class="modal fade" id="update">
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
</div> --}}
<div class="modal fade" id="update">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="upd_form" action="" method="post" enctype="multipart/form-data" onsubmit="return validateDate()">
                @csrf
                {{ method_field('PUT') }}
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Modification d'un corps</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="nom_defunt">Nom du défunt</label>
                                <input type="text" class="form-control" id="upd_nom_defunt" name="nom_defunt" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="prenom_defunt">Prénom du défunt</label>
                                <input type="text" class="form-control" id="upd_prenom_defunt" name="prenom_defunt" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="date_naissance">Date de naissance</label>
                                <input type="date" class="form-control" id="upd_date_naissance" name="date_naissance" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date_deces">Date de décès</label>
                                <input type="date" class="form-control" id="upd_date_deces" name="date_deces" required>
                            </div>
                            <div id="errorr-message" class="text-danger"></div>
                        </div>
                       <div class="row">
                        <div class="form-group col-md-12">
                            <label for="lieu_deces">Lieu de décès</label>
                            <input type="text" class="form-control" id="upd_lieu_deces" name="lieu_deces" required>
                        </div>
                       </div>
                       <div class="row">
                        <div class="form-group col-md-6">
                            <label for="morgue_id">Morgue</label>
                            <select class="form-control" id="upd_morgue_id" name="morgue_id" required>
                                <!-- Option pour sélectionner la morgue -->
                                @foreach ($morgues as $morgue)
                                <option value="{{$morgue->uuid}}">{{$morgue->libelle}}</option>
                                @endforeach
                            </select>
                         </div>
                            <div class="form-group col-md-6">
                                <label for="etat_corps">État du corps</label>
                                <select class="form-control" id="upd_etat_corps" name="etat_corps" required>
                                    <option value="En attente d'examen">En attente d'examen</option>
                                    <option value="Prêt pour la libération">Prêt pour la libération</option>
                                </select>
                            </div>
                       </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="cause_décès">Cause de décès</label>
                                <textarea class="form-control" id="upd_cause_deces" name="cause_décès" rows="3" required></textarea>
                            </div>
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
    </div>
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
{{-- <script>
    function validateDates() {
        var dateNaissance = new Date(document.getElementById("date_naissance").value);
        var dateDeces = new Date(document.getElementById("date_deces").value);

        if (dateDeces < dateNaissance) {
            alert("La date de décès ne peut pas être antérieure à la date de naissance.");
            return false; // Empêche la soumission du formulaire
        }
        return true; // Permet la soumission du formulaire
    }
</script> --}}
<script>
    function validateDates() {
        var dateNaissance = new Date(document.getElementById("date_naissance").value);
        var dateDeces = new Date(document.getElementById("date_deces").value);

        if (dateDeces < dateNaissance) {
            document.getElementById("error-message").innerHTML = "La date de décès ne peut pas être antérieure à la date de naissance.";
            return false; // Empêche la soumission du formulaire
        } else {
            document.getElementById("error-message").innerHTML = ""; // Réinitialise le message d'erreur
            return true; // Permet la soumission du formulaire
        }
    }

    function validateDate() {
    var dateNaissance = new Date(document.getElementById("upd_date_naissance").value);
    var dateDeces = new Date(document.getElementById("upd_date_deces").value);

    if (dateDeces < dateNaissance) {
        document.getElementById("errorr-message").innerHTML = "La date de décès ne peut pas être antérieure à la date de naissance.";
        return false; // Empêche la soumission du formulaire
    } else {
        document.getElementById("errorr-message").innerHTML = ""; // Efface le message d'erreur s'il n'y a pas d'erreur
        return true; // Permet la soumission du formulaire
    }
}
</script>

