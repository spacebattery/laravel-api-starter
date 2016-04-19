<?php

namespace App;

trait Sortable {

    function scopeGenericSort($query, $filter) {
        if (isset($filter->sort)) {
            $this->sort($query, $filter->sort);
        }
        return $query;
    }

    private function sort($query, $value) {
        if (is_array($value)) {
            foreach ($value as $item) {
                $this->sort($query, $item);
            }
        } else {
            $arr = explode(' ', $value);
            $query->orderBy($arr[0], $arr[1]);
        }
    }

}
