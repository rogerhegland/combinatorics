<?php

namespace Combinatorics;

class Combination
{
    private $characters = '';

    private $size = 1;

    private $repetition = true;

    private $charactersSplitted = [];

    /**
     * Combination constructor.
     *
     * @param array $values
     */
    public function __construct(array $values = [])
    {
        foreach ($values as $variableName => $value) {
            $setFunction = 'set'.ucfirst($variableName).substr($variableName, 1);
            $this->$setFunction($value);
        }
    }

    /**
     * @return string
     */
    private function getCharacters()
    {
        return $this->characters;
    }

    /**
     * @param string $characters
     * @return Combination
     */
    public function setCharacters($characters)
    {
        $this->characters = $characters;

        return $this;
    }

    /**
     * @return int
     */
    private function getSize()
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Combination
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRepetition()
    {
        return $this->repetition;
    }

    /**
     * @param boolean $repetition
     * @return Combination
     */
    public function setRepetition($repetition)
    {
        $this->repetition = $repetition;

        return $this;
    }

    /**
     * @return array
     */
    private function getCharactersSplitted(): array
    {
        return $this->charactersSplitted;
    }

    /**
     * @param array $charactersSplitted
     * @return Combination
     */
    private function setCharactersSplitted(array $charactersSplitted): Combination
    {
        $this->charactersSplitted = $charactersSplitted;

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        $this->setCharactersSplitted(preg_split('//u', $this->getCharacters(), -1, PREG_SPLIT_NO_EMPTY));

        $combinations = [];
        while (( $combination = $this->combinate($currentCombination) ) !== false) {
            $combinations[] = $combination;
        }

        return $combinations;
    }

    private function combinate(&$currentCombination = [])
    {
        if (count($currentCombination) == 0) {
            for ($i = 0; $i < $this->getSize(); $i++) {
                $currentCombination[$i] = 0;
            }
        }

        $combination = '';
        foreach ($currentCombination as $characterPointer) {
            if ( ! isset( $this->getCharactersSplitted()[$characterPointer] )) {
                return false;
            }

            $combination .= $this->getCharactersSplitted()[$characterPointer];
        }

        $this->increaseCombinationArray($currentCombination);

        return $combination;
    }

    private function increaseCombinationArray(&$combinationArray)
    {
        $count = count($combinationArray) - 1;

        $positionToIncrease = 0;
        while ($count >= 0) {
            if ($combinationArray[$count] < count($this->getCharactersSplitted())-1) {
                $positionToIncrease = $count;

                break;
            }

            $count--;
        }

        $position = 0;
        $increased = false;
        $increasedCombinationArray = [];
        foreach ($combinationArray as $pointer) {
            if ($increased) {
                $increasedCombinationArray[] = 0;
            }
            if ($position == $positionToIncrease) {
                $increasedCombinationArray[] = $pointer + 1;
                $increased = true;
            }

            if ( ! $increased) {
                $increasedCombinationArray[] = $pointer;
            }
            $position++;
        }

        $combinationArray = $increasedCombinationArray;
    }
}