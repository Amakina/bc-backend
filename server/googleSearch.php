<?php

require_once ('ISearch.php');

class GoogleSearch implements ISearch {
    private $searchKey;
    private $searchEngineKey;

    public function __construct($searchKey, $searchEngineKey) {
        $this->searchKey = $searchKey;
        $this->searchEngineKey = $searchEngineKey;
    }

    public function GetQueryResults($query, $page) {
        $request = "https://www.googleapis.com/customsearch/v1?key=$this->searchKey&cx=$this->searchEngineKey&q=${query}&num=10&start=${page}";
        
        $result = file_get_contents($request);

        return $result;
    }

    public function SaveQueryToDB($pdo, $result, $query) {
        $add_result = 
            $pdo->prepare('
                INSERT INTO search_results(result, query)
                VALUES (:result, :query)
            ');

        $add_result->execute([
            'result' => $result,
            'query' => $query
        ]);
    }

}