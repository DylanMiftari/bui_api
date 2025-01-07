<?php

namespace App\Helper;

use App\Class\Card;

class PokerHelper {

    private static function groupByValue(array $cards) {
        $res = [];
        foreach($cards as $card) {
            $res[$card->getValue()][] = $card;
        }
        return $res;
    }

    public static function checkRoyalFlush(array $cards) {
        $isStraightFlush = self::checkStraightFlush($cards);
        if(!$isStraightFlush) {
            return false;
        }
        foreach($cards as $card) {
            if(!in_array($card->getValue(), [1, 10, 11, 12, 13])) {
                return false;
            }
        }
        return true;
    }

    public static function checkStraightFlush(array $cards) {
        return self::checkFlush($cards) && self::checkStraight($cards);
    }


    public static function checkFourOfKind(array $cards) {
        $groupedCards = self::groupByValue($cards);
        foreach($groupedCards as $value => $group) {
            if(count($group) === 4) {
                return true;
            }
        }
        return false;
    }

    public static function checkFullHouse(array $cards) {
        $groupedCards = self::groupByValue($cards);
        $hasThree = false;
        $hasPair = false;

        foreach($groupedCards as $value => $group) {
            if(count($group) === 3) {
                $hasThree = true;
            } else if(count($group) === 2) {
                $hasPair = true;
            }
        }
        return $hasThree && $hasPair;
    }

    public static function checkFlush(array $cards) {
        $firstColor = $cards[0]->getColor();
        foreach($cards as $card) {
            if($card->getColor() !== $firstColor) {
                return false;
            }
        }
        return true;
    }

    public static function checkStraight(array $cards) {
        usort($cards, function(Card $cardA, Card $cardB) {
            return $cardA->getValue() <=> $cardB->getValue();
        });

        $firstValue = $cards[0]->getValue();
        for($i = 1; $i < count($cards); $i++) {
            $currentValue = $cards[$i]->getValue();
            $waitedCurrentValue = $cards[$i-1]->getValue()+1;

            // Tricky condition because Aces
            // A-2-3-4-5 and 10-J-Q-K-A are valid straight
            // Case A -> 10
            $isInCase = $cards[$i-1]->getValue() === 1 && $cards[$i]->getValue() === 10;

            if($currentValue !== $waitedCurrentValue && !($isInCase)) {
                return false;
            }
        }

        return true;
    }

    public static function checkThreeOfAKind(array $cards) {
        $groupedCards = self::groupByValue($cards);
        foreach($groupedCards as $value => $group) {
            if(count($group) === 3) {
                return true;
            }
        }
        return false;
    }

    public static function checkTwoPair(array $cards) {
        $groupedCards = self::groupByValue($cards);
        $asAlreadyPair = false;
        foreach($groupedCards as $value => $group) {
            if(count($group) === 2) {
                if($asAlreadyPair) {
                    return true;
                }
                $asAlreadyPair = true;
            }
        }
        return false;
    }

    public static function checkPair(array $cards) {
        $groupedCards = self::groupByValue($cards);
        foreach($groupedCards as $value => $group) {
            if(count($group) === 2) {
                return true;
            }
        }
        return false;
    }

}