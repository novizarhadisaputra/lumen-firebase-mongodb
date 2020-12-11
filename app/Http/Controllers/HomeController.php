<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $jsonString = file_get_contents(base_path('public/data.json'));
        $json = json_decode($jsonString, true);
        $filter = collect($json['data']['response']['billdetails'])->map(function ($b) {
            $change = preg_replace('/\s/', '',  $b['body'][0]);
            $split = \explode(':', $change);
            $b['body'][0] = (int) $split[1];
            return $b['body'][0];
        })->filter(function ($v) {
            return $v >= 100000;
        });
        $data = $filter->values()->all();
        return response()->json(['message' => 'List data', 'data' => $data], 200);
    }
}
