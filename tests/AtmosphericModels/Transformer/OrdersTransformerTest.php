<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrdersTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrdersTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrdersTransformer::class)]
final class OrdersTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-order-1'], ['test-order-2']];

        $order1 = self::createStub(OrderInterface::class);
        $order2 = self::createStub(OrderInterface::class);
        $orders = [$order1, $order2];

        $orderTransformer = self::createStub(OrderTransformerInterface::class);
        $orderTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-order-1'], $order1],
                    [['test-order-2'], $order2],
                ]
            );

        $transformer = new OrdersTransformer($orderTransformer);

        self::assertSame($orders, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $orderTransformer = self::createStub(OrderTransformerInterface::class);

        $transformer = new OrdersTransformer($orderTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $order1 = self::createStub(OrderInterface::class);

        $orderTransformer = self::createMock(OrderTransformerInterface::class);
        $orderTransformer->method('transform')
            ->with(['test-order-1'])
            ->willReturn($order1);

        $transformer = new OrdersTransformer($orderTransformer);

        self::assertSame([$order1], $transformer->transform([['test-order-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $orderTransformer = self::createStub(OrderTransformerInterface::class);

        $transformer = new OrdersTransformer($orderTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrdersTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-order-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-order-1-array'], 'test-order-2-not-array', ['test-order-3-array'], 'test-order-4-not-array'];

        $order1 = self::createStub(OrderInterface::class);
        $order3 = self::createStub(OrderInterface::class);

        $orderTransformer = self::createStub(OrderTransformerInterface::class);
        $orderTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-order-1-array'], $order1],
                    [['test-order-3-array'], $order3],
                ]
            );

        $transformer = new OrdersTransformer($orderTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrdersTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrdersTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
