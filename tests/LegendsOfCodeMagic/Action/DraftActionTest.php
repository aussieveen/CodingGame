<?php

namespace Tests\LegendsOfCodeMagic\Action;

use CodingGame\LegendsOfCodeMagic\Action\DraftAction;
use CodingGame\LegendsOfCodeMagic\Card\Card;
use CodingGame\LegendsOfCodeMagic\Card\CardCollection;
use CodingGame\LegendsOfCodeMagic\Card\CardFactory;
use Mockery;
use PHPUnit\Framework\TestCase;

class DraftActionTest extends TestCase
{
    /**
     * @var CardCollection|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $board;
    /**
     * @var CardCollection|Mockery\LegacyMockInterface|Mockery\MockInterface
     */
    private $deck;
    /**
     * @var DraftAction
     */
    private $unit;
    /**
     * @var CardFactory
     */
    private $cardFactory;

    public function setUp(): void
    {
        $this->board = Mockery::mock(CardCollection::class);
        $this->deck = Mockery::mock(CardCollection::class);
        $this->unit = new DraftAction($this->board, $this->deck);
        $this->cardFactory = new CardFactory();
    }

    /**
     * @dataProvider getTestsProvider
     */
    public function testGet($cards, $pick): void
    {
        $this->board->shouldReceive('listByLocation')
            ->with(0)
            ->once()
            ->andReturn($cards);

        $this->assertSame(["PICK " . $pick], $this->unit->get());
    }

    public function getTestsProvider()
    {
        $cardFactory = new CardFactory();
        return [
            [
                [
                $cardFactory->create(35, -3),
                $cardFactory->create(37, -2),
                $cardFactory->create(95, -1)
                ],
                1
            ],
            [
                [
                    $cardFactory->create(36, -3),
                    $cardFactory->create(111, -2),
                    $cardFactory->create(60, -1)
                ],
                1
            ],
            [
                [
                    $cardFactory->create(111, -3),
                    $cardFactory->create(86, -2),
                    $cardFactory->create(78, -1)
                ],
                2
            ],
            [
                [
                    $cardFactory->create(107, -3),
                    $cardFactory->create(78, -2),
                    $cardFactory->create(57, -1)
                ],
                1
            ],
            [
                [
                    $cardFactory->create(111, -3),
                    $cardFactory->create(90, -2),
                    $cardFactory->create(86, -1)
                ],
                0
            ],
            [
                [
                    $cardFactory->create(71, -3),
                    $cardFactory->create(25, -2),
                    $cardFactory->create(102, -1)
                ],
                2
            ],
        ];
    }
}
