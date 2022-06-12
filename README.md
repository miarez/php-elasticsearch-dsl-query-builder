# php-elasticsearch-dsl-query-builder


```php

$query = (new DSLQuery())->
    bindFilter(
        (new Must())
            ->bindConditional(
            (new Range())
                ->field("date")
                ->from("now/M")
                ->includeLower(true)
            )->bindConditional(
                (new MatchPhrase())
                    ->field("event")
                    ->query("click")
            )
    )
    ->bindAggregation(
        (new TermAggregation())
            ->field("country")
    )
    ->build()
;

```
