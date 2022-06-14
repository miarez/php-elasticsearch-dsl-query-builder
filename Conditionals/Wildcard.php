<?php


class Wildcard extends EsQueryBuilder\Conditional {

    const ES_ALIAS = "wildcard";


    public function regex(
        string $regex
    ) : self
    {
        $this->wildcard = $regex;
        return $this;
    }



}