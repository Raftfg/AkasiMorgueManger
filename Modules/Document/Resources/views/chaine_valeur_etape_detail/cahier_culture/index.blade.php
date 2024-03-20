@extends('document::layouts.master')

@section('content')
<?php
$codes = [
    'livre_par',
    'production',
    "itineraire_technique",
    "choix_terrain",
    "defrichage",
    "labour",
    "nivellement",
    "epandage",
    "recherche_achat_rejet",
    "calibrage_rejets_triage",
    "distribution_rejets",
    "distribution_rejets",
    "piquetage",
    "planting",
    "sarclage",
    "fertilisation_sol",
    "tif",
    "comptage_fleurs_recolte",
    "recolte_fruits",
    "ethrelage",
    "sarclage_fertilisation_parcelle",
    "recolte_rejets",
    "cahier_culture",
    'exploitation',
    'phase_maladies_ravageurs',
    'operations_culturales',
    'traitements_phytosanitaires',
    'utilisation_herbicides',
    'insecticides_fongicides',
    'controle_maturite_fruit',
    'maturite',
    'couleur_fruit',
    'taux_brix',
    'utilisation_intrant',
    'date_recolte',
    'variete',
    'hormonage_florale',
    'quantite_fruit_recolte',
    'date_plantation',
    'exploitation_variete',
    'nom_producteur',
    'commune_producteur',
    'arrondissement_producteur',
    'village_producteur',
    'sexe_producteur',
    'age_producteur',
    'niveau_etude_producteur',
    'cooperative_producteur',
    'code_cooperative_producteur',
    'code_producteur',
    'duree_estimee_production',
    'volume_estime_production',
    'principale_legumineuse',
    'gestion_intrants',
    'fertilisants',
    'engrais',
    'localisation_exploitation',
    'cartographie_parcelle',
    'latitude',
    'longitude',
    'superficie',
    'nord',
    'sud',
    'est',
    'ouest',
    'operations_culturales',
    'operations_culturales_superficie',
    'nombre_plants',
    'code_parcelle',
    'historique',
    'conditionnement',
    'tri_rejet_produit',
    'etat_matiere_premiere',
    'pesee_quantification',
    'pesee_quantification_poids',
    'pesee_quantification_unite',
    'pesee_quantification_date',
    'nom_cooperative',
    //'livre_par',  Ajouter le reste des clés
];
$items = get_etapte_detail_attributs($chaine_valeur_etape_detail_id, $codes, $groupe)
?>
<style>
    .page-break {
        page-break-after: always;
    }
    .mb-5 {
        margin-bottom: 55px!important;
    }
    .mt-0 {
        margin-top: 0px!important;
    }
    .pt-0 {
        padding-top: 0px!important;
    }
    .table-bordered {
      border: 1px solid #000;
      /* border-right-width: 0;
      border-spacing: 0;
      border-collapse: collapse */
    }
    .table-bordered-simple {
      border: 1px solid #000;
      /* border-right-width: 0; */
      border-spacing: 0;
      border-collapse: collapse
    }
    
    /* .table-bordered th, */
    .table-bordered td, .table-bordered-simple td , .table-bordered-simple th {
      border: 1px solid #000;
      /* text-align: center */
      text-align: left;
      padding-left: 10px;
      padding-right: 10px;
    }

    tr td{
        height: 1rem;
    }

    .py-1 {
        padding: 10px 0px;
    }

    .py-2 {
        padding: 2px 0px;
    }
