<?php


class Wildcard extends Conditional {

    const ES_ALIAS = "wildcard";


    public function regex(
        string $regex
    ) : self
    {
        $this->wildcard = $regex;
        return $this;
    }



}