<?php
namespace App\Enums;

enum ReasonEnum : int{
    case DEPOSIT_SALARY  = 0;
    case INSURANCE = 1;
    case MEDICAL_AFFAIRS = 2;
    case INVESTMENT_STOCK_EXCHANGE = 3;
    case CURRENCY_AFFAIRS = 4;
    case DEBT_PAYMENT = 5;
    case PENSION_AFFAIRS = 6;
    case MOVABLE_PROPERTY = 7;
    case IMMOVABLE_PROPERTY = 8;
    case CASH_MANAGEMENT = 9;
    case CUSTOMS_DUTIES = 10;
    case TAX_SETTLEMENT = 11;
    case GOVERNMENT_SERVICES = 12;
    case FACILITIES_AND_COMMITMENTS = 13;
    case DEPOSIT_OF_COLLATERAL = 14;
    case DAILY_EXPENSES = 15;
    case CHARITABLE_CONTRIBUTIONS = 16;
    case PURCHASE_GOODS = 17;
    case PURCHASE_SERVICES = 18;
}
