<?php
namespace App\Enums;

enum BankTypeEnum : int {
    case STATE_BANK = 0;
    case PRIVATE_BANK = 1;
    case CREDIT_INSTITUTION = 2;
}
