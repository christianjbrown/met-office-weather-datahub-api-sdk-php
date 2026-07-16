<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\RunDetailInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunDetailsTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunDetailsTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\RunDetailTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RunDetailsTransformer::class)]
final class RunDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-run-detail-1'], ['test-run-detail-2']];

        $runDetail1 = self::createStub(RunDetailInterface::class);
        $runDetail2 = self::createStub(RunDetailInterface::class);
        $runDetails = [$runDetail1, $runDetail2];

        $runDetailTransformer = self::createStub(RunDetailTransformerInterface::class);
        $runDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-run-detail-1'], $runDetail1],
                    [['test-run-detail-2'], $runDetail2],
                ]
            );

        $transformer = new RunDetailsTransformer($runDetailTransformer);

        self::assertSame($runDetails, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $runDetailTransformer = self::createStub(RunDetailTransformerInterface::class);

        $transformer = new RunDetailsTransformer($runDetailTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $runDetail1 = self::createStub(RunDetailInterface::class);

        $runDetailTransformer = self::createMock(RunDetailTransformerInterface::class);
        $runDetailTransformer->method('transform')
            ->with(['test-run-detail-1'])
            ->willReturn($runDetail1);

        $transformer = new RunDetailsTransformer($runDetailTransformer);

        self::assertSame([$runDetail1], $transformer->transform([['test-run-detail-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $runDetailTransformer = self::createStub(RunDetailTransformerInterface::class);

        $transformer = new RunDetailsTransformer($runDetailTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RunDetailsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-run-detail-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-run-detail-1-array'], 'test-run-detail-2-not-array', ['test-run-detail-3-array'], 'test-run-detail-4-not-array'];

        $runDetail1 = self::createStub(RunDetailInterface::class);
        $runDetail3 = self::createStub(RunDetailInterface::class);

        $runDetailTransformer = self::createStub(RunDetailTransformerInterface::class);
        $runDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-run-detail-1-array'], $runDetail1],
                    [['test-run-detail-3-array'], $runDetail3],
                ]
            );

        $transformer = new RunDetailsTransformer($runDetailTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RunDetailsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
