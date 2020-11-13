<?php

namespace CodingGame\LegendsOfCodeMagic\Action;

use CodingGame\LegendsOfCodeMagic\Card\CardCollection;
use CodingGame\LegendsOfCodeMagic\Card\CardEvaluator;
use CodingGame\LegendsOfCodeMagic\Debug;

class DraftAction
{
    /**
     * @var CardCollection
     */
    private $board;
    /**
     * @var CardCollection
     */
    private $deck;

    /**
     * @var CardEvaluator
     */
    private $evaluator;

    /**
     * DraftAction constructor.
     */
    public function __construct(CardCollection $board, CardCollection $deck)
    {
        $this->board = $board;
        $this->deck = $deck;
        $this->evaluator = new CardEvaluator();
    }

    public function get():array
    {
        $draftCards = [];
        foreach($this->board->listByLocation(0) as $key => $card){
            $draftCards[] = [
                'card' => $card,
                'score' => $this->evaluator->getScore($card),
                'pick' => $key,

            ];
        }

        $topScore = 0;
        $pick = null;
        foreach($draftCards as $card){
            if($card['score'] > $topScore){
                $pick = $card['pick'];
                $topScore = $card['score'];
            }
        }

        return ["PICK " . $pick];
    }
}