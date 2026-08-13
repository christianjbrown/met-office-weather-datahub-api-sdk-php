<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\BlendedProbForecast\Transformer;

use ChristianBrown\MetOffice\BlendedProbForecast\Model\AxisInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Model\Domain;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\AxesTransformerInterface;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformer;
use ChristianBrown\MetOffice\BlendedProbForecast\Transformer\DomainTransformerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Domain::class)]
#[CoversClass(DomainTransformer::class)]
final class DomainTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $axesData = ['t' => ['values' => ['2024-03-08T00:00:00Z']]];
        $axes = ['t' => self::createStub(AxisInterface::class)];

        $data = [DomainTransformerInterface::KEY_AXES => $axesData];

        $axesTransformer = self::createMock(AxesTransformerInterface::class);
        $axesTransformer->expects(self::once())
            ->method('transform')
            ->with($axesData)
            ->willReturn($axes);

        $domain = (new DomainTransformer($axesTransformer))->transform($data);

        self::assertSame($axes, $domain->getAxes());
    }

    /**
     * @param array<string, mixed> $data
     */
    #[DataProvider('provideTransformSkipsCases')]
    public function testTransformSkips(array $data): void
    {
        $axesTransformer = self::createMock(AxesTransformerInterface::class);
        $axesTransformer->expects(self::never())->method('transform');

        $domain = (new DomainTransformer($axesTransformer))->transform($data);

        self::assertSame([], $domain->getAxes());
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function provideTransformSkipsCases(): iterable
    {
        yield 'axesAbsent' => [[]];
        yield 'axesWrongType' => [[DomainTransformerInterface::KEY_AXES => 'not-an-array']];
    }
}
