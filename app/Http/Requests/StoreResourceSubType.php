<?php

namespace App\Http\Requests;

class StoreResourceSubType extends BaseRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
      return [
        'rsty_type' => 'required|exists:resource_types,rty_id',
        'rsty_name' => 'required|max:255',
      ];
  }
}
