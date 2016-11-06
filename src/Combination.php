<?php

namespace Combinatorics;

class Combination
{
    private $characters = '';

    private $size = 1;

    private $repetition = true;

    private $charactersSplitted = [];

    private $initialized = false;

    private $currentCombination = [];

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
     * @return boolean
     */
    private function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @param boolean $initialized
     * @return Combination
     */
    private function setInitialized(bool $initialized): Combination
    {
        $this->initialized = $initialized;

        return $this;
    }

    /**
     * @return array
     */
    public function get()
    {
        $combinations = [];
        while (( $combination = $this->next() ) !== false) {
            $combinations[] = $combination;
        }

        return $combinations;
    }

    /**
     * @param string $file
     * @param string $delimiter
     */
    public function write($file, $delimiter)
    {
        $firstLineWritten = false;
        while (( $combination = $this->next() ) !== false) {
            if ($firstLineWritten) {
                file_put_contents($file, $delimiter, FILE_APPEND);
            }
            file_put_contents($file, $combination, FILE_APPEND);

            $firstLineWritten = true;
        }
    }

    public function next()
    {
        $this->initialize();

        $combination = $this->combinate($this->currentCombination);

        return $combination;
    }

    private function initialize()
    {
        if ( ! $this->isInitialized()) {
            $this->setCharactersSplitted(preg_split('//u', $this->getCharacters(), -1, PREG_SPLIT_NO_EMPTY));
            $this->setInitialized(true);
        }
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
            if ($combinationArray[$count] < count($this->getCharactersSplitted()) - 1) {
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