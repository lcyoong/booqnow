<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Merchant;
use Booqlee\Repositories\MerchantUserRepository;

class MerchantUserController extends MainController
{
  protected $repo_mus;

  public function __construct(MerchantUserRepository $repo_mus)
  {
    parent::__construct();

    $this->repo_mus = $repo_mus;
  }

  public function index(Merchant $merchant)
  {
    $this->page_title = trans('merchant.users') . ' for ' . $merchant->mer_name;

    $merchant_users = $this->repo_mus->getList();

    $this->vdata(compact('merchant_users', 'merchant'));

    return view('merchant_user.list', $this->vdata);
  }

  public function create(Merchant $merchant)
  {
    $this->page_title = trans('merchant.users') . ' for ' . $merchant->mer_name;

    $this->vdata(compact('merchant'));

    return view('merchant_user.new', $this->vdata);
  }

  public function store(Request $request)
  {
    $this->repo_mus->store($request);
  }
}
