<?php

namespace App;

trait Filterable {

    function scopeGenericFilter($query, $filter) {
        if (isset($filter->where)) {
            foreach ($filter->where as $key => $value) {
                $this->filter($query, $key, $value);
            }
        }
        return $query;
    }

    private function filter($query, $key, $value, $or = false) {
        if (!is_object($value)) {
            if ($or) {
                $query->orWhere($key, '=', $value);
            } else {
                $query->where($key, '=', $value);
            }
        } else if (in_array($key, ['and', 'or'])) {
            foreach($value as $k => $v) {
                $this->filter($query, $k, $v, in_array($key, ['or']));
            }
        } else if (count($value) == 1) {
            foreach ($value as $k => $v) {
                if ($k === 'like') {
                    if ($or) {
                        $query->orWhere($key, 'like', '%' . $v . '%');
                    } else {
                        $query->where($key, 'like', '%' . $v . '%');
                    }
                }
            }
        }
    }

}
