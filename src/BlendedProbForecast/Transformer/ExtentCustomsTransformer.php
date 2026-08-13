<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentCustomInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class ExtentCustomsTransformer implements ExtentCustomsTransformerInterface
{
    private ExtentCustomTransformerInterface $extentCustomTransformer;

    public function __construct(ExtentCustomTransformerInterface $extentCustomTransformer)
    {
        $this->extentCustomTransformer = $extentCustomTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, ExtentCustomInterface>
     */
    public function transform(array $data): array
    {
        $customs = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $customData = $values[$i];
            if (!is_array($customData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $customs[] = $this->extentCustomTransformer->transform($customData);
        }

        return $customs;
    }
}
