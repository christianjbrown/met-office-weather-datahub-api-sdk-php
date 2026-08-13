<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\Coverage;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\DomainInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\NdArrayInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\ParameterInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\CoverageTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\ParametersTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\RangesTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Coverage::class)]
#[CoversClass(CoverageTransformer::class)]
final class CoverageTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $domainData = ['domain-data'];
        $parametersData = ['parameters-data'];
        $rangesData = ['ranges-data'];

        $domain = self::createStub(DomainInterface::class);
        $parameters = ['airTemperature1p5m' => self::createStub(ParameterInterface::class)];
        $ranges = ['airTemperature1p5m' => self::createStub(NdArrayInterface::class)];

        $data = [
            CoverageTransformerInterface::KEY_DOMAIN => $domainData,
            CoverageTransformerInterface::KEY_ID => 'airTemperature1p5m',
            CoverageTransformerInterface::KEY_PARAMETERS => $parametersData,
            CoverageTransformerInterface::KEY_RANGES => $rangesData,
        ];

        $domainTransformer = self::createMock(DomainTransformerInterface::class);
        $domainTransformer->expects(self::once())
            ->method('transform')
            ->with($domainData)
            ->willReturn($domain);

        $parametersTransformer = self::createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::once())
            ->method('transform')
            ->with($parametersData)
            ->willReturn($parameters);

        $rangesTransformer = self::createMock(RangesTransformerInterface::class);
        $rangesTransformer->expects(self::once())
            ->method('transform')
            ->with($rangesData)
            ->willReturn($ranges);

        $coverage = (new CoverageTransformer($domainTransformer, $parametersTransformer, $rangesTransformer))->transform($data);

        self::assertSame($domain, $coverage->getDomain());
        self::assertSame('airTemperature1p5m', $coverage->getId());
        self::assertSame($parameters, $coverage->getParameters());
        self::assertSame($ranges, $coverage->getRanges());
    }

    public function testTransformMinimal(): void
    {
        $coverage = $this->transformExpectingNoDelegation([CoverageTransformerInterface::KEY_DOMAIN => ['domain-data']]);

        self::assertNull($coverage->getId());
        self::assertSame([], $coverage->getParameters());
        self::assertSame([], $coverage->getRanges());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $data[CoverageTransformerInterface::KEY_DOMAIN] = ['domain-data'];

        $coverage = $this->transformExpectingNoDelegation($data);

        self::assertNull($coverage->getId());
        self::assertSame([], $coverage->getParameters());
        self::assertSame([], $coverage->getRanges());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'wrongTypes' => [
            [
                CoverageTransformerInterface::KEY_ID => 42,
                CoverageTransformerInterface::KEY_PARAMETERS => 'not-an-array',
                CoverageTransformerInterface::KEY_RANGES => 'not-an-array',
            ],
        ];
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[]])]
    #[TestWith([[CoverageTransformerInterface::KEY_DOMAIN => 'not-an-array']])]
    public function testTransformUnexpected(array $data): void
    {
        $domainTransformer = self::createMock(DomainTransformerInterface::class);
        $domainTransformer->expects(self::never())->method('transform');

        $parametersTransformer = self::createStub(ParametersTransformerInterface::class);
        $rangesTransformer = self::createStub(RangesTransformerInterface::class);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CoverageTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CoverageTransformerInterface::KEY_DOMAIN));

        (new CoverageTransformer($domainTransformer, $parametersTransformer, $rangesTransformer))->transform($data);
    }

    /**
     * @param array<string, mixed> $data
     */
    private function transformExpectingNoDelegation(array $data): Coverage
    {
        $domain = self::createStub(DomainInterface::class);

        $domainTransformer = self::createStub(DomainTransformerInterface::class);
        $domainTransformer->method('transform')->willReturn($domain);

        $parametersTransformer = $this->createMock(ParametersTransformerInterface::class);
        $parametersTransformer->expects(self::never())->method('transform');

        $rangesTransformer = $this->createMock(RangesTransformerInterface::class);
        $rangesTransformer->expects(self::never())->method('transform');

        $coverage = (new CoverageTransformer($domainTransformer, $parametersTransformer, $rangesTransformer))->transform($data);
        self::assertInstanceOf(Coverage::class, $coverage);

        return $coverage;
    }
}
