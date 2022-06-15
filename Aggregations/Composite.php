<?php


class Composite extends EsQueryBuilder\Aggregation
{
    const ES_ALIAS = "composite";

    public $size;
    public $sources;

    public function __construct()
    {
        $this->size = 0;
        $this->sources = [];
        parent::__construct();
    }

    public function setSize(
        int $size
    ) : self
    {
        $this->size = $size;
        return $this;
    }




}
