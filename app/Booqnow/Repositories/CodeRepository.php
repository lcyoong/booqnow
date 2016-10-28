<?php

namespace Repositories;

use App\Code;

use Cache;

class CodeRepository {

  public function getDropDown($group)
  {
    return Cache::remember("code.$group", 90, function() use($group)
    {
      return [''=> trans('form.select_any') ] + array_column(Code::where('cod_group', '=', $group)->where('cod_status', '=', 'active')->get()->toArray(), 'cod_description', 'cod_key');
    });

  }
}
