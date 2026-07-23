<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;

use function array_keys;
use function count;
use function is_array;
use function sprintf;

final class ParametersTransformer implements ParametersTransformerInterface
{
    private ParameterTransformerInterface $parameterTransformer;

    public function __construct(ParameterTransformerInterface $parameterTransformer)
    {
        $this->parameterTransformer = $parameterTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<string, ParameterInterface>
     */
    public function transform(array $data): array
    {
        $parameters = [];
        $keys = array_keys($data);
        for ($i = 0, $count = count($keys); $i < $count; ++$i) {
            $key = (string) $keys[$i];
            $parameterData = $data[$keys[$i]];
            if (!is_array($parameterData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $parameterData[ParameterTransformerInterface::KEY_ID] = $key;
            $parameters[$key] = $this->parameterTransformer->transform($parameterData);
        }

        return $parameters;
    }
}
