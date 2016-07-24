<?php

namespace Punkstar\Ssl\Parser;

class SanParser
{
    /**
     * @param $sanString
     * @return array
     */
    public function parse($sanString)
    {
        $results = explode(',', $sanString);

        array_walk($results, function(&$item) {
            $item = trim($item);
            $item = str_replace("DNS:", "", $item);
        });

        return $results;
    }
}