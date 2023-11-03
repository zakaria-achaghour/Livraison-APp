<?php 
namespace App\Enums;

enum ClaimsStatusEnum: int 
{
    case Team_Response_Pending = 1; 
    case Waiting_For_Customer_Response = 2; 
    case Claim_Processed= 3; 
    
}