<?php
/*
|--------------------------------------------------------------------------
| Get Global Setting
|--------------------------------------------------------------------------
*/

function allStatus() {
      return  [
            'NOT_PAID'=> ['text' => __('Non Payé'),'color' => '#25a0d7'],
            'PAID'=> ['text' => __('Payé'),'color' => '#00fa00'],
            'NEW_PARCEL'=> ['text' => __('Nouveau Colis'),'color' => '#25a0d7'],
            'WAITING_PICKUP'=> ['text' => __('Attente De Ramassage'),'color' => '#ff9300'],
            'PICKED_UP'=> ['text' => __('Ramassé'),'color' => '#ff9300'],
            'SENT'=> ['text' => __('Expédié'),'color' => '#0432ff'],
            'RECEIVED'=> ['text' => __('Reçu'),'color' => '#237623'],
            'DISTRIBUTION'=> ['text' => __('Mise en distribution'),'color' => '#25a0d7'],
            'IN_PROGRESS'=> ['text' => __('En cours'),'color' => '#25a0d7'],
            'DELIVERED'=> ['text' => __('Livré'),'color' => '#00fa00'],
            'DELIVERED'=> ['text' => __('Livré'),'color' => '#00fa00'],
            'RETURNED'=> ['text' => __('Retourné'),'color' => '#ff2600'],
            'POSTPONED'=> ['text' => __('Reporté'),'color' => '#25a0d7'],
            'NOANSWER'=> ['text' => __('Pas de réponse + SMS'),'color' => '#25a0d7'],
            'UNREACHABLE'=> ['text' => __('Injoignable'),'color' => '#25a0d7'],
            'OUT_OF_AREA'=> ['text' => __('Hors-zone'),'color' => '#25a0d7'],
            'CANCELED'=> ['text' => __('Annulé'),'color' => '#25a0d7'],
            'INVOICED'=> ['text' => __('Facturé'),'color' => '#942092'],
            'REFUSE'=> ['text' => __('Refusé'),'color' => '#EB1A00'],
            'SENT_BY_AMANA'=> ['text' => __('expédier par AMANA'),'color' => '#EB1A00'],
            'RETURN_BY_AMANA'=> ['text' => __('En retour par AMANA'),'color' => '#eb1a00'],
            'ERR'=> ['text' => __('Numero_Erroné '),'color' => '#831000'],
            'DEUX'=> ['text' => __('Deuxième Appel Pas Réponse'),'color' => '#3a88fe'],
            'TROIS'=> ['text' => __('Troisième Appel Pas Réponse'),'color' => '#0042aa'],
            'ERR'=> ['text' => __('Numero_Erroné '),'color' => '#831000'],
            'CLIENT_INTERESE'=> ['text' => __('Client intéressé'),'color' => '#000000'],
            'CANCELED_BY_VENDEUR'=> ['text' => __('Annulé par Vendeur'),'color' => '#db5151'],
            'PROGRAMMER'=> ['text' => __('Programmé'),'color' => '#d91717'],
            'EN_VOYAGE'=> ['text' => __('En Voyage'),'color' => '#a7ed16'],
            'RELENCE_NEW_CLIENT'=> ['text' => __('Relancé nouveau client'),'color' => '#ff4d00'],
            'WAIT_RELANCE'=> ['text' => __('Attende de relancer'),'color' => '#ff781f'],
            'QUATRE'=> ['text' => __('Quatrième Appel Pas De Réponse'),'color' => '#a200fa'],
            'LATER'=> ['text' => __('PLUS TARD'),'color' => '#b5ff00'],
            'DOUBLE'=> ['text' => __('Double'),'color' => '#f202d2'],
            'INJOI'=> ['text' => __('injoignable  ( suivi )'),'color' => '#5b4343'],
            'ANN'=> ['text' => __('Annulé (équipe Quick livraison )'),'color' => '#1d1121']
        ];
}

function setting($name) {
      $setting = \App\Models\Config::where('configs_var', $name)->first();

      if(empty($setting)) return null;

      return $setting->configs_val;
}

function set_setting($name, $value) {
      $setting = \App\Models\Setting::where('name', $name)->first();

      if(!empty($setting)) {
            $setting->value = $value;
            $setting->save();
      }
}