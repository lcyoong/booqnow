<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
// use App\Customer;
// use App\Merchant;
use Repositories\CustomerRepository;
use Repositories\CountryRepository;
use Repositories\ResourceRepository;
use Filters\CustomerFilter;
use Event;

class CustomerController extends MainController
{
  protected $repo_cus;

  public function __construct(CustomerRepository $repo_cus)
  {
    parent::__construct();

    $this->repo_cus = $repo_cus;

    $this->tenant = true;
  }

  // Display customers list
  public function index(Request $request)
  {
    $filters = new CustomerFilter($request->input());

    $this->passFilter($request->input());

    $this->page_title = trans('customer.list');

    $this->new_path = urlTenant('customers/new');

    $customers = $this->repo_cus->getPages($filters);

    $this->vdata(compact('customers'));

    return view('customer.list', $this->vdata);
  }

  // Display new customer form
  public function create()
  {
    $this->page_title = trans('customer.new');

    return view('customer.new', $this->vdata);
  }

  // Display edit customer form
  public function edit($cus_id)
  {
    $customer = (new CustomerRepository)->findById($cus_id);

    $this->page_title = trans('customer.edit');

    $this->vdata(compact('customer'));

    return view('customer.edit', $this->vdata);
  }

  // Process storing of new customer
  public function store(Request $request)
  {
    $new = $this->repo_cus->store($request->input());

    return $this->goodReponse(null, $new->cus_id);
  }

  // Process updating of a customer
  public function update(Request $request)
  {
    $this->repo_cus->update($request->input());

    return $this->goodReponse();
  }

  public function pick(Request $request)
  {
    $this->layout = 'layouts.modal';

    $this->page_title = trans('customer.new');

    return view('customer.new_basic', $this->vdata);
  }
}
