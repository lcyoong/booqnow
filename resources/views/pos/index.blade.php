@extends($layout)

@push('content')
<div class="row">
    <div class="col-md-2">
        <ul>
            <li>Open Orders</li>
            <li>Closed Orders</li>
            <li>Cancelled Orders</li>
        </ul>
    </div>
    <div class="col-md-10">
        <h3>Open Orders x 10</h3>
        <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
            <div class="row">
                <div class="col-xs-6">Gingah (Maloney)</div>
                <div class="col-xs-3">Table 4</div>
                <div class="col-xs-3"><span class="label label-primary">Waiting 20 min</span></div>
            </div>
        </a>
      </h4>
    </div>
    <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body">
      <div class="row">
                        <div class="col-xs-6">Coffee</div>
                        <div class="col-xs-3">1</div>
                        <div class="col-xs-3">800</div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">Coffee</div>
                        <div class="col-xs-3">1</div>
                        <div class="col-xs-3">800</div>
                    </div>
                    <input type="submit" value="Close" class="btn btn-primary btn-sm">
                    <input type="submit" value="Cancel" class="btn btn-primary btn-sm">
                    <input type="submit" value="Edit" class="btn btn-primary btn-sm">
                    <input type="submit" value="Send" class="btn btn-primary btn-sm">

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
        <div class="row">
        <div class="col-xs-6">Gingah (Maloney)</div>
                        <div class="col-xs-3">Table 4</div>
                        <div class="col-xs-3"><span class="label label-primary">Completed 15 min</span></div>
                    </div>

        </a>
      </h4>
    </div>
    <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">
      <div class="row">
                        <div class="col-md-4">Coffee</div>
                        <div class="col-md-4">1</div>
                        <div class="col-md-4">800</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">Pad Thai (extra spicy)</div>
                        <div class="col-md-4">2</div>
                        <div class="col-md-4">1500</div>
                    </div>
                    <input type="submit" value="Close" class="btn btn-primary btn-sm">
                    <input type="submit" value="Cancel" class="btn btn-primary btn-sm">
                    <input type="submit" value="Edit" class="btn btn-primary btn-sm">
                    <input type="submit" value="Send" class="btn btn-primary btn-sm">

      </div>
    </div>
  </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
        Collapsible Group 3</a>
      </h4>
    </div>
    <div id="collapse3" class="panel-collapse collapse">
      <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
      sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
      minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
      commodo consequat.</div>
    </div>
  </div>
</div>


    </div>
</div>
@endpush