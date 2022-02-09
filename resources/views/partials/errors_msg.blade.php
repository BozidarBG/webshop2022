@if(session()->has('errors'))
<div class="col-12 alert alert-danger alert-dismissible fade show my-3" role="alert">
    <p>{{session()->get('errors')}}</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif