<?php
namespace App;

use Illuminate\Http\Request;

class QueryFilter
{
    public function __construct()
    {
    }

    protected $allowed_filters = [];

    public function addFilter()
    {

    }
    public static function getQueryString(Request $request)
    {
        $querystring = $request->query();
        foreach ($querystring as $field => $value) {
            echo $field . ': ' . $value;
        }
    }
}
