<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\LinkInterface;

use function array_values;
use function count;
use function is_array;
use function sprintf;

final class LinksTransformer implements LinksTransformerInterface
{
    private LinkTransformerInterface $linkTransformer;

    public function __construct(LinkTransformerInterface $linkTransformer)
    {
        $this->linkTransformer = $linkTransformer;
    }

    /**
     * @param mixed[] $data
     *
     * @return array<int, LinkInterface>
     */
    public function transform(array $data): array
    {
        $links = [];
        $values = array_values($data);
        for ($i = 0, $count = count($values); $i < $count; ++$i) {
            $linkData = $values[$i];
            if (!is_array($linkData)) {
                throw new UnexpectedResponseException(sprintf(self::UNEXPECTED_ARRAY_SPRINTF, self::ARRAY_NAME));
            }
            $links[] = $this->linkTransformer->transform($linkData);
        }

        return $links;
    }
}
