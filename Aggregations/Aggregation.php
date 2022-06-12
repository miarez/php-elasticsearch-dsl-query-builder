<?php


abstract class Aggregation {

    public $field;
    public $alias;
    public $order;
    public $minDocCount;
    public $keyed;

    // Date Histogram Fields
    public $format;
    public $interval;
    public $offset;

    public $filter;

    const METHOD_FIELD_MAPPING = [
        "field"         => "field",
        "order"         => "order",
        "minDocCount"   => "min_doc_count",
        "keyed"         => "keyed",
        "format"        => "format",
        "interval"      => "interval",
        "offset"        => "offset",
    ];

    public function __construct()
    {
        $this->aggregations         = [];
        $this->aggregationFunctions = [];
    }



    public function field(
        string $field
    ) : self
    {
        $this->field = $field;
        return $this;
    }

    public function alias(
        string $alias
    ) : self
    {
        $this->alias = $alias;
        return $this;
    }
    public function order(
        string $order
    ) : self
    {
        $this->order = $order;
        return $this;
    }


    public function minDocCount(
        int $minDocCount
    ) : self
    {
        $this->minDocCount = $minDocCount;
        return $this;
    }


    public function keyed(
        bool $keyed
    ) : self
    {
        $this->keyed = $keyed;
        return $this;
    }


    public function bindAggregationFunction(
        AggregationFunction $aggregationFunction
    ) : self
    {
        $this->aggregationFunctions[] = $aggregationFunction;
        return $this;
    }

    public function bindAggregation(
        Aggregation $aggregation
    ) : self
    {
        $this->aggregations[] = $aggregation;
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


