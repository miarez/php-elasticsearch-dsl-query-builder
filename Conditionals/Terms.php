<?php


class Terms extends EsQueryBuilder\Conditional {

    const ES_ALIAS = "terms";


    public function termValues(
        array $termValues
    ) : self
    {
        $this->termValues = $termValues;
        return $this;
    }



}