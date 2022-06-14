<?php


class Range extends EsQueryBuilder\Conditional {

    const ES_ALIAS = "range";

    public function __construct()
    {

    }

    public function from(
        string $from
    ) : self
    {
        $this->from = $from;
        return $this;
    }

    public function to(
        string $to
    ) : self
    {
        $this->to = $to;
        return $this;
    }
    public function includeLower(
        bool $includeLower
    ) : self
    {
        $this->includeLower = $includeLower;
        return $this;
    }

    public function includeUpper(
        bool $includeUpper
    ) : self
    {
        $this->includeUpper = $includeUpper;
        return $this;
    }

}
