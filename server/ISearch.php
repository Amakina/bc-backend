<?php

interface ISearch {
    public function GetQueryResults($query, $page);
    public function SaveQueryToDB($pdo, $result, $query);
}