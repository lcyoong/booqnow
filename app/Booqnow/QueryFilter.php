<?php

namespace Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected $request;

    protected $builder;

    protected $joins;

    /**
     * Create new class instance
     */
    public function __construct($request = [])
    {
        $this->request = $request;

        $this->joins = [];
    }

    /**
     * Add new filter criteria
     * @param array $add - key-value array filter e.g. 'filter_field' => 'filter_value'
     */
    public function add($add)
    {
        $this->request += $add;
    }

    /**
     * Get the filters
     * @return array
     */
    public function filters()
    {
        return $this->request;
    }

    /**
     * Get the related Eloquent model joins for the filter
     * @return array
     */
    public function joins()
    {
        return $this->joins;
    }

    public function addJoins($join)
    {
        $this->joins[] = $join;
    }

    /**
     * Apply the filters into query
     * @param  Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                $value = is_array($value) ? $value : [$value];
                call_user_func_array([$this, $name], array_filter($value, array($this, 'myFilter')));
            }
        }

        foreach (array_unique($this->joins()) as $join) {
            if (method_exists($this, $join)) {
                call_user_func_array([$this, $join], []);
            }
        }
        return $this->builder;
    }

    private function myFilter($var)
    {
        return ($var !== null && $var !== false && $var !== '');
    }
}