</style>
<div style="border: 5px solid green; border-radius: 5%; width: 100%; padding: 1px; position: absolute; bottom : 10px; top: 10px">
    <!-- <div style="border: 1px solid;border-radius: 1px ; width: auto; padding: 10px 2px; position: absolute; "> -->
    <br class="mb-5">
        <h3  style="text-align: center;">
            @if (tenant()->id == 'repab')
                RÉSEAU DES PRODUCTEURS D'ANANAS DU BÉNIN (RéPAB)<br> 
                ANANAS LEADER
            @else
                AGROTRACER <br><br>       
            @endif
        </h3>
        <table class="" style="width: 100%;">
            <tr>
                <td style="text-align: center;">
                    <img src="{{ env('FRONTEND_URL_LOGO_REPAB') }}" class="" style="max-height: 160px; justify-content: center;" alt="{{ config('app.name') }} Logo">
                </td>
            </tr>
        </table>
        <div>
        </div>
        <div>
            <h3  style="font-size: 80px; text-align: center;">
                CAHIER<br> DE <br> CULTURE <br> BIOLOGIQUE
            </h3>
            <p style="text-align: center;"><u>Nom et Prénom du Producteur</u> : {{ get_collection_element_valeur($items, 'nom_producteur') }}</p>
        </div>
        <!-- <footer style="position: fixed; bottom : 0px; width: 100%;">
            <div style="border: 1px solid; width: 100%; padding: 1px">
                <div style="border: 1px solid;border-radius: 1px ; width: auto; padding: 10px 2px">
                    <p style="text-align: center;">{!! $footer !!}</p>
                </div>
            </div>
        </footer> -->
    <!-- </div> -->
</div>

<div class="page-break"></div>

<table style="width: 100%;">
    <tr>
        <td style="width: 20%;">
            <img src="{{ env('FRONTEND_URL_LOGO_REPAB') }}" class="" style="max-height: 120px;" alt="{{ config('app.name') }} Logo">
        </td>
        <td style="width: 80%;">
            <h3>
                @if (tenant()->id == 'repab')
                    RÉSEAU DES PRODUCTEURS D'ANANAS DU BÉNIN (RéPAB)<br> 
                    ANANAS LEADER
                    @php
                        // get_collection_element_valeur($items, 'nom_cooperative')
                    @endphp 
                @else
                    AGROTRACER  <br><br>    
                @endif
            </h3>
            {{-- <p><b>Siège social :</b> Allada BP 329 Allada, Quartier Dodomey, maison HOUNSA Z. Abel</p>
            <p>Tél : (00229) 21 10 02 00 République du Bénin, Email : répab1@yahoo.fr</p> --}}
        </td>
    </tr>
</table>
<hr>
<div style="text-align: center;">
    <h3>SOCIETE COOPERATIVE DES PRODUCTEURS D'ANANAS</h3>
    {{-- <p>Colli DE Agbame</p> --}}
    <p></p>
    <p>&laquo; SCOOPS &raquo;</p>
    <br class="mb-5">
    <br class="mb-5">
    <br class="mb-5">
    <h1 class="mb-0" style="font-size: 58px;">ANANAS BIOLOGIQUE</h1>
    {{-- <h4 class="mt-0 pt-0">Certifié suivant les règlements CE/834/2007 et 889/2008 ; NOP</h4> --}}
</div>
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<h3><u>Nom et Prénom du Producteur</u> : {{ get_collection_element_valeur($items, 'nom_producteur') }}</h3>
<h3><u>Code Producteur</u> : {{ get_collection_element_valeur($items, 'code_producteur') }}</h3>
<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>

<div class="page-break"></div>

<h5>Nom et Prénom : {{ get_collection_element_valeur($items, 'nom_producteur') }}</h5>
<h5>Commune : {{ get_collection_element_valeur($items, 'commune_producteur') }}</h5>
<h5>Arrondissement : {{ get_collection_element_valeur($items, 'arrondissement_producteur') }}</h5>
<h5>Village : {{ get_collection_element_valeur($items, 'village_producteur') }}</h5>
<h5>Sexe : {{ get_collection_element_valeur($items, 'sexe_producteur') }}</h5>
<h5>Age : {{ get_collection_element_valeur($items, 'age_producteur') }} ans</h5>
<h5>Niveau d'étude : {{ get_collection_element_valeur($items, 'niveau_etude_producteur') }}</h5>
<h5>Coopérative : {{ get_collection_element_valeur($items, 'cooperative_producteur') }}</h5>
<h5>Code Coopérative : {{ get_collection_element_valeur($items, 'code_cooperative_producteur') }}</h5>
<h5>Code Producteur : {{ get_collection_element_valeur($items, 'code_producteur') }}</h5>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>

