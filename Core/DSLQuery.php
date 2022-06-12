<?php


class DSLQuery {

    const LOGIC_ERROR_AGGREGATION_AGGREGATION_FUNCTION =
        "Cannot Declare Both Aggregations And Aggregations Functions";

    private $from;
    private $size;
    private $includes;
    private $filter;
    private $aggregations;
    private $aggregationFunctions;

    function __construct()
    {
        $this->from = 0;
        $this->size = 0;
        $this->includes = [];
        $this->aggregations = [];
        $this->aggregationFunctions = [];
    }

    function bindFilter(
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

    public function bindAggregation(
        Aggregation $aggregation
    ) : self
    {
        $this->aggregations[] = $aggregation;
        return $this;
    }


    public function build()
    {

        $array = [];
        $array["from"]  = $this->from;
        $array["size"]  = $this->size;


        if(!empty($this->filter))
        {
            $array["query"] =  [
                "bool" => [
                    "filter" => [
                        $this->buildFilter($this->filter)
                    ]
                ]
            ];
        }

        if(!empty($this->aggregations)){
            $array["aggregations"] = $this->buildAggregation($this->aggregations);
        }

        if(!empty($this->aggregationFunctions))
        {
            if(!empty($this->aggregations)){
                throw new LogicException(self::LOGIC_ERROR_AGGREGATION_AGGREGATION_FUNCTION);
            }
            $array["aggregations"] = $this->buildAggregationFunctions(
                $this->aggregationFunctions
            );
        }

        return $array;
    }


    private function buildAggregation(
        array $aggregationInputArray
    )
    {

        foreach($aggregationInputArray as $aggregation)
        {

            if(!empty($aggregation->aggregationFunctions))
            {
                $aggregationFunctionArray = $this->buildAggregationFunctions($aggregation->aggregationFunctions);
            }

            $type = (get_class($aggregation)::ES_ALIAS);

            foreach($aggregation as $key=>$value)
            {
                if(
                    Aggregation::METHOD_FIELD_MAPPING[$key] &&
                    isset($value)
                ){
                    $parameters[Aggregation::METHOD_FIELD_MAPPING[$key]] = $value;
                }
            }

            $alias = $aggregation->alias ?: $aggregation->field;

            $aggregationRow = (Object) [];
            $aggregationRow->$alias =  (Object) [];
            $aggregationRow->$alias->$type =  $parameters;

            if($aggregation->aggregations){
                $aggregationKey = "aggregations";
                $aggregationRow->$alias->$aggregationKey = $this->buildAggregation($aggregation->aggregations);

            } else {
                if($aggregationFunctionArray){
                    $aggregationKey = "aggregations";
                    $aggregationRow->$alias->$aggregationKey = $aggregationFunctionArray;
                }
            }
        }

        return $aggregationRow;

    }



    private function buildFilter(
        DSLFilter $filter
    ) : array
    {


        $type = strtolower(get_class($filter));
        $conditionals = $this->buildConditionals($filter->conditionals);

        
        if($filter->filter)
        {
            $conditionals[] = $this->buildFilter($filter->filter);
        }

        $out["bool"] = (Object) [];
        $out["bool"]->$type = $conditionals;
        return $out;

    }





    private function buildConditionals(
        array $conditionalList
    ) : array
    {

        $conditionals = [];
        foreach($conditionalList as $index=>$conditional)
        {
            $conditionalRow = (Object) [];


            $className  = get_class($conditional);
            $type       = $className::ES_ALIAS;

            # weird edge case -> figure out later why
            if(class_implements(get_class($conditional))["fieldException"]){
                $conditionalRow->$type = (Object) [
                    "field" => $conditional->field
                ];
                $conditionals[] = $conditionalRow;
                continue;
            }

            $conditionalRow->$type = (Object) [];
            $conditionalRow->$type->{$conditional->field} = [];

            foreach($conditional as $key=>$value){

                if(
                    $key == "field"  ||
                    empty(Conditional::METHOD_FIELD_MAPPING[$key])
                ) continue;

                $key = (Conditional::METHOD_FIELD_MAPPING[$key]) ?: $key;

                if($key == "terms")
                {
                    $conditionalRow->$type->{$conditional->field} = $value;

                } else {
                    $conditionalRow->$type->{$conditional->field}[$key] = $value;
                }


            }
            $conditionals[] = $conditionalRow;
        }

        return $conditionals;
    }


    private function buildAggregationFunctions(
        array $aggregationFunctionsObject
    ) : object
    {
        $aggregationFunctions = (Object) [];
        foreach($aggregationFunctionsObject as $index=>$aggregationFunction)
        {
            $type = strtolower(get_class($aggregationFunction));
            $type = (AggregationFunction::ELASTIC_KEY_MAPPING[$type]) ?: $type;

            $alias = $aggregationFunction->alias ?: $aggregationFunction->field;

            $aggregationFunctions->$alias = (Object) [];


            if($aggregationFunction->scriptSource){
                $aggregationFunctions->$alias->$type = (Object) [
                    "script" => [
                        "source"    => $aggregationFunction->scriptSource,
                        "lang"      => "painless"
                    ]
                ];
            } else {
                $aggregationFunctions->$alias->$type = (Object) [
                    "field" => $aggregationFunction->field
                ];
            }
        }

        return $aggregationFunctions;
    }




}









