@if(session()->has('success'))
<div class="col-12 alert alert-success alert-dismissible fade show my-3" role="alert">
    <p>{{session()->get('success')}}</p>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
