<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\MapImages\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\MapImages\Model\ParameterDetailInterface;
use ChristianBrown\MetOffice\MapImages\Transformer\ParameterDetailsTransformer;
use ChristianBrown\MetOffice\MapImages\Transformer\ParameterDetailsTransformerInterface;
use ChristianBrown\MetOffice\MapImages\Transformer\ParameterDetailTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ParameterDetailsTransformer::class)]
final class ParameterDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-parameter-1'], ['test-parameter-2']];

        $parameterDetail1 = self::createStub(ParameterDetailInterface::class);
        $parameterDetail2 = self::createStub(ParameterDetailInterface::class);
        $parameterDetails = [$parameterDetail1, $parameterDetail2];

        $parameterDetailTransformer = self::createStub(ParameterDetailTransformerInterface::class);
        $parameterDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-parameter-1'], $parameterDetail1],
                    [['test-parameter-2'], $parameterDetail2],
                ]
            );

        $transformer = new ParameterDetailsTransformer($parameterDetailTransformer);

        self::assertSame($parameterDetails, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $parameterDetailTransformer = self::createStub(ParameterDetailTransformerInterface::class);

        $transformer = new ParameterDetailsTransformer($parameterDetailTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $parameterDetail1 = self::createStub(ParameterDetailInterface::class);

        $parameterDetailTransformer = self::createMock(ParameterDetailTransformerInterface::class);
        $parameterDetailTransformer->method('transform')
            ->with(['test-parameter-1'])
            ->willReturn($parameterDetail1);

        $transformer = new ParameterDetailsTransformer($parameterDetailTransformer);

        self::assertSame([$parameterDetail1], $transformer->transform([['test-parameter-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $parameterDetailTransformer = self::createStub(ParameterDetailTransformerInterface::class);

        $transformer = new ParameterDetailsTransformer($parameterDetailTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ParameterDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ParameterDetailsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-parameter-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-parameter-1-array'], 'test-parameter-2-not-array', ['test-parameter-3-array'], 'test-parameter-4-not-array'];

        $parameterDetail1 = self::createStub(ParameterDetailInterface::class);
        $parameterDetail3 = self::createStub(ParameterDetailInterface::class);

        $parameterDetailTransformer = self::createStub(ParameterDetailTransformerInterface::class);
        $parameterDetailTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-parameter-1-array'], $parameterDetail1],
                    [['test-parameter-3-array'], $parameterDetail3],
                ]
            );

        $transformer = new ParameterDetailsTransformer($parameterDetailTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ParameterDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ParameterDetailsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
