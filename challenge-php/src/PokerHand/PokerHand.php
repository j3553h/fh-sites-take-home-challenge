<?php
namespace PokerHand;
class PokerCard
{
    private $suit;
    private $denom;
    private $cvalue;
    public function __construct($card)
    {
        //looks for and sets the suit
        if (stripos($card, 'h') !== false) {
            $this->suit = 'h';
        }
        if (stripos($card, 's') !== false) {
            $this->suit = 's';
        }
        if (stripos($card, 'd') !== false) {
            $this->suit = 'd';
        }
        if (stripos($card, 'c') !== false) {
            $this->suit = 'c';
        }
        //-----------------------------------------------------
        // sets if low card
        if (intval($card) > 0) {
            $this->denom = intval($card);
            $this->cvalue = intval($card);
        }
        // sets if high card
        if (0 == intval($card)) {
            $this->denom = substr($card, 0, 1);
            if ($this->denom == 'J') {
                $this->cvalue = 11;
            }
            if ($this->denom == 'Q') {
                $this->cvalue = 12;
            }
            if ($this->denom == 'K') {
                $this->cvalue = 13;
            }
            if ($this->denom == 'A') {
                $this->cvalue = 14;
            }
        }
    }
    public function getSuit()
    {
        return $this->suit;
    }
    public function getDenom()
    {
        return $this->denom;
    }
    public function getCvalue()
    {
        return $this->cvalue;
    }
}
class PokerHand
{
    private $card1;
    private $card2;
    private $card3;
    private $card4;
    private $card5;
    public function __construct($hand)
    {
        //gives each card its own card object
        $hand_array = explode(' ', trim($hand));
        $this->card1 = new PokerCard($hand_array[0]);
        $this->card2 = new PokerCard($hand_array[1]);
        $this->card3 = new PokerCard($hand_array[2]);
        $this->card4 = new PokerCard($hand_array[3]);
        $this->card5 = new PokerCard($hand_array[4]);
    }
    private function checkFlush()
    {
        //checks if all cards are same suit
        if (
            $this->card1->getSuit() == $this->card2->getSuit() &&
            $this->card3->getSuit() &&
            $this->card4->getSuit() &&
            $this->card5->getSuit()
        ) {
            return 'Flush';
        }
    }
    private function checkStraight()
    {
        $a = 1;
        if (
            ($this->card1->getCvalue() == $this->card2->getCvalue() + $a) &&
            ($this->card2->getCvalue() == $this->card3->getCvalue() + $a) &&
            ($this->card3->getCvalue() == $this->card4->getCvalue() + $a) &&
            ($this->card4->getCvalue() == $this->card5->getCvalue() + $a)
            
        ) {
            return 'Straight';
        }
    }
    public function getRank()
    {
        //Flush
        if ($this->checkFlush() == 'Flush') {
            //Royal Flush
            $royalcheck =
                $this->card1->getDenom() .
                $this->card2->getDenom() .
                $this->card3->getDenom() .
                $this->card4->getDenom() .
                $this->card5->getDenom();
            if (
                strpos($royalcheck, 'A') !== false &&
                strpos($royalcheck, 'K') !== false &&
                strpos($royalcheck, 'Q') !== false &&
                strpos($royalcheck, 'J') !== false &&
                strpos($royalcheck, '10') !== false
            ) {
                return 'Royal Flush';
            }
            //Straight Flush
            if ($this->checkStraight() == 'Straight') {
                return 'Straight Flush';
            }
            return 'Flush';
        }
        //Pair
        if ($this->card1->getDenom() == $this->card2->getDenom()) {
            //checks pair
            if ($this->card1->getDenom() == $this->card3->getDenom()) {
                //checks 3 of a kind
                if ($this->card4->getDenom() == $this->card5->getDenom()) {
                    //checks full house
                    return 'Full House';
                }
                if ($this->card1->getDenom() == $this->card4->getDenom()) {
                    //checks 4 of a kind
                    return 'Four of a Kind';
                }
                return 'Three of a Kind';
            }
            //Two Pair
            if ($this->card3->getDenom() == $this->card4->getDenom()) {
                //checks second pair
                if ($this->card4->getDenom() == $this->card5->getDenom()) {
                    //checks full house
                    return 'Full House';
                }
                return 'Two Pair';
            }
            return 'One Pair';
        }
        //Regular Straight
        if ($this->checkStraight == 'Straight') {
            return 'Straight';
        }
        return 'High Card';
        // TODO: Implement poker hand ranking
    }
}
