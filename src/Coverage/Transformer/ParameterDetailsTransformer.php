<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\ParameterDetailInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ParameterDetailsTransformer implements ParameterDetailsTransformerInterface
{
    private ParameterDetailTransformerInterface $parameterDetailTransformer;

    public function __construct(ParameterDetailTransformerInterface $parameterDetailTransformer)
    {
        $this->parameterDetailTransformer = $parameterDetailTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ParameterDetailInterface>
     */
    public function transform(array $data): array
    {
        $parameterDetails = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $parameterDetailData = $values[$i];
            if (!is_array($parameterDetailData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $parameterDetails[] = $this->parameterDetailTransformer->transform($parameterDetailData);
        }

        return $parameterDetails;
    }
}
