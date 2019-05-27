<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Traits;


trait Jsonable
{

    public function __get($name)
    {
        if(in_array($name, $this->jsonable)){
            $decoded = json_decode($this->attributes[$name]);
            return $decoded;
        }
        return $this->getAttribute($name);
    }

}
