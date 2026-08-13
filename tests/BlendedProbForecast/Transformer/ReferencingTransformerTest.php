<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ReferenceSystemInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferenceSystemTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ReferencingTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ReferencingTransformer::class)]
final class ReferencingTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['system-1'], ['system-2']];

        $system1 = self::createStub(ReferenceSystemInterface::class);
        $system2 = self::createStub(ReferenceSystemInterface::class);

        $referenceSystemTransformer = self::createStub(ReferenceSystemTransformerInterface::class);
        $referenceSystemTransformer->method('transform')
            ->willReturnMap(
                [
                    [['system-1'], $system1],
                    [['system-2'], $system2],
                ]
            );

        $transformer = new ReferencingTransformer($referenceSystemTransformer);

        self::assertSame([$system1, $system2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $referenceSystemTransformer = self::createStub(ReferenceSystemTransformerInterface::class);

        $transformer = new ReferencingTransformer($referenceSystemTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $referenceSystemTransformer = self::createStub(ReferenceSystemTransformerInterface::class);

        $transformer = new ReferencingTransformer($referenceSystemTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ReferencingTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ReferencingTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
