<?php


class Term extends Conditional {

    const ES_ALIAS = "term";


    public function termValue(
        string $termValue
    ) : self
    {
        $this->termValue = $termValue;
        return $this;
    }



}