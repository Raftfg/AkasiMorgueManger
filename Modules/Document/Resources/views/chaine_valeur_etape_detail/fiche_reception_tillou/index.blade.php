@extends('document::layouts.master')

@section('content')
    <?php
        $codes = [
            'mpa_redige_par',
            'mpa_valide_par',
            'mpa_fournie',
            'mpa_fournisseur',
            'mpa_date',
            'reception_numero',
            'reception_critere',
            'mpa_receptionnaire',
            'mpa_livreur',
        ];
        $items = get_etapte_detail_attributs($chaine_valeur_etape_detail_id, $codes)
    ?>

    <style>
        .table-bordered {
        border: 1px solid #000;
        /* border-right-width: 0; */
        border-spacing: 0;
        border-collapse: collapse
        }
        
        /* .table-bordered th, */
        .table-bordered td , .table-bordered th {
        border: 1px solid #000;
        /* text-align: center */
        text-align: left;
        padding-left: 10px;
        padding-right: 10px;
        }
        
        .table-bordered .double-line th {
        border: 2px solid #000;
        /* text-align: center */
        text-align: left;
        padding-left: 10px;
        padding-right: 10px;
        }

        tr td, tr th {
            height: 1.2rem;
        }

        th {
            font-weight: 700;
        }       

        footer {
            position: fixed; 
            bottom: 0px; 
            left: 0px; 
            right: 0px;
            text-align: center;
        }
        
        #img_logo {
            max-height: 100%; 
            width: 150px;
            height: auto;
        }
    </style>

    <table class="table-bordered" style="width: 100%;">
        <tr>
            <th rowspan="4" style="width: 18%; text-align: center">@include("document::chaine_valeur_etape_detail._logo")</th>
            <th colspan="2" rowspan="3" style="text-align: center">ENREGISTREMENT <br><br> RECEPTION MATIERE PREMIERE ALIMENTAIRE</th>
            <th>Code : AH-E-08</th>
        </tr>
        <tr>
            <th>Date : 17/02/2021</th>
        </tr>
        <tr>
            <th>Version : 1</th>
        </tr>
        <tr>
            <th>Rédigé par : {{ get_collection_element_valeur($items, 'mpa_redige_par') }}</th>
            <th>Validé par : {{ get_collection_element_valeur($items, 'mpa_valide_par') }}</th>
            <th>Page 1 sur 2</th>
        </tr>
    </table>

    <br>
    {{-- <hr style="border-bottom: 3px solid #000; margin-top: 0px; padding-top: 0px"> --}}
    <table style="width: 100%">
        <tr>
            <td style="width:33.333333%"><b>Date :</b> {{ date("d/m/Y", strtotime(get_collection_element_valeur($items, 'mpa_date'))) }}</td>
            <td style="width:33.333333%"><b>N° Lot Interne :</b> {{ get_collection_element_valeur($items, 'reception_critere') }}{{ get_collection_element_valeur($items, 'reception_numero') }}</td>
            <td style="width:33.333333%"><b>Fiche de réception N° :</b> {{ str_pad(get_collection_element_valeur($items, 'reception_numero'), 6, "0", STR_PAD_LEFT) }}</td>{{--   fonction pour avoir 6 chiffres avec des 0 au début--}}
        </tr>
        <tr>
            <td colspan="3">
                <b>Fournisseur :</b> {{ get_collection_element_valeur($items, 'mpa_fournisseur') }}
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <b>MPA Fournie :</b> {{ get_collection_element_valeur($items, 'mpa_fournie') }}
            </td>
        </tr>
    </table>
    <br>

    <table class="table-bordered" style="width: 100%; font-size :12px">
        <tr>
            <th rowspan="2">CODE</th>
            <th rowspan="2">N° PLAQUE VEHICULE</th>
            <th rowspan="2">HEURES DE LIVRAISON</th>
            <th rowspan="2">ETAT DU VEHICULE (PROPRE OU SALE)</th>
            <th rowspan="2">ORIGINE</th>
            <th rowspan="2">N° LOT FOURNISSEUR/ PRODUCTEURS</th>
            <th colspan="2">MPA REJETEE</th>
            <th rowspan="2">QUANTITE KG <br>1ER CHOIX<br> >800g</th>
            <th rowspan="2">QUANTITE KG <br>2EME CHOIX<br> 700g-800g</th>
            <th rowspan="2">QUANTITE KG TOTAL RECEPTION</th>
        </tr>
        <tr>
            <th>MOTIF DU REJET</th>
            <th>QUANTITE KG REJETE</th>
        </tr>
        @php
            $groupe_codes = [
                'mpa_code_vehicule',
                'mpa_plaque_vehicule',
                'mpa_heure_livraison',
                'mpa_etat',
                'mpa_origine',
                'mpa_lot_fournisseur',
                'mpa_qte_conforme_1',
                'mpa_qte_conforme_2',
                'mpa_qte_rejetee',
                'mpa_motif_rejet',
                'reception_numero',
                'reception_critere',
            ];
            $i = 0; $total_choix1 = 0; $total_choix2 = 0; $total_rejet = 0;
        @endphp
        @foreach($groupes as $groupe)
            @php 
                $attributs = get_etapte_detail_attributs($chaine_valeur_etape_detail_id, $groupe_codes, $groupe->groupe); 
                $total_choix1 += intval(get_collection_element_valeur($attributs, 'mpa_qte_conforme_1'));
                $total_choix2 += intval(get_collection_element_valeur($attributs, 'mpa_qte_conforme_2'));
                $total_rejet += intval(get_collection_element_valeur($attributs, 'mpa_qte_rejetee'));
                $total = intval(get_collection_element_valeur($attributs, 'mpa_qte_conforme_1')) + intval(get_collection_element_valeur($attributs, 'mpa_qte_conforme_2')) - intval(get_collection_element_valeur($attributs, 'mpa_qte_rejetee'));
                $i++;
            @endphp
            <tr>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_code_vehicule') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_plaque_vehicule') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_heure_livraison') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_etat') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_origine') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_lot_fournisseur') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_motif_rejet') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_qte_rejetee') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_qte_conforme_1') }}</td>
                <td>{{ get_collection_element_valeur($attributs, 'mpa_qte_conforme_2') }}</td>
                <td>{{ $total }}</td>
            </tr>
        @endforeach
        <tr class="double-line">
            <th colspan="7" style="text-align: center">QUANTITE KG TOTAL</th>
            <th>{{ $total_rejet }}</th>
            <th>{{ $total_choix1 }}</th>
            <th>{{ $total_choix2 }}</th>
            <th>{{ ($total_choix1 + $total_choix2 - $total_rejet) }}</th>
        </tr>
    </table>

    <table style="width: 100%; margin-top: 20px">
        <tr>
            <th style="width: 50%; text-align: left">Nom, prénoms et signature du réceptionnaire</th>
            <th style="width: 50%; text-align: right">Nom, prénoms et signature du livreur</th>
        </tr>
        <tr>
            <td style="height: 60px; text-align: left"></td>
            <td style="height: 60px; text-align: right"></td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left">{{ get_collection_element_valeur($items, 'mpa_receptionnaire') }}</td>
            <td style="width: 50%; text-align: right">{{ get_collection_element_valeur($items, 'mpa_livreur') }}</td>
        </tr>
    </table>

    <footer style="text-align: center;">{!! $footer !!}</footer>
@endsection
