<?php

include "core.php";
esBuilderAutoLoad(__DIR__);


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
            ->bindFilter(
                (new Should())
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("country")
                            ->query("USA")
                    )
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("country")
                            ->query("Canada")
                    )
            )

    )
    ->bindAggregation(
        (new TermAggregation())
            ->field("country")
    )
    ->build()
;

echo "<PRE>";
echo json_encode($query, JSON_PRETTY_PRINT);
exit;

