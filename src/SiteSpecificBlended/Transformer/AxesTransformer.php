<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\AxisInterface;

use function array_keys;
use function count;
use function is_array;
use function sprintf;

final class AxesTransformer implements AxesTransformerInterface
{
    private AxisTransformerInterface $axisTransformer;

    public function __construct(AxisTransformerInterface $axisTransformer)
    {
        $this->axisTransformer = $axisTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<string, AxisInterface>
     */
    public function transform(array $data): array
    {
        $axes = [];
        $keys = array_keys($data);
        for ($i = 0, $count = count($keys); $i < $count; ++$i) {
            $key = (string) $keys[$i];
            $axisData = $data[$keys[$i]];
            if (!is_array($axisData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $axisData[AxisTransformerInterface::KEY_NAME] = $key;
            $axes[$key] = $this->axisTransformer->transform($axisData);
        }

        return $axes;
    }
}
