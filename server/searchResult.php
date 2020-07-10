<?php

class SearchResult implements JsonSerializable {
    private $title;
    private $link;
    private $snippet;

    public function __construct($title, $link, $snippet) {
        $this->title = $this->replaceHighlight($title);
        $this->link = (string)$link;
        $this->snippet = $this->replaceHighlight($snippet);
    }

    private function replaceHighlight($str) {
        $newStr = str_replace('<hlword>', '', $str);
        $newStr = str_replace('</hlword>', '', $newStr);
        $result = simplexml_load_string($newStr);
        if ($result) {
            return (string)$result;
        }
        return $newStr;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
}