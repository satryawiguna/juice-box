<?php

namespace App\Enums;

enum MessageType: string
{
    case ERROR = 'ERROR';
    case WARNING = 'WARNING';
    case INFO = 'INFO';
    case SUCCESS = 'SUCCESS';
}
