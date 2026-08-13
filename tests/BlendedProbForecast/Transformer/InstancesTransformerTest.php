<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\InstanceInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstancesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(InstancesTransformer::class)]
final class InstancesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['instance-1'], ['instance-2']];

        $instance1 = self::createStub(InstanceInterface::class);
        $instance2 = self::createStub(InstanceInterface::class);

        $instanceTransformer = self::createStub(InstanceTransformerInterface::class);
        $instanceTransformer->method('transform')
            ->willReturnMap(
                [
                    [['instance-1'], $instance1],
                    [['instance-2'], $instance2],
                ]
            );

        $transformer = new InstancesTransformer($instanceTransformer);

        self::assertSame([$instance1, $instance2], $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $instanceTransformer = self::createStub(InstanceTransformerInterface::class);

        $transformer = new InstancesTransformer($instanceTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformThrowsOnNonArray(): void
    {
        $instanceTransformer = self::createStub(InstanceTransformerInterface::class);

        $transformer = new InstancesTransformer($instanceTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstancesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, InstancesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['not-an-array']);
    }
}
