<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repositories\AuditTrailRepository;
use Filters\AuditTrailFilter;

class AuditTrailController extends MainController
{
  protected $repo;

  public function __construct()
  {
    parent::__construct();

    $this->tenant = true;
  }

  public function get(Request $requet, $type, $id)
  {
    $filters = new AuditTrailFilter(['modelType' => $type, 'modelId' => $id]);

    $trail = (new AuditTrailRepository)->with(['creator'])->get($filters, null, ['au_id' => 'desc']);

    $this->layout = 'layouts.modal';

    $this->page_title = trans('audit.list');

    $this->vdata(compact('trail'));

    return view('audit.view', $this->vdata);
  }

  // public function trail($object)
  // {
  //   // $object = $this->repo->findById($id);
  //
  //   $trail = $object->auditTrails;
  //
  //   $this->layout = 'layouts.modal';
  //
  //   $this->page_title = trans('audit.list');
  //
  //   $this->vdata(compact('trail'));
  //
  //   return view('audit.view', $this->vdata);
  // }


}
