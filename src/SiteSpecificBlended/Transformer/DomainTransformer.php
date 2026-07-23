<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Domain;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\DomainInterface;

use function is_array;

final class DomainTransformer implements DomainTransformerInterface
{
    private AxesTransformerInterface $axesTransformer;

    public function __construct(AxesTransformerInterface $axesTransformer)
    {
        $this->axesTransformer = $axesTransformer;
    }

    /**
     * @param mixed[] $data
     */
    public function transform(array $data): DomainInterface
    {
        $domain = new Domain();

        $this->applyAxes($domain, $data);

        return $domain;
    }

    /**
     * @phpstan-param mixed[] $data
     */
    private function applyAxes(Domain $domain, array $data): void
    {
        if (!isset($data[self::KEY_AXES])) {
            return;
        }
        if (!is_array($data[self::KEY_AXES])) {
            return;
        }
        $domain->setAxes($this->axesTransformer->transform($data[self::KEY_AXES]));
    }
}
