<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\Run;
use ChristianBrown\MetOffice\Coverage\Model\RunDetailInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunDetailsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(Run::class)]
#[CoversClass(RunTransformer::class)]
final class RunTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $completeRunsData = [['test-run-detail-1']];
        $data = [
            RunTransformerInterface::KEY_MODEL_ID => 'mo-global',
            RunTransformerInterface::KEY_COMPLETE_RUNS => $completeRunsData,
        ];

        $runDetail = self::createStub(RunDetailInterface::class);
        $completeRuns = [$runDetail];

        $runDetailsTransformer = self::createMock(RunDetailsTransformerInterface::class);
        $runDetailsTransformer->expects(self::once())
            ->method('transform')
            ->with($completeRunsData)
            ->willReturn($completeRuns);

        $transformer = new RunTransformer($runDetailsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('mo-global', $actual->getModelId());
        self::assertSame($completeRuns, $actual->getCompleteRuns());
    }

    public function testTransformMinimal(): void
    {
        $data = [
            RunTransformerInterface::KEY_MODEL_ID => 'mo-global',
        ];

        $runDetailsTransformer = self::createMock(RunDetailsTransformerInterface::class);
        $runDetailsTransformer->expects(self::never())->method('transform');

        $transformer = new RunTransformer($runDetailsTransformer);

        $actual = $transformer->transform($data);

        self::assertSame('mo-global', $actual->getModelId());
        self::assertSame([], $actual->getCompleteRuns());
    }

    public function testTransformSkipsWrongTypedCompleteRuns(): void
    {
        $data = [
            RunTransformerInterface::KEY_MODEL_ID => 'mo-global',
            RunTransformerInterface::KEY_COMPLETE_RUNS => 'not-an-array',
        ];

        $runDetailsTransformer = self::createMock(RunDetailsTransformerInterface::class);
        $runDetailsTransformer->expects(self::never())->method('transform');

        $transformer = new RunTransformer($runDetailsTransformer);

        self::assertSame([], $transformer->transform($data)->getCompleteRuns());
    }

    /**
     * @param mixed[] $data
     */
    #[TestWith([[], RunTransformerInterface::KEY_MODEL_ID])]
    #[TestWith([[RunTransformerInterface::KEY_MODEL_ID => 42], RunTransformerInterface::KEY_MODEL_ID])]
    public function testTransformUnexpectedData(array $data, string $field): void
    {
        $runDetailsTransformer = self::createStub(RunDetailsTransformerInterface::class);

        $transformer = new RunTransformer($runDetailsTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunTransformerInterface::UNEXPECTED_STRING_SPRINTF, $field));
        $transformer->transform($data);
    }
}
