<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Transformer;

use ChristianBrown\MetOffice\Model\Forecast;
use ChristianBrown\MetOffice\Model\ForecastTimeStepInterface;
use ChristianBrown\MetOffice\Transformer\ForecastTimeStepsTransformerInterface;
use ChristianBrown\MetOffice\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\Transformer\ForecastTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Forecast::class)]
#[CoversClass(ForecastTransformer::class)]
final class ForecastTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $timeSeries = [['test-step-1'], ['test-step-2']];
        $properties = [
            ForecastTransformerInterface::KEY_LOCATION => [
                ForecastTransformerInterface::KEY_NAME => 'test-location-name',
            ],
            ForecastTransformerInterface::KEY_MODEL_RUN_DATE => '2026-07-16T11:00Z',
            ForecastTransformerInterface::KEY_TIME_SERIES => $timeSeries,
        ];

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep2 = self::createStub(ForecastTimeStepInterface::class);
        $timeSteps = [$timeStep1, $timeStep2];

        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::once())
            ->method('transform')
            ->with($timeSeries)
            ->willReturn($timeSteps);

        $transformer = new ForecastTransformer($timeStepsTransformer);

        $actual = $transformer->transform($properties);

        self::assertSame('test-location-name', $actual->getLocationName());
        self::assertSame(1784199600, $actual->getModelRunDate());
        self::assertSame($timeSteps, $actual->getTimeSteps());
    }

    public function testTransformMinimal(): void
    {
        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer);

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLocationName());
        self::assertNull($actual->getModelRunDate());
        self::assertSame([], $actual->getTimeSteps());
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsLocationNameCases')]
    public function testTransformSkipsLocationName(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer);

        $actual = $transformer->transform($properties);

        self::assertNull($actual->getLocationName());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsLocationNameCases(): iterable
    {
        yield 'locationAbsent' => [[]];
        yield 'locationWrongType' => [[ForecastTransformerInterface::KEY_LOCATION => 'not-an-array']];
        yield 'nameAbsent' => [[ForecastTransformerInterface::KEY_LOCATION => ['test-location-filler']]];
        yield 'nameWrongType' => [[ForecastTransformerInterface::KEY_LOCATION => [ForecastTransformerInterface::KEY_NAME => 42]]];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsModelRunDateCases')]
    public function testTransformSkipsModelRunDate(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer);

        $actual = $transformer->transform($properties);

        self::assertNull($actual->getModelRunDate());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsModelRunDateCases(): iterable
    {
        yield 'modelRunDateAbsent' => [[]];
        yield 'modelRunDateWrongType' => [[ForecastTransformerInterface::KEY_MODEL_RUN_DATE => 42]];
        yield 'modelRunDateInvalidDate' => [[ForecastTransformerInterface::KEY_MODEL_RUN_DATE => 'not-a-valid-date']];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsTimeStepsCases')]
    public function testTransformSkipsTimeSteps(array $properties): void
    {
        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer);

        $actual = $transformer->transform($properties);

        self::assertSame([], $actual->getTimeSteps());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsTimeStepsCases(): iterable
    {
        yield 'timeSeriesAbsent' => [[]];
        yield 'timeSeriesWrongType' => [[ForecastTransformerInterface::KEY_TIME_SERIES => 'not-an-array']];
    }
}
