<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\ParameterInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParametersTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParametersTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\ParameterTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(ParametersTransformer::class)]
final class ParametersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            'feels_like_temperature' => ['type' => 'Parameter'],
            'screen_temperature' => ['type' => 'Parameter2'],
        ];

        $parameter1 = self::createStub(ParameterInterface::class);
        $parameter2 = self::createStub(ParameterInterface::class);

        $parameterTransformer = self::createStub(ParameterTransformerInterface::class);
        $parameterTransformer->method('transform')
            ->willReturnMap(
                [
                    [['type' => 'Parameter', ParameterTransformerInterface::KEY_ID => 'feels_like_temperature'], $parameter1],
                    [['type' => 'Parameter2', ParameterTransformerInterface::KEY_ID => 'screen_temperature'], $parameter2],
                ]
            );

        $transformer = new ParametersTransformer($parameterTransformer);

        self::assertSame(
            [
                'feels_like_temperature' => $parameter1,
                'screen_temperature' => $parameter2,
            ],
            $transformer->transform($data)
        );
    }

    public function testTransformEmpty(): void
    {
        $parameterTransformer = self::createStub(ParameterTransformerInterface::class);

        $transformer = new ParametersTransformer($parameterTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $parameterTransformer = self::createStub(ParameterTransformerInterface::class);

        $transformer = new ParametersTransformer($parameterTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(ParametersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, ParametersTransformerInterface::ARRAY_NAME));

        $transformer->transform(['feels_like_temperature' => 'not-an-array']);
    }
}
