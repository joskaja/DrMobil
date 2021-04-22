<?php


namespace App\Providers;


use AjCastro\Searchable\Search\SublimeSearch;

class ExactSearchServiceProvider extends SublimeSearch
{
    /**
     * {@inheritDoc}
     */
    protected function parseSearchStr($searchStr)
    {
        return "%{$searchStr}%"; // produces "where `column` like '%{$searchStr}%'"
    }
}
