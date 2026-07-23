<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\SiteSpecificBlended\Transformer;

use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\Coverage;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\DomainInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Model\NdArrayInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageTransformer;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\CoverageTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\DomainTransformerInterface;
use ChristianBrown\MetOffice\SiteSpecificBlended\Transformer\RangesTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
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
        $rangesData = ['ranges-data'];

        $domain = self::createStub(DomainInterface::class);
        $ranges = ['airTemperature' => self::createStub(NdArrayInterface::class)];

        $data = [
            CoverageTransformerInterface::KEY_DOMAIN => $domainData,
            CoverageTransformerInterface::KEY_RANGES => $rangesData,
        ];

        $domainTransformer = self::createMock(DomainTransformerInterface::class);
        $domainTransformer->expects(self::once())
            ->method('transform')
            ->with($domainData)
            ->willReturn($domain);

        $rangesTransformer = self::createMock(RangesTransformerInterface::class);
        $rangesTransformer->expects(self::once())
            ->method('transform')
            ->with($rangesData)
            ->willReturn($ranges);

        $coverage = (new CoverageTransformer($domainTransformer, $rangesTransformer))->transform($data);

        self::assertSame($domain, $coverage->getDomain());
        self::assertSame($ranges, $coverage->getRanges());
    }

    public function testTransformMinimal(): void
    {
        $domainData = ['domain-data'];
        $domain = self::createStub(DomainInterface::class);

        $data = [CoverageTransformerInterface::KEY_DOMAIN => $domainData];

        $domainTransformer = self::createMock(DomainTransformerInterface::class);
        $domainTransformer->expects(self::once())
            ->method('transform')
            ->with($domainData)
            ->willReturn($domain);

        $rangesTransformer = self::createMock(RangesTransformerInterface::class);
        $rangesTransformer->expects(self::never())->method('transform');

        $coverage = (new CoverageTransformer($domainTransformer, $rangesTransformer))->transform($data);

        self::assertSame($domain, $coverage->getDomain());
        self::assertSame([], $coverage->getRanges());
    }

    public function testTransformSkipsRanges(): void
    {
        $domainData = ['domain-data'];
        $domain = self::createStub(DomainInterface::class);

        $data = [
            CoverageTransformerInterface::KEY_DOMAIN => $domainData,
            CoverageTransformerInterface::KEY_RANGES => 'not-an-array',
        ];

        $domainTransformer = self::createStub(DomainTransformerInterface::class);
        $domainTransformer->method('transform')->willReturn($domain);

        $rangesTransformer = self::createMock(RangesTransformerInterface::class);
        $rangesTransformer->expects(self::never())->method('transform');

        $coverage = (new CoverageTransformer($domainTransformer, $rangesTransformer))->transform($data);

        self::assertSame([], $coverage->getRanges());
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

        $rangesTransformer = self::createStub(RangesTransformerInterface::class);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(CoverageTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, CoverageTransformerInterface::KEY_DOMAIN));

        (new CoverageTransformer($domainTransformer, $rangesTransformer))->transform($data);
    }
}
