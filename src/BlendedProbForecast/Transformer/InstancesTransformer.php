<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class InstancesTransformer implements InstancesTransformerInterface
{
    private InstanceTransformerInterface $instanceTransformer;

    public function __construct(InstanceTransformerInterface $instanceTransformer)
    {
        $this->instanceTransformer = $instanceTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, InstanceInterface>
     */
    public function transform(array $data): array
    {
        $instances = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $instanceData = $values[$i];
            if (!is_array($instanceData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $instances[] = $this->instanceTransformer->transform($instanceData);
        }

        return $instances;
    }
}
