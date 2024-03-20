@extends('document::layouts.master')

@section('content')
<?php
$codes = [
    'client',
    'date_commande',
    'numero_enregistrement_commande',
    'numero_reference_commande',
    'poids',
    'livre_par',
    'origine',
    'bl_code_producteur',
    'nom_cooperative',
    'no_lots',
    'variete_fruits',
    'bl_date_recolte',
    'no_vehicule',
    'nom_conducteur',
    'tel_conducteur',
    'nom_convoyeur',
    'tel_convoyeur',
    'date_signature',
    'heure_signature',
    'signataire',
    'nom_conducteur',
    'nom_conducteur',
    'immatriculation_numero',
    'titre_entreprise_livreur',
    'siege_social_livreur',
    'tel_livreur',
    'poids_choix_1',
    'maturite_choix_1',
    'taux_sucre_choix_1',
    'poids_choix_2',
    'maturite_choix_2',
    'taux_sucre_choix_2',
    //'livre_par',  Ajouter le reste des clés
];
$items = get_etapte_detail_attributs($chaine_valeur_etape_detail_id, $codes, $groupe)
?>
<style>
    .table-bordered {
      border: 1px solid #000;
      /* border-right-width: 0;
      border-spacing: 0;
      border-collapse: collapse */
    }
    
    /* .table-bordered th, */
    .table-bordered td {
      border: 1px solid #000;
      text-align: center
    }

    .py-1 {
        padding: 10px 0px;
    }

    .py-2 {
        padding: 2px 0px;
    }
        
    #img_logo {
        max-height: 100px; 
        /* width: auto; */
    }    

    footer {
        position: fixed; 
        bottom: 0px; 
        left: 0px; 
        right: 0px;
        text-align: center;
    }
</style>
<table style="border-bottom: 3px solid #000; width: 100%; margin-top: -50px; margin-bottom: 0px">
    <tr>
        <td style="width: 20%;">
            @include("document::chaine_valeur_etape_detail._logo")
        </td>
        <td style="width: 80%; text-align: center;">
            <h3>
                {{ get_collection_element_valeur($items, 'titre_entreprise_livreur') }}                
            </h3>
            <p>Immatriculation <small>{{ get_collection_element_valeur($items, 'immatriculation_numero') }}</small></p>
        </td>
    </tr>
