<?php 
namespace App\Enums;

enum ParcelStatusEnum: String 
{
    case NEW_PARCEL = 'NEW_PARCEL'; 
    case WAITING_PICKUP = 'WAITING_PICKUP';
    case PICKED_UP = 'PICKED_UP';
    case DELIVERED = 'DELIVERED';
    case RETURNED = 'RETURNED';

}