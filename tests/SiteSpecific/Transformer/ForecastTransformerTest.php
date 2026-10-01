<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\SiteSpecific\Model\Forecast;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Model\ParameterMetadataInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ParameterMetadataTransformerInterface;
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
                ForecastTransformerInterface::KEY_LICENCE => 'test-licence',
            ],
            ForecastTransformerInterface::KEY_MODEL_RUN_DATE => '2026-07-16T11:00Z',
            ForecastTransformerInterface::KEY_TIME_SERIES => $timeSeries,
            ForecastTransformerInterface::KEY_REQUEST_POINT_DISTANCE => 123,
            ForecastTransformerInterface::KEY_GEOMETRY => [
                ForecastTransformerInterface::KEY_COORDINATES => ['-0.1', '51.5', '12.5'],
            ],
            ForecastTransformerInterface::KEY_PARAMETERS => [
                [
                    'test-parameter-1' => ['test-parameter-data-1'],
                    'test-parameter-2' => ['test-parameter-data-2'],
                ],
                [
                    'test-parameter-3' => ['test-parameter-data-3'],
                ],
            ],
        ];

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep2 = self::createStub(ForecastTimeStepInterface::class);
        $timeSteps = [$timeStep1, $timeStep2];

        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::once())
            ->method('transform')
            ->with($timeSeries)
            ->willReturn($timeSteps);

        $parameterMetadata1 = self::createStub(ParameterMetadataInterface::class);
        $parameterMetadata2 = self::createStub(ParameterMetadataInterface::class);
        $parameterMetadata3 = self::createStub(ParameterMetadataInterface::class);
        $parameterMetadataTransformer = self::createMock(ParameterMetadataTransformerInterface::class);
        $parameterMetadataTransformer->expects(self::exactly(3))
            ->method('transform')
            ->willReturnMap(
                [
                    [['test-parameter-data-1'], $parameterMetadata1],
                    [['test-parameter-data-2'], $parameterMetadata2],
                    [['test-parameter-data-3'], $parameterMetadata3],
                ]
            );

        $transformer = new ForecastTransformer($timeStepsTransformer, $parameterMetadataTransformer);

        $actual = $transformer->transform($properties);

        self::assertSame('test-location-name', $actual->getLocationName());
        self::assertSame('test-licence', $actual->getLocationLicence());
        self::assertSame(1784199600, $actual->getModelRunDate());
        self::assertSame($timeSteps, $actual->getTimeSteps());
        self::assertSame(123.0, $actual->getRequestPointDistance());
        self::assertSame(12.5, $actual->getElevation());
        self::assertSame(
            [
                'test-parameter-1' => $parameterMetadata1,
                'test-parameter-2' => $parameterMetadata2,
                'test-parameter-3' => $parameterMetadata3,
            ],
            $actual->getParameters()
        );
    }

    public function testTransformMinimal(): void
    {
        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

        $actual = $transformer->transform([]);

        self::assertNull($actual->getLocationName());
        self::assertNull($actual->getLocationLicence());
        self::assertNull($actual->getModelRunDate());
        self::assertSame([], $actual->getTimeSteps());
        self::assertNull($actual->getRequestPointDistance());
        self::assertNull($actual->getElevation());
        self::assertSame([], $actual->getParameters());
    }

    public function testTransformParametersEmptyGroup(): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);
        $parameterMetadataTransformer = self::createMock(ParameterMetadataTransformerInterface::class);
        $parameterMetadataTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer, $parameterMetadataTransformer);

        $actual = $transformer->transform([ForecastTransformerInterface::KEY_PARAMETERS => [[]]]);

        self::assertSame([], $actual->getParameters());
    }

    public function testTransformParametersEmptyGroups(): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);
        $parameterMetadataTransformer = self::createMock(ParameterMetadataTransformerInterface::class);
        $parameterMetadataTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer, $parameterMetadataTransformer);

        $actual = $transformer->transform([ForecastTransformerInterface::KEY_PARAMETERS => []]);

        self::assertSame([], $actual->getParameters());
    }

    public function testTransformRequestPointDistanceFloat(): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

        $actual = $transformer->transform([ForecastTransformerInterface::KEY_REQUEST_POINT_DISTANCE => 123.5]);

        self::assertSame(123.5, $actual->getRequestPointDistance());
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsElevationCases')]
    public function testTransformSkipsElevation(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

        $actual = $transformer->transform($properties);

        self::assertNull($actual->getElevation());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsElevationCases(): iterable
    {
        yield 'geometryAbsent' => [[]];
        yield 'geometryWrongType' => [[ForecastTransformerInterface::KEY_GEOMETRY => 'not-an-array']];
        yield 'coordinatesAbsent' => [[ForecastTransformerInterface::KEY_GEOMETRY => ['test-geometry-filler']]];
        yield 'coordinatesWrongType' => [[ForecastTransformerInterface::KEY_GEOMETRY => [ForecastTransformerInterface::KEY_COORDINATES => 'not-an-array']]];
        yield 'elevationMissing' => [[ForecastTransformerInterface::KEY_GEOMETRY => [ForecastTransformerInterface::KEY_COORDINATES => ['-0.1', '51.5']]]];
        yield 'elevationNotNumeric' => [[ForecastTransformerInterface::KEY_GEOMETRY => [ForecastTransformerInterface::KEY_COORDINATES => ['-0.1', '51.5', 'not-a-number']]]];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsLocationLicenceCases')]
    public function testTransformSkipsLocationLicence(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

        $actual = $transformer->transform($properties);

        self::assertNull($actual->getLocationLicence());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsLocationLicenceCases(): iterable
    {
        yield 'locationAbsent' => [[]];
        yield 'locationWrongType' => [[ForecastTransformerInterface::KEY_LOCATION => 'not-an-array']];
        yield 'licenceAbsent' => [[ForecastTransformerInterface::KEY_LOCATION => ['test-location-filler']]];
        yield 'licenceWrongType' => [[ForecastTransformerInterface::KEY_LOCATION => [ForecastTransformerInterface::KEY_LICENCE => 42]]];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsLocationNameCases')]
    public function testTransformSkipsLocationName(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

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

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

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
    #[DataProvider('provideTransformSkipsParametersCases')]
    public function testTransformSkipsParameters(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);
        $parameterMetadataTransformer = self::createMock(ParameterMetadataTransformerInterface::class);
        $parameterMetadataTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer, $parameterMetadataTransformer);

        $actual = $transformer->transform($properties);

        self::assertSame([], $actual->getParameters());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsParametersCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'wrongType' => [[ForecastTransformerInterface::KEY_PARAMETERS => 'not-an-array']];
        yield 'groupWrongType' => [[ForecastTransformerInterface::KEY_PARAMETERS => ['not-an-array']]];
        yield 'entryWrongType' => [[ForecastTransformerInterface::KEY_PARAMETERS => [['test-parameter' => 'not-an-array']]]];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsRequestPointDistanceCases')]
    public function testTransformSkipsRequestPointDistance(array $properties): void
    {
        $timeStepsTransformer = self::createStub(ForecastTimeStepsTransformerInterface::class);

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

        $actual = $transformer->transform($properties);

        self::assertNull($actual->getRequestPointDistance());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsRequestPointDistanceCases(): iterable
    {
        yield 'absent' => [[]];
        yield 'wrongType' => [[ForecastTransformerInterface::KEY_REQUEST_POINT_DISTANCE => 'not-a-number']];
    }

    /**
     * @param array<string, mixed> $properties
     */
    #[DataProvider('provideTransformSkipsTimeStepsCases')]
    public function testTransformSkipsTimeSteps(array $properties): void
    {
        $timeStepsTransformer = self::createMock(ForecastTimeStepsTransformerInterface::class);
        $timeStepsTransformer->expects(self::never())->method('transform');

        $transformer = new ForecastTransformer($timeStepsTransformer, self::createStub(ParameterMetadataTransformerInterface::class));

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
