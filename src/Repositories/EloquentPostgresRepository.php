<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Repositories;


use Kodmaster23\LaravelQuickStart\Interfaces\Repository;
use Kodmaster23\LaravelQuickStart\Traits\FiltersEloquentPostgres;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentPostgresRepository implements Repository
{
    use FiltersEloquentPostgres;

    protected $query;
    protected $filters;
    protected $model;
    protected $object;

    public function storeOrUpdate(array $input, int $id = null)
    {
        if (is_numeric($id)) {
            $this->object = $this->find($id);
        } else {
            $this->object = new $this->model;
        }
        $this->object->fill($input);
        $this->object->save();
        return $this->object;
    }

    public function find(int $id, $with = [])
    {
        $this->filters['id'] = $id;
        $this->newQuery();
        $this->applyIdFilter();
        $this->query->with($with);
        $this->object = $this->query->first();
        if (!$this->object) {
            $this->throwException($id);
        }
        $this->unsetFilters();
        return $this->object;
    }

    public function newQuery()
    {
        $this->query = (new $this->model)->query();
    }

    public function throwException($id)
    {
        throw new ModelNotFoundException();
    }

    public function unsetFilters()
    {
        $this->filters = [];
    }

    public function setFilters($filters = [])
    {
        $this->filters = $filters;
    }

    public function first($with = [])
    {
        $this->newQuery();
        $this->applyFilters();
        $this->query->with($with);
        $this->object = $this->query->first();
        $this->unsetFilters();
        return $this->object;
    }

    public function applyFilters()
    {
        if ($this->filters) {
            $this->applyIdFilter();
            $this->applyCustomFilters();
            $this->applyFilterOnAuditFields();
            $this->applyFilterOnTrashed();
        }
    }

    public function applyCustomFilters()
    {
        return $this->query;
    }

    public function all($with = [], $pagination = false)
    {
        $this->newQuery();
        $this->applyFilters();
        $this->setOrder();
        $this->query->with($with);
        if ($pagination == false) {
            $pagination = $this->query->count();
        }
        $result = $this->query->paginate($pagination);
        $this->unsetFilters();
        return $result;
    }

    public function setOrder()
    {
        $order = (new $this->model)->orderBy;
        if (isset($order)) {
            $this->query->orderBy($order, (new $this->model)->orderByType ?? "asc");
        }
    }

    public function destroy(int $id)
    {
        $this->object = null;
        return (new $this->model)->destroy($id);
    }

    public function getTableName()
    {
        return with(new $this->model)->getTable();
    }

}
