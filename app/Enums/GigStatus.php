<?php

namespace App\Enums;

enum GigStatus: string {
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}