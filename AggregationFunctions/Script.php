<?php


class Script
{
    const OPERATORS = [
        "+",
        "-",
        "/",
        "*",
    ];

    public function __construct(
        string $field,
        string $operator,
        int $operand
    )
    {
        if(!in_array($operator, self::OPERATORS))
        {
            throw new TypeError("[{$operator}] Is Not A Valid Supported Operator");
        }

        $this->field        = $field;
        $this->operator     = $operator;
        $this->operand      = $operand;
        $this->source       = "doc['$field'].value / {$operand};";
    }

}