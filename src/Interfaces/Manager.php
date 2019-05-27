<?php


namespace Kodmaster23\LaravelQuickStart\Interfaces;


interface Manager
{

    public function storeOrUpdate(array $input, $id = null);

    public function destroy($id);

}