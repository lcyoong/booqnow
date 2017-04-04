<?php

namespace App\Traits;

trait ModelTrait
{
  /**
   * Paginated output
   * @param  Builder  $query
   * @param  integer $perPage - number of items per page
   * @return Builder
   */
  public function scopeGetPaginated($query, $perPage = 10)
  {
      return $query->paginate($perPage);
  }

  /**
   * Validate input
   * @param  array $input - Input data
   * @param  array $rules - Validation rules
   * @return mixed
   */
  public function validate($input, $rules)
  {
      $validator = Validator::make($input, $rules);
      if ($validator->fails()) {
          return General::jsonBadResponse(implode("<br />", $validator->errors()->all()));
      } else {
          return null;
      }
  }

  /**
   * Drop down output
   * @param  Builder $query
   * @param  string $key_col - column name to be used as drop-down index
   * @param  string $value_col - column name to be used as drop-down label
   * @return array
   */
  public function scopeToDropDown($query, $key_col, $value_col)
  {
    return array_column($query->get()->toArray(), $value_col, $key_col);
  }

  /**
   * Apply filter
   * @param  Builder $query
   * @param  QueryFilter $filters - Filter object
   * @return Builder
   */
  public function scopeFilter($query, $filters)
  {
    return $filters->apply($query);
  }

}
