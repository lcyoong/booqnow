<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Country;
use App\Customer;
use App\Merchant;
use Repositories\CustomerRepository;
use Repositories\CountryRepository;
use Repositories\ResourceRepository;
use App\CustomerFilter;
use Event;

class CustomerController extends MainController
{
  protected $repo_cus;

  public function __construct(CustomerRepository $repo_cus)
  {
    parent::__construct();

    $this->repo_cus = $repo_cus;

    $this->tenant = true;

    $this->layout = 'layouts.tenant';

    $countries = (new CountryRepository)->getDropDown();

    $this->vdata(compact('countries'));
  }

  public function index(Request $request)
  {
    $filters = new CustomerFilter($request->input());

    $filter = $request->input();

    $this->page_title = trans('customer.list');

    $this->new_path = urlTenant('customers/new');

    $customers = $this->repo_cus->getPages($filters);

    $this->vdata(compact('customers', 'filter'));

    return view('customer.list', $this->vdata);
  }

  public function create()
  {
    $this->page_title = trans('customer.new');

    return view('customer.new', $this->vdata);
  }

  public function edit(Merchant $merchant, Customer $customer)
  {
    $this->page_title = trans('customer.edit');

    $this->vdata(compact('customer'));

    return view('customer.edit', $this->vdata);
  }

  public function store(Request $request)
  {
    // $this->validation($request);

    $new = $this->repo_cus->store($request->input());

    return $this->goodReponse('', $new->cus_id);
  }

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

  // protected function validation($request)
  // {
  //   $this->validate($request, [
  //       'cus_first_name' => 'required|max:255',
  //       'cus_last_name' => 'required|max:255',
  //       'cus_country' => 'required',
  //       'cus_email' => 'required|email',
  //       // 'cus_contact1' => 'required',
  //   ]);
  // }
}