<div class="page-break"></div>

<h2 style="text-align: center;">EXPLOITATION</h2>
<h4>Spéculation et Superficie</h4>
<div>Spéculation : <span>Ananas</span></div>
<div>Superficie (ha) : <span>{{ get_collection_element_valeur($items, 'superficie') }}</span></div>
<br class="mb-5">
<br class="mb-5">
<br class="mb-5">
<h4>Principale légumineuses</h4>
<ul>
    @php
        $legumineuses = caster_champ_json(get_collection_element_valeur($items, 'principale_legumineuse'));
    @endphp
    @foreach($legumineuses as $legumineuse)
        <li>{{ $legumineuse['valeur'] }}</li>
    @endforeach
</ul>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>
<div class="page-break"></div>

<h3 style="text-align: center;">Maladies Ravageurs</h3>
<h4>Maladies Ravageurs</h4>
<ul>
    @php
        $maladies_ravageurs = caster_champ_json(get_collection_element_valeur($items, 'phase_maladies_ravageurs'));
    @endphp
    @foreach($maladies_ravageurs as $maladies_ravageur)
        <li>{{ $maladies_ravageur['valeur'] }}</li>
    @endforeach
</ul>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>
<div class="page-break"></div>

<h3 style="text-align: center;">Intrants Utilisés</h3>
<table class="table-bordered-simple" style="width: 100%;">
    <tr>
        <th style="text-align: center;">Intrants</th>
    </tr>
    @php
    $fertilisants = caster_champ_json(get_collection_element_valeur($items, 'fertilisants'));
    $engrais = caster_champ_json(get_collection_element_valeur($items, 'engrais'));
    @endphp
    @foreach($fertilisants as $fertilisant)
        <tr>
            <td>{{ $fertilisant['valeur'] }}</td>
        </tr>
    @endforeach
    @foreach($engrais as $engrai)
        <tr>
            <td>{{ $engrai['valeur'] }}</td>
        </tr>
    @endforeach
</table>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>
<div class="page-break"></div>

<h3 style="text-align: center;">OPERATIONS CULTURALES PAR PARCELLE</h3>
<li>
    Superficie parcelle ananas biologique : {{ get_collection_element_valeur($items, 'operations_culturales_superficie') }}
</li>
<li>
    Nombre de Plants : {{ get_collection_element_valeur($items, 'nombre_plants') }}
<li>
    Code de Parcelle : {{ get_collection_element_valeur($items, 'code_parcelle') }}
</li>
<li>Historique (Précédents culturaux)
    <ul>
        @php
            $historiques = caster_champ_json(get_collection_element_valeur($items, 'historique'));
        @endphp
        @foreach($historiques as $historique)
            <li>{{ $historique['valeur'] }}</li>
        @endforeach
    </ul>
</li>
<li>
    Variété : {{ get_collection_element_valeur($items, 'variete') }}
