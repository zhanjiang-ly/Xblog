<?php
/**
 * Created by PhpStorm.
 * User: lufficc
 * Date: 2016/8/19
 * Time: 17:41
 */
namespace App\Http\Repository;

use App\Map;
use Illuminate\Http\Request;

/**
 * Class TagRepository
 * @package App\Http\Repository
 */
class MapRepository extends Repository
{
    static $tag = 'map';

    public function getAll()
    {
        $maps = $this->remember('map.all', function () {
            return Map::all();
        });
        return $maps;
    }

    public function getByTag($tag)
    {
        $maps = $this->remember('map.tag.' . $tag, function () use ($tag) {
            return Map::where('tag', $tag)->get();
        });
        return $maps;
    }

    public function getArrayByTag($tag)
    {
        $maps = $this->getByTag($tag);
        $arr = [];
        foreach ($maps as $map)
        {
            $arr[$map->key] = $map->value;
        }
        return $arr;
    }

    public function get($key)
    {
        $map = $this->remember('map.one.' . $key, function ()  use ($key){
            return Map::where('key', $key)->first();
        });
        return $map;
    }

    public function create(Request $request)
    {
        $this->clearCache();

        $map = Map::create([
            'key' => $request['key'],
            'value' => $request['value'],
        ]);
        return $map;
    }

    public function tag()
    {
        return MapRepository::$tag;
    }
}