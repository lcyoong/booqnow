<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\AuditTrailRepository;

class AuditTrailController extends MainController
{
  protected $repo;

  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;
  }

  public function trail($object)
  {
    // $object = $this->repo->findById($id);

    $trail = $object->auditTrails;

    $this->layout = 'layouts.modal';

    $this->page_title = trans('audit.list');

    $this->vdata(compact('trail'));

    return view('audit.view', $this->vdata);
  }


}
