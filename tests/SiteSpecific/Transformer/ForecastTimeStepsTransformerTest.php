<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecific\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecific\Model\ForecastTimeStepInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformer;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepsTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecific\Transformer\ForecastTimeStepTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ForecastTimeStepsTransformer::class)]
final class ForecastTimeStepsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-time-step-1'], ['test-time-step-2']];

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep2 = self::createStub(ForecastTimeStepInterface::class);
        $timeSteps = [$timeStep1, $timeStep2];

        $timeStepTransformer = self::createStub(ForecastTimeStepTransformerInterface::class);
        $timeStepTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-time-step-1'], $timeStep1],
                    [['test-time-step-2'], $timeStep2],
                ]
            );

        $transformer = new ForecastTimeStepsTransformer($timeStepTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($timeSteps, $actual);
    }

    public function testTransformEmpty(): void
    {
        $timeStepTransformer = self::createStub(ForecastTimeStepTransformerInterface::class);

        $transformer = new ForecastTimeStepsTransformer($timeStepTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);

        $timeStepTransformer = self::createMock(ForecastTimeStepTransformerInterface::class);
        $timeStepTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-time-step-1'])
            ->willReturn($timeStep1);

        $transformer = new ForecastTimeStepsTransformer($timeStepTransformer);

        self::assertSame([$timeStep1], $transformer->transform([['test-time-step-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $timeStepTransformer = self::createStub(ForecastTimeStepTransformerInterface::class);

        $transformer = new ForecastTimeStepsTransformer($timeStepTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ForecastTimeStepsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ForecastTimeStepsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-time-step-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-time-step-1-array'], 'test-time-step-2-not-array', ['test-time-step-3-array'], 'test-time-step-4-not-array'];

        $timeStep1 = self::createStub(ForecastTimeStepInterface::class);
        $timeStep3 = self::createStub(ForecastTimeStepInterface::class);

        $timeStepTransformer = self::createStub(ForecastTimeStepTransformerInterface::class);
        $timeStepTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-time-step-1-array'], $timeStep1],
                    [['test-time-step-3-array'], $timeStep3],
                ]
            );

        $transformer = new ForecastTimeStepsTransformer($timeStepTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ForecastTimeStepsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ForecastTimeStepsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
