<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\MapImages\Model\RunDetailInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class RunDetailsTransformer implements RunDetailsTransformerInterface
{
    private RunDetailTransformerInterface $runDetailTransformer;

    public function __construct(RunDetailTransformerInterface $runDetailTransformer)
    {
        $this->runDetailTransformer = $runDetailTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RunDetailInterface>
     */
    public function transform(array $data): array
    {
        $runDetails = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $runDetailData = $values[$i];
            if (!is_array($runDetailData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $runDetails[] = $this->runDetailTransformer->transform($runDetailData);
        }

        return $runDetails;
    }
}
