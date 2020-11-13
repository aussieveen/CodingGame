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
//            [
//                [
//                    $cardFactory->create(36, -3),
//                    $cardFactory->create(111, -2),
//                    $cardFactory->create(60, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(111, -3),
//                    $cardFactory->create(86, -2),
//                    $cardFactory->create(78, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(107, -3),
//                    $cardFactory->create(78, -2),
//                    $cardFactory->create(57, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(111, -3),
//                    $cardFactory->create(90, -2),
//                    $cardFactory->create(86, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(71, -3),
//                    $cardFactory->create(25, -2),
//                    $cardFactory->create(102, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(2, -3),
//                    $cardFactory->create(1, -2),
//                    $cardFactory->create(16, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(112, -3),
//                    $cardFactory->create(32, -2),
//                    $cardFactory->create(11, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(60, -3),
//                    $cardFactory->create(4, -2),
//                    $cardFactory->create(109, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(58, -3),
//                    $cardFactory->create(36, -2),
//                    $cardFactory->create(1, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(59, -3),
//                    $cardFactory->create(101, -2),
//                    $cardFactory->create(37, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(110, -3),
//                    $cardFactory->create(113, -2),
//                    $cardFactory->create(58, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(88, -3),
//                    $cardFactory->create(99, -2),
//                    $cardFactory->create(35, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(87, -3),
//                    $cardFactory->create(16, -2),
//                    $cardFactory->create(12, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(108, -3),
//                    $cardFactory->create(94, -2),
//                    $cardFactory->create(85, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(56, -3),
//                    $cardFactory->create(20, -2),
//                    $cardFactory->create(13, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(99, -3),
//                    $cardFactory->create(70, -2),
//                    $cardFactory->create(14, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(71, -3),
//                    $cardFactory->create(101, -2),
//                    $cardFactory->create(14, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(86, -3),
//                    $cardFactory->create(113, -2),
//                    $cardFactory->create(85, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(99, -3),
//                    $cardFactory->create(97, -2),
//                    $cardFactory->create(18, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(113, -3),
//                    $cardFactory->create(18, -2),
//                    $cardFactory->create(89, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(94, -3),
//                    $cardFactory->create(104, -2),
//                    $cardFactory->create(110, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(11, -3),
//                    $cardFactory->create(37, -2),
//                    $cardFactory->create(21, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(60, -3),
//                    $cardFactory->create(112, -2),
//                    $cardFactory->create(32, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(27, -3),
//                    $cardFactory->create(2, -2),
//                    $cardFactory->create(5, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(20, -3),
//                    $cardFactory->create(35, -2),
//                    $cardFactory->create(109, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(97, -3),
//                    $cardFactory->create(98, -2),
//                    $cardFactory->create(13, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(83, -3),
//                    $cardFactory->create(103, -2), //4M 3/6 with G
//                    $cardFactory->create(105, -1) //5m 4/6 with G
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(15, -3), //4M 4/5
//                    $cardFactory->create(109, -2),//5M 5/6
//                    $cardFactory->create(100, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(21, -3),
//                    $cardFactory->create(91, -2),
//                    $cardFactory->create(20, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(27, -3),
//                    $cardFactory->create(86, -2),
//                    $cardFactory->create(15, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(87, -3),
//                    $cardFactory->create(112, -2),
//                    $cardFactory->create(35, -1)
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(4, -3),
//                    $cardFactory->create(13, -2),
//                    $cardFactory->create(59, -1)
//                ],
//                2
//            ],
//            [
//                [
//                    $cardFactory->create(87, -3),
//                    $cardFactory->create(3, -2), //1M 2/2
//                    $cardFactory->create(61, -1) // 9M 10/10
//                ],
//                1
//            ],
//            [
//                [
//                    $cardFactory->create(24, -3), //1M 1/1 d1-opponent
//                    $cardFactory->create(60, -2), //7M 4/8
//                    $cardFactory->create(33, -1)
//                ],
//                0
//            ],
//            [
//                [
//                    $cardFactory->create(22, -3),
//                    $cardFactory->create(37, -2),
//                    $cardFactory->create(107, -1)
//                ],
//                1
//            ],
        ];
    }
}