</li>
<br class="mb-5"><br class="mb-5">
<table class="table-bordered-simple" style="width: 100%;">
    <tr>
        <th style="text-align: center;">Opérations effectuées</th>
        <th style="text-align: center;">Observations</th>
    </tr>
    <tr>
        <td>Choix du terrain</td>
        <td>{{ get_collection_element_valeur($items, 'choix_terrain') }}</td>
    </tr>
    <tr>
        <td>Défrichage</td>
        <td>{{ get_collection_element_valeur($items, 'defrichage') }}</td>
    </tr>
    <tr>
        <td>Nivellement</td>
        <td>{{ get_collection_element_valeur($items, 'nivellement') }}</td>
    </tr>
    <tr>
        <td>Labour</td>
        <td>{{ get_collection_element_valeur($items, 'labour') }}</td>
    </tr>
    <tr>
        <td>Achat de rejet</td>
        <td>{{ get_collection_element_valeur($items, 'recherche_achat_rejet') }}</td>
    </tr>
    <tr>
        <td>Calibrage / Parage des rejets</td>
        <td>{{ get_collection_element_valeur($items, 'calibrage_rejets_triage') }}</td>
    </tr>
    <tr>
        <td>Distribution des rejets</td>
        <td>{{ get_collection_element_valeur($items, 'distribution_rejets') }}</td>
    </tr>
    <tr>
        <td>Piquetage</td>
        <td>{{ get_collection_element_valeur($items, 'piquetage') }}</td>
    </tr>
    <tr>
        <td>Epandage</td>
        <td>{{ get_collection_element_valeur($items, 'epandage') }}</td>
    </tr>
    <tr>
        <td>Planting</td>
        <td>{{ get_collection_element_valeur($items, 'planting') }}</td>
    </tr>
    <tr>
        <td>Sarclage</td>
        <td>{{ get_collection_element_valeur($items, 'sarclage') }}</td>
    </tr>
    <tr>
        <td>Utilisation des herbicides</td>
        <td>
            <ul>
                @php
                    $herbicides = caster_champ_json(get_collection_element_valeur($items, 'utilisation_herbicides'));
                @endphp
                @foreach($herbicides as $herbicide)
                    <li>{{ $herbicide['valeur'] }}</li>
                @endforeach
            </ul>
        </td>
    </tr>
    <tr>
        <td>Insecticides, fongicides</td>
        <td>
            <ul>
                @php
                    $insecticides = caster_champ_json(get_collection_element_valeur($items, 'insecticides_fongicides'));
                @endphp
                @foreach($insecticides as $insecticide)
                    <li>{{ $insecticide['valeur'] }}</li>
                @endforeach
            </ul>
            </td>
    </tr>
    <tr>
        <td>Fertilisation du sol</td>
        <td>{{ get_collection_element_valeur($items, 'fertilisation_sol') }}</td>
    </tr>
    <tr>
        <td>TIF (Traitement d’induction florale) + MO</td>
        <td>{{ get_collection_element_valeur($items, 'tif') }}</td>
    </tr>
    <tr>
        <td>Comptage des fleurs et récolte</td>
        <td>{{ get_collection_element_valeur($items, 'comptage_fleurs_recolte') }}</td>
    </tr>
    <tr>
        <td>Récolte des fruits</td>
        <td>{{ get_collection_element_valeur($items, 'recolte_fruits') }}</td>
    </tr>
    <tr>
        <td>Ethrélage</td>
        <td>{{ get_collection_element_valeur($items, 'ethrelage') }}</td>
    </tr>
    {{-- <tr>
        <td>Sarclage et/ou fertilisation de la parcelle</td>
        <td>{{ get_collection_element_valeur($items, 'sarclage_fertilisation_parcelle') }}</td>
    </tr> --}}
    <tr>
        <td>Récolte des rejets</td>
        <td>{{ get_collection_element_valeur($items, 'recolte_rejets') }}</td>
    </tr>
</table>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>
<div class="page-break"></div>

<h3 style="text-align: center;"><u>PLAN DE L'EXPLOITATION / <br>PARCELLE AVEC ORIENTATION GEOGRAPHIQUE</u></h3>
<h3><u>Code Producteur</u> : {{ get_collection_element_valeur($items, 'code_producteur') }}</h3>
<table style="width: 100%;">
    <tr>
        <td style="width: 65%;">
            <!-- <img src="{{ global_asset('images/geoplan.png') }}" class="" style="max-height: 120px;" alt="plan"> -->
        </td>
        <td style="width: 35%;">
            <li>Nord : {{ get_collection_element_valeur($items, 'nord') }}</li>
            <li>Sud : {{ get_collection_element_valeur($items, 'sud') }}</li>
            <li>Ouest : {{ get_collection_element_valeur($items, 'ouest') }}</li>
            <li>Est : {{ get_collection_element_valeur($items, 'est') }}</li>
        </td>
    </tr>
</table>

<footer style="position: fixed; bottom : 0px; width: 100%;">
    <p style="text-align: center;">{!! $footer !!}</p>
</footer>
@endsection