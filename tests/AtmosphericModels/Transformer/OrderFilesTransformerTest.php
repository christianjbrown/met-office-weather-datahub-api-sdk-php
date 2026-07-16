<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\AtmosphericModels\Transformer;

use ChristianBrown\MetOffice\AtmosphericModels\Model\OrderFileInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFilesTransformer;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFilesTransformerInterface;
use ChristianBrown\MetOffice\AtmosphericModels\Transformer\OrderFileTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderFilesTransformer::class)]
final class OrderFilesTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-file-1'], ['test-file-2']];

        $file1 = self::createStub(OrderFileInterface::class);
        $file2 = self::createStub(OrderFileInterface::class);
        $files = [$file1, $file2];

        $orderFileTransformer = self::createStub(OrderFileTransformerInterface::class);
        $orderFileTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-file-1'], $file1],
                    [['test-file-2'], $file2],
                ]
            );

        $transformer = new OrderFilesTransformer($orderFileTransformer);

        self::assertSame($files, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $orderFileTransformer = self::createStub(OrderFileTransformerInterface::class);

        $transformer = new OrderFilesTransformer($orderFileTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $file1 = self::createStub(OrderFileInterface::class);

        $orderFileTransformer = self::createMock(OrderFileTransformerInterface::class);
        $orderFileTransformer->method('transform')
            ->with(['test-file-1'])
            ->willReturn($file1);

        $transformer = new OrderFilesTransformer($orderFileTransformer);

        self::assertSame([$file1], $transformer->transform([['test-file-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $orderFileTransformer = self::createStub(OrderFileTransformerInterface::class);

        $transformer = new OrderFilesTransformer($orderFileTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrderFilesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrderFilesTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-file-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-file-1-array'], 'test-file-2-not-array', ['test-file-3-array'], 'test-file-4-not-array'];

        $file1 = self::createStub(OrderFileInterface::class);
        $file3 = self::createStub(OrderFileInterface::class);

        $orderFileTransformer = self::createStub(OrderFileTransformerInterface::class);
        $orderFileTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-file-1-array'], $file1],
                    [['test-file-3-array'], $file3],
                ]
            );

        $transformer = new OrderFilesTransformer($orderFileTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrderFilesTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrderFilesTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
