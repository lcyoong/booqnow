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

  /**
   * Create a new controller instance.
   * @param MerchantRepository $repo_mer
   */
  public function __construct(MerchantRepository $repo_mer)
  {
    parent::__construct();

    $this->repo_mer = $repo_mer;

    $countries = (new CountryRepository)->getDropDown();

    $this->vdata(compact('countries'));
  }

  /**
   * Display merchant accounts list
   * @return Response
   */
  public function index()
  {
    $this->page_title = trans('merchant.accounts');

    $merchants = $this->repo_mer->getPages();

    $this->vdata(compact('merchants'));

    return view('merchant.list', $this->vdata);
  }

  /**
   * Display new merchant account form
   * @return Response
   */
  public function create()
  {
    $this->page_title = trans('merchant.create');

    return view('merchant.new', $this->vdata);
  }

  /**
   * Display edit merchant account form
   * @param  int $mer_id - Merchant id
   * @return Response
   */
  public function edit($mer_id)
  {
    $merchant = (new MerchantRepository)->findById($mer_id);

    $this->page_title = trans('merchant.edit');

    $mer_setting = unserialize($merchant->mer_setting);

    $this->vdata(compact('merchant', 'mer_setting'));

    return view('merchant.edit', $this->vdata);
  }

  /**
   * * Process storing of new merchant account
   * @param  Request $request
   * @return Response
   */
  public function store(Request $request)
  {
    $new = $this->repo_mer->store($request->input());

    return $this->goodReponse(null, $new->mer_id);
  }

  /**
   * Process updating of a customer
   * @param  Request $request
   * @return Response
   */
  public function update(Request $request)
  {
    $this->repo_mer->update($request->input());

    return $this->goodReponse();
  }

  // protected function validation($request)
  // {
  //   $this->validate($request, [
  //       'mer_name' => 'required|max:255',
  //       'mer_country' => 'required',
  //   ]);
  // }

}
