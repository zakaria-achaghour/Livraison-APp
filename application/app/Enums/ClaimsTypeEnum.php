<?php 
namespace App\Enums;

enum ClaimsTypeEnum: String 
{

    case URGENT_DELIVERY = 'Urgent Delivery';
    case REQUEST_ANOTHER_ATTEMPT = "Request Another Attempt";
    case PRICE_CHANGE = "Price Change";
    case NUMBER_CHANGE = "Number Change";
    case CHANGE_OF_RECIPIENT = "Change Of Recipient";
    case UPDATE_DELAY = "Update Delay";
    case CANCEL_REQUEST ="Cancel Request";
    
}