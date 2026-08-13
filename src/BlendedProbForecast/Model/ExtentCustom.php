<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class ExtentCustom implements ExtentCustomInterface
{
    private string $id;

    /**
     * @var array<int, string>
     */
    private array $interval = [];
    private ?string $reference = null;

    /**
     * @var array<int, string>
     */
    private array $values = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, string>
     */
    public function getInterval(): array
    {
        return $this->interval;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    /**
     * @return array<int, string>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    public function setId(string $value): ExtentCustomInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setInterval(array $value): ExtentCustomInterface
    {
        $this->interval = $value;

        return $this;
    }

    public function setReference(?string $value): ExtentCustomInterface
    {
        $this->reference = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setValues(array $value): ExtentCustomInterface
    {
        $this->values = $value;

        return $this;
    }
}
