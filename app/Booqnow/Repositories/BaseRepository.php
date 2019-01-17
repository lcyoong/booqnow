<?php

namespace Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Validator;
use Contracts\BaseRepositoryInterface;
use Cache;

class BaseRepository implements BaseRepositoryInterface
{
    protected $paginate = 10;

    protected $repo;

    protected $rules = [];

    protected $rules_alt = [];

    protected $expectsJson = false;

    protected $filter;

    protected $update = false;

    protected $withs = [];

    /**
     * Create new repository instance
     * @param string $class - Model class name of child class
     */
    public function __construct($class)
    {
        $this->repo = new $class();
    }

    /**
     * Get the paginated result of query
     * @param  Filter $filters - Repository filter
     * @param  [type] $joins   [description]
     * @param  string $order   [description]
     * @return [type]          [description]
     */
    public function getPages($filters = null, $order = 'desc', $orderBy = null)
    {
        $resource = $this->repo->select('*');

        if (!is_null($filters)) {
            $resource->filter($filters);
        }

        if (!is_null($this->filter)) {
            $resource->filter($this->filter);
        }

        foreach ($this->withs as $with) {
            $resource->with($with);
        }

        $resource->orderBy(!is_null($orderBy) ? $orderBy : $this->repo->getKeyName(), $order);

        return $resource->paginate($this->paginate);
    }

    /**
     * Get the collection result of query
     * @param  [type]  $filters [description]
     * @param  integer $limit   [description]
     * @return [type]           [description]
     */
    public function get($filters = null, $limit = 0, $orders = [])
    {
        $resource = $this->repo->select('*');

        if (!is_null($filters)) {
            $resource->filter($filters);
        }

        if (!is_null($this->filter)) {
            $resource->filter($this->filter);
        }

        if ($limit > 0) {
            $resource->limit($limit);
        }

        foreach ($this->withs as $with) {
            $resource->with($with);
        }

        foreach ($orders as $field => $order) {
            $resource->orderby($field, $order);
        }

        return $resource->get();
    }

    /**
     * Get a single repository item by primary key
     * @param  int $id - Item id
     * @return Model
     */
    public function findById($id)
    {
        return $this->repo->with($this->withs)->findOrFail($id);
    }

    public function first()
    {
        $resource = $this->repo->select('*');
    
        if (!is_null($this->filter)) {
            $resource->filter($this->filter);
        }

        return $resource->first();
    }

    /**
     * Process storing of new repository item
     * @param  array $input - input data
     * @return Model
     */
    public function store($input)
    {
        $input = array_filter($input);

        $this->validate($input);

        return $this->repo->create($input);
    }

    /**
     * Process updating of repository item
     * @param  array $input - input data
     * @return Model
     */
    public function update($input)
    {
        $resource = $this->repo->findOrFail(array_get($input, $this->repo->getKeyName()));

        $this->validate(array_filter($input + $resource->toArray()));

        return $resource->update($input);
    }

    /**
     * Process deleting of repository item by primary key
     * @param  int $id - Item id
     * @return boolean
     */
    public function deleteById($id)
    {
        return $this->repo->find($id)->delete();
    }

    /**
     * Validate input data
     * @param  array $input - input data
     * @return void
     */
    public function validate($input)
    {
        $this->update = array_key_exists($this->repo->getKeyName(), $input);

        $validator = Validator::make($input, $this->rules());

        if ($validator->fails()) {
            throw new ValidationException($validator, $validator->messages());
        }
    }

    // public function all($columns = ['*'])
    // {
    //   return $this->repo->get($columns);
    // }

    // public function paginate($perPage = 15, $columns = ['*'])
    // {
    //   return $this->repo->paginate($perPage, $columns);
    // }

    public function filter($filters)
    {
        // return $this->repo->filter($filters);
        $this->filter = $filters;

        return $this;
    }

    /**
     * Get the key-value array result of a query
     * @param  string $key - Column name of the array key
     * @param  string $label - Column name of the array value
     * @param  string $cache_name - Cache name (optional)
     * @return array
     */
    public function getDropDown($key, $label, $cache_name = null)
    {
        $resource = $this->repo->select('*');

        if (!is_null($this->filter)) {
            $resource->filter($this->filter);
        }

        // Cache::flush();

        if (!is_null($cache_name)) {
            return Cache::remember($cache_name, 90, function () use ($resource, $key, $label) {
                return $resource->toDropDown($key, $label);
            });
        } else {
            return $resource->toDropDown($key, $label);
        }
    }

    public function with($values)
    {
        $this->withs = $values;

        return $this;
    }

    protected function rules()
    {
        if ($this->update && method_exists($this, 'alt_rules')) {
            return call_user_func([$this, 'alt_rules']);
        }

        return $this->rules;
    }

    public function __call($name, $arguments)
    {
        $this->filter->add([$name => $arguments]);

        return $this;
    }
}
