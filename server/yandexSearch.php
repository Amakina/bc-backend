<?php

require_once ('ISearch.php');
require_once ('searchResult.php');

class YandexSearch implements ISearch {
    private $searchKey;
    private $searchUser;

    public function __constructor($searchKey, $searchUser) {
        $this->searchKey = $searchKey;
        $this->searchUser = $searchUser;
    }

    public function GetQueryResults($query, $page) {
        $request = "https://yandex.com/search/xml?l10n=en&user=$this->searchUser&key=$this->searchKey&query=${query}&page=${page}&maxpassages=1";
        
        //$request = 'test.xml';

        $result = simplexml_load_file($request);

        $items = array('items' => [], 'page' => 0);

        $items['page'] = $result->request->page;

        foreach ($result->response->results->grouping->group as $group) {
            $title = (string)$group->doc->title->asXML();
            if (isset($group->doc->passages)) {
                $snippet = (string)$group->doc->passages->passage->asXML();
            } else {
                $snippet =(string)$group->doc->headline;
            }

            $item = new SearchResult($title, $group->doc->url, $snippet);
            $items['items'][] = $item;
        }

        return json_encode($items, JSON_UNESCAPED_UNICODE);
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