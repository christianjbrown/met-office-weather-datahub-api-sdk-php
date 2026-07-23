<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class Axis implements AxisInterface
{
    /**
     * @var array<int, float>
     */
    private array $floatValues = [];
    private string $name;

    /**
     * @var array<int, string>
     */
    private array $stringValues = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return array<int, float>
     */
    public function getFloatValues(): array
    {
        return $this->floatValues;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, string>
     */
    public function getStringValues(): array
    {
        return $this->stringValues;
    }

    /**
     * @param array<int, float> $value
     */
    public function setFloatValues(array $value): AxisInterface
    {
        $this->floatValues = $value;

        return $this;
    }

    public function setName(string $value): AxisInterface
    {
        $this->name = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setStringValues(array $value): AxisInterface
    {
        $this->stringValues = $value;

        return $this;
    }
}
