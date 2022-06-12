
# php-elasticsearch-dsl-query-builder

Foobar is a Python library for dealing with word pluralization.

## Usage

### Code Example
```php
$query = (new DSLQuery())->
    bindFilter(
        (new Must())
            ->bindConditional(
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
### Would Output:

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

Please make sure to update tests as appropriate.

## License
The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law.

You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission. See Other Information below.

In no way are the patent or trademark rights of any person affected by CC0, nor are the rights that other persons may have in the work or in how the work is used, such as publicity or privacy rights.
Unless expressly stated otherwise, the person who associated a work with this deed makes no warranties about the work, and disclaims liability for all uses of the work, to the fullest extent permitted by applicable law.
When using or citing the work, you should not imply endorsement by the author or the affirmer.



