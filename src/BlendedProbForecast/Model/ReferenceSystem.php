<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Model;

final class ReferenceSystem implements ReferenceSystemInterface
{
    private ?string $calendar = null;

    /**
     * @var array<int, string>
     */
    private array $coordinates;
    private ?string $id = null;

    /**
     * @var array<array-key, string>
     */
    private array $identifiers = [];
    private ?string $label = null;
    private ?string $type = null;

    /**
     * @param array<int, string> $coordinates
     */
    public function __construct(array $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    public function getCalendar(): ?string
    {
        return $this->calendar;
    }

    /**
     * @return array<int, string>
     */
    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return array<array-key, string>
     */
    public function getIdentifiers(): array
    {
        return $this->identifiers;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setCalendar(?string $value): ReferenceSystemInterface
    {
        $this->calendar = $value;

        return $this;
    }

    /**
     * @param array<int, string> $value
     */
    public function setCoordinates(array $value): ReferenceSystemInterface
    {
        $this->coordinates = $value;

        return $this;
    }

    public function setId(?string $value): ReferenceSystemInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<array-key, string> $value
     */
    public function setIdentifiers(array $value): ReferenceSystemInterface
    {
        $this->identifiers = $value;

        return $this;
    }

    public function setLabel(?string $value): ReferenceSystemInterface
    {
        $this->label = $value;

        return $this;
    }

    public function setType(?string $value): ReferenceSystemInterface
    {
        $this->type = $value;

        return $this;
    }
}
