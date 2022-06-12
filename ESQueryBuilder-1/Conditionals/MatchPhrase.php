<?php




class MatchPhrase extends Conditional {

    const ES_ALIAS = "match_phrase";


    public function __construct()
    {
    }

    public function query(
        string $query
    ) : self
    {
        $this->query = $query;
        return $this;
    }


}
