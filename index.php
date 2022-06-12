<?php

include __DIR__."/../../sandbox-common.php";


$esBuilderAutoLoad = function ($currentDir){
    foreach(scandir($currentDir) as $dir)
    {
        if(preg_match("#^\.$|^\.\.$|\.php#", $dir)) continue;

        $files = scandir($currentDir."/$dir/");

        if($interfaceDirectoryIndex = array_search("_interfaces", $files)){
            foreach(scandir($currentDir."/$dir/_interfaces/") as $interfaceFile){
                if(preg_match("#^\.$|^\.\.$#", $interfaceFile)) continue;
                include $currentDir."/$dir/_interfaces/$interfaceFile";
            }
            unset($files[$interfaceDirectoryIndex]);
        }

        foreach($files as $file)
        {
            if(preg_match("#^\.$|^\.\.$#", $file)) continue;
            include $currentDir."/$dir/$file";
        }
    }
};

$esBuilderAutoLoad(__DIR__);


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
                    ->field("_event")
                    ->query("jobredirect")
            )
            ->bindFilter(
                (new Should())
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("host")
                            ->query("www.talent.com")
                    )
                    ->bindConditional(
                        (new MatchPhrase())
                            ->field("host")
                            ->query("uk.talent.com")
                    )
            )
    )

    ->bindAggregation(
        (new TermAggregation())
            ->field("host")
            ->bindAggregationFunction(
                (new Sum())
                    ->field("billed_ppc")
                    ->alias("billedTotal")
            )
            ->bindFilter(
                (new Must())
                    ->alias("only_us")
                    ->bindConditional(
                        (new Term())
                            ->field("host")
                            ->termValue("www.talent.com")
                    )
                    ->bindAggregationFunction(
                        (new Count())
                            ->field("_index")
                            ->alias("only_us_count")
                    )
                    ->bindAggregationFunction(
                        (new Sum())
                            ->field("billed_ppc")
                            ->alias("billedFILTERED")
                    )
            )


    )
    ->bindAggregationFunction(
        (new Count())
            ->field("_index")
            ->alias("new_please_work")
    )

    ->build()
;

echo "<PRE>";
echo json_encode($query, JSON_PRETTY_PRINT);
echo "<BR>";
echo "<BR>";
echo "<BR>";
echo "<BR>";
print_r($query);

exit;

pp($query, 1);


$query = '{
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
                                        "to": null,
                                        "include_lower": true,
                                        "include_upper": true,
                                        "boost": 1
                                    }
                                }
                            },
                            {
                                "match_phrase": {
                                    "_event": {
                                        "query": "jobredirect",
                                        "slop": 0,
                                        "zero_terms_query": "NONE",
                                        "boost": 1
                                    }
                                }
                            },
                            {
                                "range": {
                                    "billed_ppc": {
                                        "from": "0",
                                        "to": null,
                                        "include_lower": false,
                                        "include_upper": true,
                                        "boost": 1
                                    }
                                }
                            }
                        ],
                        "adjust_pure_negative": true,
                        "boost": 1
                    }
                }
            ],
            "adjust_pure_negative": true,
            "boost": 1
        }
    },
    "_source": {
        "includes": [
            "COUNT"
        ],
        "excludes": []
    },
    "aggregations": {
        "clicks": {
            "value_count": {
                "field": "_index"
            }
        }
    }
}';


$query = '{
	"from": 0,
	"size": 0,
	"query": {
		"bool": {
			"filter": [{
				"bool": {
					"must": [{
						"bool": {
							"must": [{
								"range": {
									"date": {
										"from": "now\/M",
										"to": null,
										"include_lower": true,
										"include_upper": true,
										"boost": 1
									}
								}
							}, {
								"match_phrase": {
									"_event": {
										"query": "jobredirect",
										"slop": 0,
										"zero_terms_query": "NONE",
										"boost": 1
									}
								}
							}, {
								"range": {
									"billed_ppc": {
										"from": "0",
										"to": null,
										"include_lower": false,
										"include_upper": true,
										"boost": 1
									}
								}
							}],
							"adjust_pure_negative": true,
							"boost": 1
						}
					}],
					"adjust_pure_negative": true,
					"boost": 1
				}
			}],
			"adjust_pure_negative": true,
			"boost": 1
		}
	},
	"_source": {
		"includes": ["COUNT", "SUM", "SUM"],
		"excludes": []
	},
	"aggregations": {
		"host": {
			"terms": {
				"field": "host",
				"execution_hint": "map",
				"size": 1000,
				"shard_size": 20000,
				"min_doc_count": 1,
				"shard_min_doc_count": 0,
				"show_term_doc_count_error": false,
				"order": [{
					"_count": "desc"
				}, {
					"_key": "asc"
				}]
			},
			"aggregations": {
				"clicks": {
					"value_count": {
						"field": "_index"
					}
				},
				"billedCAD": {
					"sum": {
						"script": {
							"source": " def divide_578039473 = doc[\'billed_ppc_cad\'].value \/ 100;return divide_578039473;",
							"lang": "painless"
						}
					}
				},
				"billed": {
					"sum": {
						"field": "billed_ppc"
					}
				}
			}
		}
	}
}';
