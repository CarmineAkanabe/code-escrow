<?php

namespace App\Enums;

enum TransactionStatus: string{
    case HELD = 'held';
    case RELEASED = 'released';
}