<table class="table table-striped table-hover" v-if = "type.rty_master == 0">
  <thead>
    <tr>
      <th>@lang('addon.add_resource')</th>
      <th>@lang('addon.add_date')</th>
      <th>@lang('addon.add_unit')</th>
      <th>@lang('addon.add_reference')</th>
      <th>@lang('addon.add_status')</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for = "item in items" v-if = "item.resource.rs_type === type.rty_id">
      <td>@{{ item.resource.rs_name }}</td>
      <td>{{ Form::datepicker('add_date', trans('addon.add_date'), null, ['v-model' => 'item.add_date']) }}</td>
      <td>{{ Form::number('add_unit', null, ['v-model' => 'item.add_unit', 'class' => 'form-control', 'min' => 1, 'max' => 20]) }}</td>
      <td>{{ Form::text('add_reference', null, ['v-model' => 'item.add_reference', 'class' => 'form-control']) }}</td>
      <td>{{ Form::selectBasic('add_status', trans('addon.add_status'), $add_status, null, ['v-model' => 'item.add_status', 'class' => 'form-control']) }}</td>
      <td><itemized :item = "item" class="form-control btn btn-primary" action="{{ urlTenant('addons/update') }}" @completesuccess="doneUpdate">Save</itemized></td>
    </tr>
  </tbody>
</table>
