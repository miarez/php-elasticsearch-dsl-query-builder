<?php


class DSLFilter {

    public $conditionals;
    public $filter;
    public $alias;

    public function __construct()
    {
        $this->conditionals = [];
    }

    public function alias(
        string $alias
    ) : self
    {
        $this->alias = $alias;
        return $this;
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


    public function bindAggregationFunction(
        AggregationFunction $aggregationFunction
    ) : self
    {
        $this->aggregationFunctions[] = $aggregationFunction;
        return $this;
    }

}
















