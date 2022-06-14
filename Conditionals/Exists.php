<?php


class Exist extends EsQueryBuilder\Conditional implements FieldException
{

    const ES_ALIAS = "exists";

    public function __construct()
    {

    }
}