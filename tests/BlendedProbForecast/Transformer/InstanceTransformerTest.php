<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\ExtentInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\Instance;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\LinkInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ExtentTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\InstanceTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\LinksTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Instance::class)]
#[CoversClass(InstanceTransformer::class)]
final class InstanceTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $linksData = [['link-1']];
        $extentData = ['extent-data'];
        $parametersData = ['airTemperature1p5m' => ['type' => 'Parameter']];
        $links = [self::createStub(LinkInterface::class)];
        $extent = self::createStub(ExtentInterface::class);
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];

        $data = [
            InstanceTransformerInterface::KEY_ID => 'blended',
            InstanceTransformerInterface::KEY_CRS => ['EPSG:4326', 42],
            InstanceTransformerInterface::KEY_DATA_QUERIES => ['locations' => [], 'position' => []],
            InstanceTransformerInterface::KEY_EXTENT => $extentData,
            InstanceTransformerInterface::KEY_LINKS => $linksData,
            InstanceTransformerInterface::KEY_OUTPUT_FORMATS => ['CoverageJSON', 42],
            InstanceTransformerInterface::KEY_PARAMETER_NAMES => $parametersData,
        ];

        $linksTransformer = self::createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::once())
            ->method('transform')
            ->with($linksData)
            ->willReturn($links);

        $extentTransformer = self::createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::once())
            ->method('transform')
            ->with($extentData)
            ->willReturn($extent);

        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::once())
            ->method('transform')
            ->with($parametersData)
            ->willReturn($parameters);

        $instance = (new InstanceTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);

        self::assertSame('blended', $instance->getId());
        self::assertSame(['EPSG:4326'], $instance->getCrs());
        self::assertSame(['locations', 'position'], $instance->getDataQueries());
        self::assertSame($extent, $instance->getExtent());
        self::assertSame($links, $instance->getLinks());
        self::assertSame(['CoverageJSON'], $instance->getOutputFormats());
        self::assertSame($parameters, $instance->getParameters());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            InstanceTransformerInterface::KEY_ID => 'blended',
        ];

        $instance = $this->transformExpectingNoDelegation($data);

        self::assertSame([], $instance->getCrs());
        self::assertSame([], $instance->getDataQueries());
        self::assertNull($instance->getExtent());
        self::assertSame([], $instance->getLinks());
        self::assertSame([], $instance->getOutputFormats());
        self::assertSame([], $instance->getParameters());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $instance = $this->transformExpectingNoDelegation($data);

        self::assertSame([], $instance->getCrs());
        self::assertSame([], $instance->getDataQueries());
        self::assertNull($instance->getExtent());
        self::assertSame([], $instance->getLinks());
        self::assertSame([], $instance->getOutputFormats());
        self::assertSame([], $instance->getParameters());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                InstanceTransformerInterface::KEY_ID => 'blended',
                InstanceTransformerInterface::KEY_CRS => 'not-an-array',
                InstanceTransformerInterface::KEY_DATA_QUERIES => 'not-an-array',
                InstanceTransformerInterface::KEY_EXTENT => 'not-an-array',
                InstanceTransformerInterface::KEY_LINKS => 'not-an-array',
                InstanceTransformerInterface::KEY_OUTPUT_FORMATS => 'not-an-array',
                InstanceTransformerInterface::KEY_PARAMETER_NAMES => 'not-an-array',
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[InstanceTransformerInterface::KEY_ID => 42]])]
    public function testTransformUnexpected(array $data): void
    {
        $linksTransformer = self::createStub(LinksTransformerInterface::class);
        $extentTransformer = self::createStub(ExtentTransformerInterface::class);
        $parametersTransformer = self::createStub(ParametersTransformerInterface::class);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(InstanceTransformerInterface::UNEXPECTED_STRING_SPRINTF, InstanceTransformerInterface::KEY_ID));

        (new InstanceTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function transformExpectingNoDelegation(array $data): Instance
    {
        $linksTransformer = $this->createMock(LinksTransformerInterface::class);
        $linksTransformer->expects(self::never())->method('transform');

        $extentTransformer = $this->createMock(ExtentTransformerInterface::class);
        $extentTransformer->expects(self::never())->method('transform');

        $parametersTransformer = $this->createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::never())->method('transform');

        $instance = (new InstanceTransformer($linksTransformer, $extentTransformer, $parametersTransformer))->transform($data);
        self::assertInstanceOf(Instance::class, $instance);

        return $instance;
    }
}
