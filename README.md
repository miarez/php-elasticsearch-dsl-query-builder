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


```json
{
    "from": 0,
    "size": 0,
    "query": {
        "bool": {
            "filter": [
                {
                    "bool": {
                        "must": [
                            {
                                "range": {
                                    "date": {
                                        "from": "now\/M",
                                        "include_lower": true
                                    }
                                }
                            },
                            {
                                "match_phrase": {
                                    "event": {
                                        "query": "click"
                                    }
                                }
                            }
                        ]
                    }
                }
            ]
        }
    },
    "aggregations": {
        "country": {
            "terms": {
                "field": "country"
            }
        }
    }
}

```
