<?php

namespace App\Models;

enum AddressType:string {
    case Billing  = 'billing';
    case Shipping = 'shipping';
    case Contact  = 'contact';
}