<?php

namespace Repositories;

use App\Code;

use Cache;

class CodeRepository {

  public function getDropDown($group, $skip_null = false)
  {
    Cache::flush();
    return Cache::remember("code.$group", 90, function() use($group, $skip_null)
    {
      $return = [];

      if (!$skip_null) {
        $return = [''=> trans('form.select_any') ];
      }

      return $return + array_column(Code::where('cod_group', '=', $group)->where('cod_status', '=', 'active')->get()->toArray(), 'cod_description', 'cod_key');
    });

  }
}
