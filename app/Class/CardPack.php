<?php

namespace App\Class;

class CardPack {
    private array $cards;

    public function __construct() {
        $this->cards = [];
        for($color = 1; $color <= 4; $color++) {
            for($value = 1; $value <= 13; $value++) {
                $this->cards[] = new Card($color, $value);
            }
        }

        shuffle($this->cards);
    }

    public function drawCard(): Card|null {
        if(count($this->cards) === 0) {
            return null;
        }
        return array_pop($this->cards);
    }
}