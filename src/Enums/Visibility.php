<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Enums;

enum Visibility: string
{
    case EXCELLENT = 'EX';
    case GOOD = 'GO';
    case MODERATE = 'MO';
    case POOR = 'PO';
    case UNKNOWN = 'UN';
    case VERY_GOOD = 'VG';
    case VERY_POOR = 'VP';
}
