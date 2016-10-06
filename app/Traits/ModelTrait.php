<?php
namespace App\Traits;

trait ModelTrait
{
    public function scopeGetPaginated($query, $perPage = 10)
    {
        return $query->paginate($perPage);
    }

    public function validate($input, $rules)
    {
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return General::jsonBadResponse(implode("<br />", $validator->errors()->all()));
        } else {
            return null;
        }
    }

    public function scopeToDropDown($query, $key_col, $value_col)
    {
        return [''=> trans('form.select_any') ] + array_column($query->get()->toArray(), $value_col, $key_col);
    }

}
