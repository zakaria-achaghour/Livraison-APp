<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Parcel extends Model
{
    use HasFactory;

    protected $table = 'parcel';
    protected $primaryKey = 'parcel_id';


    /*
    ***************
    RELATIONS
    ***************
    */
    public function city() {
        return $this->belongsTo(City::class, 'parcel_city', 'id');
    }

    public function history() {
        return $this->hasMany(ParcelHistory::class, 'parcel_history_parcel', 'parcel_id');
    }

    public function deliveryNotes()
    {
        return $this->belongsToMany(DeliveryNote::class, 'dn_parcels', 'dn_parcels_parcel', 'dn_parcels_dn');
    }

    public function parcelEdit()
    {
        return $this->hasOne(ParcelEdit::class, 'parcel_edit_code', 'parcel_code')->orderBy('parcel_edit_time', 'desc');
    }

    public function content()
    {
        return $this->hasMany(ParcelContent::class, 'parcel_content_parcel_id', 'parcel_id');
    }

    public function livreur()
    {
        return $this->belongsTo(User::class, 'parcel_livreur', 'users_id')->where('users_active',  1);
    }


    /*
    ***************
    FUNCTIONS
    ***************
    */
    public function canBeEdited()  {
        return in_array($this->parcel_status,["PICKED_UP", "SENT", "RECEIVED", "IN_PROGRESS"]);
    }


    public function getAvatarLetters() {
        $names = explode(" ", trim($this->parcel_receiver));
        if(count($names) == 0) {
            return "?";
        }
        else if(count($names) == 1) {
            return mb_strtoupper(substr($names[0], 0, 2));
        }
        else {
            return mb_strtoupper(substr($names[0], 0, 1).substr($names[1], 0, 1));
        }
    }

    public static function getStatus($status) {
        $delevery_parcel_statut = allStatus();

        if(!isset($delevery_parcel_statut[$status])) {
            return ['text' => '****', 'color' => '#fff'];
        }

        return $delevery_parcel_statut[$status];
    }


    public function getStatusColored() {
        $delevery_parcel_statut = allStatus();
        $status = $this->parcel_status == 'IN_PROGRESS' ? $this->parcel_status_second : $this->parcel_status;

        if(!isset($delevery_parcel_statut[$status])) {
            return ['text' => '****', 'color' => '#777'];
        }

        $return_status = $delevery_parcel_statut[$status];

        if($status == 'RETURNED') {
            $last_parcel_history = ParcelHistory::where('parcel_history_parcel', $this->parcel_id)->where('parcel_history_status', 'RETURNED')->whereNotNull('parcel_history_comment')->orderBy('parcel_history_id', 'DESC')->first();

            if(!empty($last_parcel_history)) {
                $return_status['text'] = $last_parcel_history->parcel_history_comment;
            }
        }

        if($status == 'POSTPONED' || $status == 'PROGRAMMER') {
            $history = ParcelHistory::where('parcel_history_parcel', $this->parcel_id)->where('parcel_history_status_second', $status)->orderBy('parcel_history_data', 'DESC')->first();
            if(!empty($history) && !empty($history->parcel_history_data)) {
                $link = ($status == 'POSTPONED') ? __('au') : __('pour le');
                $time = ' '.$link.' '.date("d/m/Y", $history->parcel_history_data);
                $return_status['text'] = $return_status['text'].$time;
            }
        }

        if($status == 'PICKED_UP' || $status == 'RECEIVED' || $status == 'SENT') {
            $history = ParcelHistory::where('parcel_history_parcel', $this->parcel_id)->where('parcel_history_status', $status)->orderBy('parcel_history_data', 'DESC')->with('movmentsZone')->first();

            if(!empty($history) && $history->movmentsZone != null) {
                $link = $status == 'PICKED_UP' ? __('à') : ($status == 'RECEIVED' ? __('par') :  __('vers'));
                $zone = ' '.$link.' '.strtoupper($history->movmentsZone->zone_name);
                $return_status['text'] = $return_status['text'].$zone;
            }
        }

        return $return_status;
    }

    public function generateCode($cityCode) {
        $random_lettres = Str::upper(Str::random(2));
        $code = $cityCode.date("m").date("y").$this->parcel_id.$random_lettres;

        return $code;
    }

    public function generateCodeInerne() {
        $random_lettres = Str::upper(Str::random(1));
        $random_number = rand(100, 9999);
        $code = $random_lettres.$this->parcel_id.'-'.date("m").'-'.date("d").'-'.$random_number;

        return $code;
    }

    public function addParcelHistory($parcelCity,$parcelSituation,$parcelStatus,$parcelBy,$movments = null,$note_id = null,$addtime=0) {
        $history = new ParcelHistory();
        $history->parcel_history_parcel = $this->parcel_id;
        $history->parcel_history_city = $parcelCity;
        $history->parcel_history_situation = $parcelSituation;
        $history->parcel_history_status = $parcelStatus;
        $history->parcel_history_time = time() + $addtime;
        $history->parcel_history_by = $parcelBy;
        $history->parcel_movments = $movments;
        $history->parcel_note_id = $note_id;
        $history->save();
    }

    public function changeInfoDetails($old_values, $new_values) {
        $change_info = '';
        $keys = [];

        $fields = [
            'phone' => 'Téléphone',
            'price' => 'Prix',
            //'city' => 'Ville',
            'address' => 'Adresse',
            'receiver' => 'Destinataire',
            'note' => 'Commentaire'
        ];

        foreach ($fields as $field => $label) {
            if ($old_values[$field] != $new_values[$field]) {
                $change_info .= '<b>' . $label . ' : </b>' . $old_values[$field] . ' <b> ==> </b>' . $new_values[$field] . ' <br>';
                array_push($keys, $field);
            }
        }

        $result = ["keys" => $keys, "infos" => $change_info];
        return $result;
    }


    /*public function getAttribute($key)
    {
        // Check if the key starts with the prefix or if it's a special Eloquent attribute
        if (array_key_exists($key, $this->attributes)) {
            return parent::getAttribute($key);
        }

        return parent::getAttribute('parcel_' . $key);
    }

    public function setAttribute($key, $value)
    {
        // Check if the key starts with the prefix or if it's a special Eloquent attribute
        if (array_key_exists($key, $this->attributes)) {
            return parent::setAttribute($key, $value);
        }

        return parent::setAttribute('parcel_' . $key, $value);
    }*/
}
