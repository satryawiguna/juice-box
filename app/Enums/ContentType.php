<?php

namespace App\Enums;

enum ContentType: string
{
    case JSON = 'JSON';
    case FORM_DATA = 'FORM_DATA';
    case X_WWW_FORM_URLENCODED = 'X_WWW_FORM_URLENCODED';
}
