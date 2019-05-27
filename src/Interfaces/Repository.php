<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Interfaces;

interface Repository
{
    public function storeOrUpdate(array $input, int $id = null);

    public function find(int $id, array $with = []);

    public function all(array $with = []);

    public function setFilters($filters = []);

    public function destroy(int $id);

    public function applyFilters();

    public function newQuery();
}
