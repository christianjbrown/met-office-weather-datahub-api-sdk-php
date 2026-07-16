<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\MapImages\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\MapImages\Model\RunInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class RunsTransformer implements RunsTransformerInterface
{
    private RunTransformerInterface $runTransformer;

    public function __construct(RunTransformerInterface $runTransformer)
    {
        $this->runTransformer = $runTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, RunInterface>
     */
    public function transform(array $data): array
    {
        $runs = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $runData = $values[$i];
            if (!is_array($runData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $runs[] = $this->runTransformer->transform($runData);
        }

        return $runs;
    }
}
