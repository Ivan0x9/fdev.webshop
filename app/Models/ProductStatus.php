<?php

namespace App\Models;

enum ProductStatus:string {
    case Draft       = 'draft';
    case Available   = 'available';
    case Unavailable = 'unavailable';
    case Retired     = 'retired';
}