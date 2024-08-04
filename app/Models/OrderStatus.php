<?php

namespace App\Models;

enum OrderStatus:string {
    case Pending   = 'pending';
    case Payment   = 'awaiting payment';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Refunded  = 'refunded';
    case Declined  = 'declined';
}