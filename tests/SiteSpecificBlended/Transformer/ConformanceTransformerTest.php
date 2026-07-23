<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ConformanceTransformer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConformanceTransformer::class)]
final class ConformanceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            'http://www.opengis.net/spec/ogcapi-common-1/1.0/conf/core',
            42,
            'http://www.opengis.net/spec/ogcapi-edr-1/1.0/conf/core',
        ];

        self::assertSame(
            [
                'http://www.opengis.net/spec/ogcapi-common-1/1.0/conf/core',
                'http://www.opengis.net/spec/ogcapi-edr-1/1.0/conf/core',
            ],
            (new ConformanceTransformer())->transform($data)
        );
    }

    public function testTransformEmpty(): void
    {
        self::assertSame([], (new ConformanceTransformer())->transform([]));
    }
}
