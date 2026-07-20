<?php

declare(strict_types=1);

namespace ChristianBrown\MetOffice\Tests\Coverage\Transformer;

use ChristianBrown\MetOffice\Coverage\Model\RunInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformer;
use ChristianBrown\MetOffice\Coverage\Transformer\RunsTransformerInterface;
use ChristianBrown\MetOffice\Coverage\Transformer\RunTransformerInterface;
use ChristianBrown\MetOffice\Exception\UnexpectedResponseException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function sprintf;

#[CoversClass(RunsTransformer::class)]
final class RunsTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [['test-run-1'], ['test-run-2']];

        $run1 = self::createStub(RunInterface::class);
        $run2 = self::createStub(RunInterface::class);
        $runs = [$run1, $run2];

        $runTransformer = self::createStub(RunTransformerInterface::class);
        $runTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-run-1'], $run1],
                    [['test-run-2'], $run2],
                ]
            );

        $transformer = new RunsTransformer($runTransformer);

        self::assertSame($runs, $transformer->transform($data));
    }

    public function testTransformEmpty(): void
    {
        $runTransformer = self::createStub(RunTransformerInterface::class);

        $transformer = new RunsTransformer($runTransformer);

        self::assertSame([], $transformer->transform([]));
    }

    public function testTransformSingle(): void
    {
        $run1 = self::createStub(RunInterface::class);

        $runTransformer = self::createMock(RunTransformerInterface::class);
        $runTransformer->expects(self::once())
            ->method('transform')
            ->with(['test-run-1'])
            ->willReturn($run1);

        $transformer = new RunsTransformer($runTransformer);

        self::assertSame([$run1], $transformer->transform([['test-run-1']]));
    }

    public function testTransformThrowsOnFirstNonArray(): void
    {
        $runTransformer = self::createStub(RunTransformerInterface::class);

        $transformer = new RunsTransformer($runTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RunsTransformerInterface::ARRAY_NAME));

        $transformer->transform(['test-run-1-not-array']);
    }

    public function testTransformUnexpected(): void
    {
        $data = [['test-run-1-array'], 'test-run-2-not-array', ['test-run-3-array'], 'test-run-4-not-array'];

        $run1 = self::createStub(RunInterface::class);
        $run3 = self::createStub(RunInterface::class);

        $runTransformer = self::createStub(RunTransformerInterface::class);
        $runTransformer->method('transform')
            ->willReturnMap(
                [
                    [['test-run-1-array'], $run1],
                    [['test-run-3-array'], $run3],
                ]
            );

        $transformer = new RunsTransformer($runTransformer);

        $this->expectException(UnexpectedResponseException::class);
        $this->expectExceptionMessage(sprintf(RunsTransformerInterface::UNEXPECTED_ARRAY_SPRINTF, RunsTransformerInterface::ARRAY_NAME));

        $transformer->transform($data);
    }
}
