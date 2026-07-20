<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice;

interface CoordinatesInterface
{
    public function getLatitude(): float;

    public function getLongitude(): float;
}
