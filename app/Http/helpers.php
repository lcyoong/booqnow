<?php

function urlTenant($path)
{
  if (config('myapp.multi_tenant')) {
    return url(session('merchant')->mer_id . '/' . $path);
  }

  return url($path);  
}
