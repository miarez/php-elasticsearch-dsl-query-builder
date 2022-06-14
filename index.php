<?php

include "core.php";
esBuilderAutoLoad(__DIR__);


$query = (new EsQueryBuilder\DSLQuery())->

    bindFilter(
        (new Must())
            ->bindConditional(
            (new Range())
                ->field("date")
                ->from("now/M")
                ->includeLower(true)
            )->bindConditional(
                (new MatchPhrase())
                    ->field("_event")
                    ->query("click")
            )
            ->bindFilter(
                (new Should())
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("host")
                            ->query("www.website.com")
                    )
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("host")
                            ->query("uk.website.com")
                    )
            )
    )

    ->bindAggregation(
        (new TermAggregation())
            ->field("host")
            ->bindAggregationFunction(
                (new Sum())
                    ->field("ppc")
                    ->alias("REVENUE")
            )
            ->bindFilter(
                (new Must())
                    ->alias("only_us")
                    ->bindConditional(
                        (new Term())
                            ->field("host")
                            ->termValue("www.website.com")
                    )
                    ->bindAggregationFunction(
                        (new Count())
                            ->field("_index")
                            ->alias("only_us_count")
                    )
                    ->bindAggregationFunction(
                        (new Sum())
                            ->field("ppc")
                            ->alias("US_ONLY_REVENUE")
                    )
            )


    )
    ->bindAggregationFunction(
        (new Count())
            ->field("_index")
            ->alias("NON_NESTED_AGG_COUNT")
    )

    ->build()
;

echo "<PRE>";
echo json_encode($query, JSON_PRETTY_PRINT);
exit;

