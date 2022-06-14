<?php


class Term extends EsQueryBuilder\Conditional {

    const ES_ALIAS = "term";


    public function termValue(
        string $termValue
    ) : self
    {
        $this->termValue = $termValue;
        return $this;
    }



}