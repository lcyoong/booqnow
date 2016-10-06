<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">{{ $page_title or ''}}</h4>
</div>
<div class="modal-body">
    @yield('content_modal')
</div>
