<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Artisan;

use App\Http\Requests;
use App\Country;
use App\Merchant;
use App\Subscription;
use Booqnow\Repositories\MerchantRepository;
use Repositories\CountryRepository;

class MerchantController extends MainController
{
  protected $repo_mer;

  public function __construct(MerchantRepository $repo_mer)
  {
    parent::__construct();

    $this->repo_mer = $repo_mer;

    $countries = (new CountryRepository)->getDropDown();

    $this->vdata(compact('countries'));
  }

  public function index()
  {
    $this->page_title = trans('merchant.accounts');

    $merchants = $this->repo_mer->getPages();

    $this->vdata(compact('merchants'));

    return view('merchant.list', $this->vdata);
  }

  public function create()
  {
    $this->page_title = trans('merchant.create');

    return view('merchant.new', $this->vdata);
  }

  public function edit(Merchant $merchant)
  {
    $this->page_title = trans('merchant.edit');

    $mer_setting = unserialize($merchant->mer_setting);

    $this->vdata(compact('merchant', 'mer_setting'));

    return view('merchant.edit', $this->vdata);
  }

  public function store(Request $request)
  {
    $input = $request->input();

    $this->validation($request);

    $this->repo_mer->store($input);
  }

  public function update(Request $request)
  {
    $input = $request->input();

    $this->validation($request);

    $this->repo_mer->update($input);
  }

  protected function validation($request)
  {
    $this->validate($request, [
        'mer_name' => 'required|max:255',
        'mer_country' => 'required',
    ]);
  }

}
