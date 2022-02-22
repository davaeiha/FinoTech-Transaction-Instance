<?php

namespace App\Enums;

enum StatusEnum : int {
    case FAILED = 0;
    case PENDING = 1;
    case DONE = 2;
}