</table>
{{-- <hr style="border-bottom: 3px solid #000; margin-top: 0px; padding-top: 0px"> --}}
<div style="line-height: 1">
    <div style="line-height: 0.7">
        <p>Siège social : {{ get_collection_element_valeur($items, 'siege_social_livreur') }}</p>
        <p>Tél : {{ get_collection_element_valeur($items, 'tel_livreur') }}</p>
        <p>République du Bénin</p>
        <h3 style="text-align: center;"><i>FICHE DE LIVRAISON D'ANANAS</i></h3>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">Client : {{ get_collection_element_valeur($items, 'client') }}</td>
                <td style="width: 50%;">Numéro du processus : <span style="font-weight: bold; color: red;">{{ $chaine_valeur->code }}</span></td>
            </tr>
        </table>        
    </div>
    @if (tenant()->id != 'promofruit')
        <div style="border: 1px solid; width: 100%; padding: 1px">
            <div style="border: 1px solid; width: auto; padding: 10px 2px">
                <table style="width: 100%;">
                    <tr>
                        <td style="width: 50%;">Commande</td>
                        <td style="width: 50%;">Date : {{ get_collection_element_valeur($items, 'date_commande') }}</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;">Réf No : {{ get_collection_element_valeur($items, 'numero_reference_commande') }}</td>
                        <td style="width: 50%;">Poids : {{ get_collection_element_valeur($items, 'poids') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Nos N° d'enregistrement de commande : </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="width: 50%;">Réf : {{ get_collection_element_valeur($items, 'numero_enregistrement_commande') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @endif

    <div style="line-height: 0.7">
        <p>Livré par : {{ get_collection_element_valeur($items, 'livre_par') }}</p>
        <p>Origine : {{ get_collection_element_valeur($items, 'origine') }}</p>
        <p>Code du producteur : {{ get_collection_element_valeur($items, 'bl_code_producteur') }}, <span style="margin-left: 15px">Coopérative : {{ get_collection_element_valeur($items, 'nom_cooperative') }}</span></p>
        <p>Variété fruits : {{ get_collection_element_valeur($items, 'variete_fruits') }}, <span style="margin-left: 15px">Numéro de lot : {{ get_collection_element_valeur($items, 'no_lots') }}</span></p>
        <p>Date de récolte : {{ get_collection_element_valeur($items, 'bl_date_recolte') }}</p>
        <p>Date de livraison : {{ get_collection_element_valeur($items, 'bl_date_recolte') }}</p> 
        <p>N° Véhicule : {{ get_collection_element_valeur($items, 'no_vehicule') }}</p>
        <p>Nom / Tel du Conducteur : {{ get_collection_element_valeur($items, 'nom_conducteur') }} {{ get_collection_element_valeur($items, 'tel_conducteur') }}</p>
        @if (tenant()->id != 'promofruit')
            <p>Nom / Tel du Convoyeur : {{ get_collection_element_valeur($items, 'nom_convoyeur') }} {{ get_collection_element_valeur($items, 'tel_convoyeur') }}</p>
        @endif
    </div>

    <table class="table-bordered" style="width: 100%; margin-top: 20px; margin-bottom: 20px;">
        <tr>
            @if (tenant()->id != 'promofruit')
                <td class="py-2" style="width: 20%;" colspan="4">Caractéristique des fruits</td>
            @else
            <td class="py-2" style="width: 20%;" colspan="2">Caractéristique des fruits</td>
            @endif
        </tr>
        <tr>
            <td class="py-2"></td>
            @if (tenant()->id != 'promofruit')
                <td class="py-2">1er choix</td>
                <td class="py-2">2e choix</td>
                <td class="py-2">TOTAL</td>   
            @else    
                <td class="py-2">Choix</td>         
            @endif
        </tr>
        <tr>
            <td class="py-2">Calibre</td>
            <td class="py-2">>= 800g</td>
            @if (tenant()->id != 'promofruit')
                <td class="py-2">700g-800g</td>
                <td class="py-2"></td>
            @endif
        </tr>
        <tr>
            <td class="py-1">Poids Fruits (kg)</td>
            <td class="py-1">{{ get_collection_element_valeur($items, 'poids_choix_1') }}</td>
            @if (tenant()->id != 'promofruit')
                <td class="py-1">{{ get_collection_element_valeur($items, 'poids_choix_2') }}</td>
                <td class="py-1">{{ floatval(get_collection_element_valeur($items, 'poids_choix_1')) + floatval(get_collection_element_valeur($items, 'poids_choix_2')) }}</td>
            @endif
        </tr>
        <tr>
            <td class="py-1">Maturité</td>
            <td class="py-1">{{ get_collection_element_valeur($items, 'maturite_choix_1') }}</td>
            @if (tenant()->id != 'promofruit')
                <td class="py-1">{{ get_collection_element_valeur($items, 'maturite_choix_2') }}</td>
                <td class="py-1"></td>
            @endif
        </tr>
        <tr>
            <td class="py-1">Taux de sucre</td>
            <td class="py-1">{{ get_collection_element_valeur($items, 'taux_sucre_choix_1') }}</td>
            @if (tenant()->id != 'promofruit')
                <td class="py-1">{{ get_collection_element_valeur($items, 'taux_sucre_choix_2') }}</td>
                <td class="py-1">{{ (floatval(get_collection_element_valeur($items, 'taux_sucre_choix_1')) + floatval(get_collection_element_valeur($items, 'taux_sucre_choix_2'))/2)}}</td>
            @endif
        </tr>
    </table>
    @if (tenant()->id != 'promofruit')
        <div style="border: 1px solid #000; line-height: 0.7; padding: 0px 5px">
            <p style="width: 100%; text-align: center">Reçu</p>
            <p>Ce jour Par : {{ get_collection_element_valeur($items, 'signataire') }}</p>
            <p>Heure : {{ get_collection_element_valeur($items, 'heure_signature') }}, les Ananas détaillés ci-dessus</p>
            <p>Le {{ get_collection_element_valeur($items, 'date_signature') }} </p>
            <p style="width: 100%; text-align: center">Signature du réceptionnaire</p>
        </div>
    @endif
</div>

<footer style="text-align: center;">{!! $footer !!}</footer>
@endsection
