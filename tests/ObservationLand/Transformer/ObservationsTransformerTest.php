<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\ObservationLand\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\ObservationLand\Model\ObservationInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformer;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationsTransformerInterface;
use ChristianBrown\MetOffice\ObservationLand\Transformer\ObservationTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ObservationsTransformer::class)]
final class ObservationsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-observation-1'], ['test-observation-2']];

        $observation1 = self::createStub(ObservationInterface::class);
        $observation2 = self::createStub(ObservationInterface::class);
        $observations = [$observation1, $observation2];

        $observationTransformer = self::createStub(ObservationTransformerInterface::class);
        $observationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-observation-1'], $observation1],
                    [['test-observation-2'], $observation2],
                ]
            );

        $transformer = new ObservationsTransformer($observationTransformer);

        self::assertSame($observations, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $observationTransformer = self::createStub(ObservationTransformerInterface::class);

        $transformer = new ObservationsTransformer($observationTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $observation1 = self::createStub(ObservationInterface::class);

        $observationTransformer = self::createMock(ObservationTransformerInterface::class);
        $observationTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-observation-1'])
            ->willReturn($observation1);

        $transformer = new ObservationsTransformer($observationTransformer);

        self::assertSame([$observation1], $transformer->transform([['test-observation-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $observationTransformer = self::createStub(ObservationTransformerInterface::class);

        $transformer = new ObservationsTransformer($observationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ObservationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ObservationsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-observation-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-observation-1-array'], 'test-observation-2-not-array', ['test-observation-3-array'], 'test-observation-4-not-array'];

        $observation1 = self::createStub(ObservationInterface::class);
        $observation3 = self::createStub(ObservationInterface::class);

        $observationTransformer = self::createStub(ObservationTransformerInterface::class);
        $observationTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-observation-1-array'], $observation1],
                    [['test-observation-3-array'], $observation3],
                ]
            );

        $transformer = new ObservationsTransformer($observationTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ObservationsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ObservationsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
