<?php 
namespace App\Enums;

enum TrackingReceiptTypeEnum: String 
{
    case RETURN_NOTE = 'retrun_note'; 
    case DELIVERY_NOTE = 'delivery_note';
    case SENT_NOTE = 'sent_note';
    case PAYMENT_NOTE = 'payment_note';
    
}