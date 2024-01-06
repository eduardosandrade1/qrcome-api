<?php

namespace App\Services;

class FilterComponentService
{

    public static function byName(string $name)
    {

        $jsonComponents = file_get_contents(base_path().'/components.json');
        $data = json_decode($jsonComponents, true);

        $component = array_filter($data, function ($item) use ($name) {
            return $item['name'] == $name;
        });

        return json_encode(reset($component));
    }

    public static function all()
    {
        $jsonComponents = file_get_contents(base_path().'/components.json');
        return json_decode($jsonComponents, true);
    }

}
