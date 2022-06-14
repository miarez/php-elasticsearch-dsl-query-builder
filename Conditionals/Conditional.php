<?php

namespace EsQueryBuilder;


class Conditional {

    const METHOD_FIELD_MAPPING = [
        "field"         => "field",
        "query"         => "query",
        "from"          => "from",
        "to"            => "to",
        "includeLower"  => "include_lower",
        "includeUpper"  => "include_upper",
        "termValues"    => "terms",
        "termValue"     => "term",
        "wildcard"      => "wildcard",
    ];

    public function field(
        string $field
    ) : self
    {
        $this->field = $field;
        return $this;
    }

}