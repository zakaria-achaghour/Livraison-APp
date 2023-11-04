<?php 
namespace App\Enums;

enum TrackingReceiptStatusEnum: String 
{
    case NEW = 'Nouveau'; 
    case Received = 'Recu'; 
    case WAITING_FOR_PAYMENT= 'Attente de paiement'; 
    case DRAFT = 'Brouillon';
    case PAID = 'payé';
    
}