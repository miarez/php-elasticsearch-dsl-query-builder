
# php-elasticsearch-dsl-query-builder

Lightweight dependency-free elastic search query builder decorator. 
Aims to help prevent having to dig through a JSON to create a DSL query.
Paired with the right IDE, the autocomplete functionality of the IDE helps know which operations can be bound to which parts of the query.

Note: This Library is a work in process, and much of the functionality has not yet been contributed.
## To Do
* Nested Aggregation Filters
* Composite Functionality 
* Script Aggregations 
* Cardinality, sum case when, etc


## Usage

### Basic Example
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

## Aggregation Functions 

Supports:
# Count, Sum, Avg 
# Basic Scripting (ie. divide by 100)

Still missing:
# Advanced Aggregation Functions (stats, extended_stats, etc)
# Advanced Scripting (toLower, etc) 

```php
$query = (new DSLQuery())
    ->bindAggregationFunction(
        (new Count())
            ->field("_index")
            ->alias("NON_NESTED_AGG_COUNT")
    )
    ->bindAggregationFunction(
        (new Sum())
            ->script(new Script("ppc", "/", 100))
            ->alias("revenue_in_cents")
    )
    ->build()
;
```



## License
The person who associated a work with this deed has dedicated the work to the public domain by waiving all of his or her rights to the work worldwide under copyright law, including all related and neighboring rights, to the extent allowed by law.

You can copy, modify, distribute and perform the work, even for commercial purposes, all without asking permission. See Other Information below.

In no way are the patent or trademark rights of any person affected by CC0, nor are the rights that other persons may have in the work or in how the work is used, such as publicity or privacy rights.
Unless expressly stated otherwise, the person who associated a work with this deed makes no warranties about the work, and disclaims liability for all uses of the work, to the fullest extent permitted by applicable law.
When using or citing the work, you should not imply endorsement by the author or the affirmer.



