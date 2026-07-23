<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\CoverageInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoveragesTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoveragesTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(CoveragesTransformer::class)]
final class CoveragesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['coverage-1'], ['coverage-2']];

        $coverage1 = self::createStub(CoverageInterface::class);
        $coverage2 = self::createStub(CoverageInterface::class);

        $coverageTransformer = self::createStub(CoverageTransformerInterface::class);
        $coverageTransformer->method('transform')
            ->willReturnMap(
                [
                    [['coverage-1'], $coverage1],
                    [['coverage-2'], $coverage2],
                ]
            );

        $transformer = new CoveragesTransformer($coverageTransformer);

        self::assertSame([$coverage1, $coverage2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $coverageTransformer = self::createStub(CoverageTransformerInterface::class);

        $transformer = new CoveragesTransformer($coverageTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $coverageTransformer = self::createStub(CoverageTransformerInterface::class);

        $transformer = new CoveragesTransformer($coverageTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CoveragesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CoveragesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
