<?php


class DSLFilter {

    public $conditionals;
    public $filter;

    public function __construct()
    {
        $this->conditionals = [];
    }


    public function bindConditional(
        Conditional $conditional
    ) : self
    {
        $this->conditionals[] = $conditional;
        return $this;
    }


    public function bindFilter(
        DSLFilter $filter
    ) : self
    {
        $this->filter = $filter;
        return $this;
    }
}
















