<?php

namespace Repositories;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Validator;
use Contracts\BaseRepositoryInterface;
// use Illuminate\Foundation\Validation\ValidatesRequests;

class BaseRepository implements BaseRepositoryInterface
{

  // use ValidatesRequests;

  protected $paginate = 10;

  protected $repo;

  protected $rules = [];

  protected $expectsJson = false;

  protected $filter;

  public function __construct($class)
  {
    $this->repo = new $class();
  }

  public function getPages($filters, $joins = [], $order = 'desc')
  {
    $resource = $this->repo->select('*');

    foreach ($joins as $join){

      $resource->join($join['table'], $join['left_col'], '=', $join['right_col']);
    }

    // $resource->filter($filters)->paginate($this->paginate);
    $resource->orderBy($this->repo->getKeyName(), $order);

    if (!is_null($this->filter)) {
      $resource->filter($this->filter);
    }

    return $resource->filter($filters)->paginate($this->paginate);
  }

  public function get($filters = null, $limit = 0, $with = [], $joins = [])
  {
    $resource = $this->repo->select('*');

    if (!is_null($filters)) {
      $resource->filter($filters);
    }

    if (!is_null($this->filter)) {
      $resource->filter($this->filter);
    }

    foreach ($joins as $join){

      $resource->join($join['table'], $join['left_col'], '=', $join['right_col']);
    }

    if ($limit > 0) {
      $resource->limit($limit);
    }

    if (count($with) > 0) {
      $resource->with($with);
    }

    return $resource->get();
  }

  public function findById($id)
  {
    return $this->repo->findOrFail($id);
  }

  public function store($input)
  {
    // $input = $request->input();

    $this->validate($input);

    return $this->repo->create($input);
  }

  public function update($input)
  {
    // $input = $request->input();

    $resource = $this->repo->findOrFail(array_get($input, $this->repo->getKeyName()));

    $this->validate($resource->toArray() + $input);

    return $resource->update($input);
  }

  public function deleteById($id)
  {
    return $this->repo->find($id)->delete();
  }

  public function validate($input)
  {
    $validator = Validator::make($input, $this->rules);

    if ($validator->fails()) {

      throw new ValidationException($validator, $validator->messages());
    }
  }

  public function all($columns = ['*'])
  {
    return $this->repo->get($columns);
  }

  public function paginate($perPage = 15, $columns = ['*'])
  {
    return $this->repo->paginate($perPage, $columns);
  }

  public function filter($filters)
  {
    return $this->repo->filter($filters);
  }

  public function getDropDown($key, $label, $cache_name = null)
  {
    $resource = $this->repo->select('*');

    if (!is_null($this->filter)) {
      $resource->filter($this->filter);
    }

    if (!is_null($cache_name)) {
      return Cache::remember($cache_name, 90, function()
      {
        return $resource->toDropDown($key, $label);
      });
    } else {
      return $resource->toDropDown($key, $label);
    }

  }

}
