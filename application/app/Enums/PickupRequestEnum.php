<?php 
namespace App\Enums;

enum PickupRequestEnum: String 
{

    case NEW = 'NEW';
    case RECEIVED = 'RECEIVED';
    case TREATED = 'TREATED';

}