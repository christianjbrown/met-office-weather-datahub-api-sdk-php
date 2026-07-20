<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\OrderFileDetails;
use ChristianBrown\MetOffice\Coverage\Model\OrderFileInterface;
use ChristianBrown\MetOffice\Coverage\Model\ParameterDetailInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileDetailsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\OrderFileTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\ParameterDetailsTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(OrderFileDetails::class)]
#[CoversClass(OrderFileDetailsTransformer::class)]
final class OrderFileDetailsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $fileData = ['test-file'];
        $parameterDetailsData = [['test-parameter-detail']];
        $data = [
            OrderFileDetailsTransformerInterface::KEY_FILE => $fileData,
            OrderFileDetailsTransformerInterface::KEY_PARAMETER_DETAILS => $parameterDetailsData,
        ];

        $file = self::createStub(OrderFileInterface::class);
        $parameterDetail = self::createStub(ParameterDetailInterface::class);
        $parameterDetails = [$parameterDetail];

        $orderFileTransformer = self::createMock(OrderFileTransformerInterface::class);
        $orderFileTransformer->expects(self::once())
            ->method('transform')
            ->with($fileData)
            ->willReturn($file);

        $parameterDetailsTransformer = self::createMock(ParameterDetailsTransformerInterface::class);
        $parameterDetailsTransformer->expects(self::once())
            ->method('transform')
            ->with($parameterDetailsData)
            ->willReturn($parameterDetails);

        $transformer = new OrderFileDetailsTransformer($orderFileTransformer, $parameterDetailsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($file, $actual->getFile());
        self::assertSame($parameterDetails, $actual->getParameterDetails());
    }

    public function testTransformMinimal(): void
    {
        $fileData = ['test-file'];
        $data = [
            OrderFileDetailsTransformerInterface::KEY_FILE => $fileData,
        ];

        $file = self::createStub(OrderFileInterface::class);

        $orderFileTransformer = self::createMock(OrderFileTransformerInterface::class);
        $orderFileTransformer->expects(self::once())
            ->method('transform')
            ->with($fileData)
            ->willReturn($file);

        $parameterDetailsTransformer = self::createMock(ParameterDetailsTransformerInterface::class);
        $parameterDetailsTransformer->expects(self::never())->method('transform');

        $transformer = new OrderFileDetailsTransformer($orderFileTransformer, $parameterDetailsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame($file, $actual->getFile());
        self::assertSame([], $actual->getParameterDetails());
    }

    public function testTransformSkipsWrongTypedParameterDetails(): void
    {
        $fileData = ['test-file'];
        $data = [
            OrderFileDetailsTransformerInterface::KEY_FILE => $fileData,
            OrderFileDetailsTransformerInterface::KEY_PARAMETER_DETAILS => 'not-an-array',
        ];

        $file = self::createStub(OrderFileInterface::class);

        $orderFileTransformer = self::createMock(OrderFileTransformerInterface::class);
        $orderFileTransformer->expects(self::once())
            ->method('transform')
            ->with($fileData)
            ->willReturn($file);

        $parameterDetailsTransformer = self::createMock(ParameterDetailsTransformerInterface::class);
        $parameterDetailsTransformer->expects(self::never())->method('transform');

        $transformer = new OrderFileDetailsTransformer($orderFileTransformer, $parameterDetailsTransformer);

        self::assertSame([], $transformer->transform($data)->getParameterDetails());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[OrderFileDetailsTransformerInterface::KEY_FILE => 'not-an-array']])]
    public function testTransformUnexpectedData(array $data): void
    {
        $orderFileTransformer = self::createStub(OrderFileTransformerInterface::class);
        $parameterDetailsTransformer = self::createStub(ParameterDetailsTransformerInterface::class);

        $transformer = new OrderFileDetailsTransformer($orderFileTransformer, $parameterDetailsTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(OrderFileDetailsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, OrderFileDetailsTransformerInterface::KEY_FILE));
        $transformer->transform($data);
    }
}
