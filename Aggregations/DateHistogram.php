<?php


class DateHistogram extends EsQueryBuilder\Aggregation {

    const ES_ALIAS = "date_histogram";

    const FORMAT_YMD        = "yyyy-MM-dd";
    const FORMAT_YMD_HIS    = "yyyy-MM-dd HH:mm:ss";

    const INTERVAL_MONTH     = "1M";
    const INTERVAL_WEEK      = "1w";
    const INTERVAL_DAY       = "1d";
    const INTERVAL_HOUR      = "1h";
    const INTERVAL_MINUTE    = "1m";

    public function __construct()
    {
        parent::__construct();

    }

    public function format(
        string $format
    ) : self
    {
        $this->format = $format;
        return $this;
    }
    public function interval(
        string $interval
    ) : self
    {
        $this->interval = $interval;
        return $this;
    }
    public function offset(
        int $offset
    ) : self
    {
        $this->offset = $offset;
        return $this;
    }



}


//"aggregations": {
//    "day": {
//        "date_histogram": {
//            "field": "date",
// 				"format": "yyyy-MM-dd",
// 				"interval": "1d",
// 				"offset": 0,
// 				"order": {
//                "_key": "asc"
// 				},
// 				"keyed": false,
// 				"min_doc_count": 0
// 			},