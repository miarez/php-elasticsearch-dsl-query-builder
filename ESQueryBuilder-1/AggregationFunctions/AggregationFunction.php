<?php



class AggregationFunction {

    const ELASTIC_KEY_MAPPING = [
        "count" => "value_count",
        "sum"   => "sum"
    ];

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
}