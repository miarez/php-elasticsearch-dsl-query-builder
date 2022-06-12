<?php



class Sum extends AggregationFunction implements  Scriptable{

    public function __construct()
    {
    }

    public function script(
        Script $script
    ) : self
    {
        $this->field            = $script->field;
        $this->scriptSource     = $script->source;
        return $this;
    }
}

