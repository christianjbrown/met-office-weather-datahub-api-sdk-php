<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Model;

final class NdArray implements NdArrayInterface
{
    /**
     * @var array<int, string>
     */
    private array $axisNames = [];
    private ?string $dataType = null;
    private string $id;

    /**
     * @var array<int, int>
     */
    private array $shape = [];

    /**
     * @var array<int, null|float>
     */
    private array $values = [];

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return array<int, string>
     */
    public function getAxisNames(): array
    {
        return $this->axisNames;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array<int, int>
     */
    public function getShape(): array
    {
        return $this->shape;
    }

    /**
     * @return array<int, null|float>
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array<int, string> $value
     */
    public function setAxisNames(array $value): NdArrayInterface
    {
        $this->axisNames = $value;

        return $this;
    }

    public function setDataType(?string $value): NdArrayInterface
    {
        $this->dataType = $value;

        return $this;
    }

    public function setId(string $value): NdArrayInterface
    {
        $this->id = $value;

        return $this;
    }

    /**
     * @param array<int, int> $value
     */
    public function setShape(array $value): NdArrayInterface
    {
        $this->shape = $value;

        return $this;
    }

    /**
     * @param array<int, null|float> $value
     */
    public function setValues(array $value): NdArrayInterface
    {
        $this->values = $value;

        return $this;
    }
}
