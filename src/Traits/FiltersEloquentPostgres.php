<?php
/**
 * Created for Kodmaster23.
 * User: Thiago Traczykowski
 */

namespace Kodmaster23\LaravelQuickStart\Traits;


trait FiltersEloquentPostgres
{

    public function applyFilterOnAuditFields(){

        $created_at_begin = null;
        $created_at_end = null;
        $created_by = null;
        $updated_at_begin = null;
        $updated_at_end = null;
        $updated_by = null;

        extract($this->filters);

        $this->query->when($created_at_begin, function ($query) use($created_at_begin){
            return $query->where($this->getTableName().".created_at",'>=', $created_at_begin);
        });
        $this->query->when($created_at_end, function ($query) use($created_at_end){
            return $query->where($this->getTableName().".created_at",'<=', $created_at_end);
        });
        $this->query->when($created_by, function ($query) use($created_by){
            return $query->where($this->getTableName().".created_by", $created_by);
        });
        $this->query->when($updated_at_begin, function ($query) use($updated_at_begin){
            return $query->where($this->getTableName().".updated_at",'>=', $updated_at_begin);
        });
        $this->query->when($updated_at_end, function ($query) use($updated_at_end){
            return $query->where($this->getTableName().".updated_at",'<=', $updated_at_end);
        });
        $this->query->when($updated_by, function ($query) use($updated_by){
            return $query->where($this->getTableName().".updated_by", $updated_by);
        });
    }


    public function applyFilterOnTrashed(){

        $deleted_at_begin = null;
        $deleted_at_end = null;
        $deleted_by = null;
        $with_trashed = null;

        extract($this->filters);

        if($with_trashed){
            $this->query->withTrashed();
        }

        $this->query->when($deleted_at_begin, function ($query) use($deleted_at_begin){
            return $query->where($this->getTableName().".deleted_at",'>=', $deleted_at_begin);
        });
        $this->query->when($deleted_at_end, function ($query) use($deleted_at_end){
            return $query->where($this->getTableName().".deleted_at",'<=', $deleted_at_end);
        });
        $this->query->when($deleted_by, function ($query) use($deleted_by){
            return $query->where($this->getTableName().".deleted_by", $deleted_by);
        });
    }

    public function applyIdFilter(){

        $id = null;

        extract($this->filters);

        $this->query->when($id, function ($query) use($id){
            return $query->where($this->getTableName().".id", $id);
        });
    }

}
