@extends('layouts.admin')
@section('styles')
    <style>

    </style>
@endsection

@section('content')
    @include('partials.success_msg')
    @include('partials.confirmation_modal')

    <div class="col-12">
        <!-- Table -->
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title">Coupons</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Cart Value</th>
                        <th>Valid From</th>
                        <th>Valid Until</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>{{$coupon->id}}</td>
                            <td>{{$coupon->code}}</td>
                            <td>{{$coupon->type}}</td>
                            <td>-{{$coupon->value}}@if($coupon->type=="fixed") RSD @else % @endif</td>
                            <td>{{$coupon->cart_value}}</td>
                            <td>{{$coupon->valid_from}}</td>
                            <td>{{$coupon->valid_until}}</td>
                            <td><a href="{{route('admin.coupons.edit', $coupon)}}" class="btn btn-small btn-warning">Edit</a></td>
                            <td><button class="fc_delete_modal btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" data-route="{{route('admin.coupons.destroy', $coupon)}}">Delete</button></td>
                        </tr>
                    @empty
                        <tr><td>There are no coupons</td></tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
{{--        <ul class="pagination pagination-sm">--}}

{{--            {{ $products->links() }}--}}
{{--        </ul>--}}

    </div>

@endsection
@section('scripts')
<script>
    let confirmation_modal=document.getElementById('confirmation_modal');
    let route;
    let rowToBeDeleted;

    const addToaster=(className="alert-success", msg)=>{
        const timer=(clasName)=>{
            toaster.classList.contains('alert-danger') ? toaster.classList.remove('alert-danger') :null;
            toaster.classList.contains('alert-success') ? toaster.classList.remove('alert-success') :null;
            toaster.textContent="";
            toaster.classList.add('d-none');
        };
        let toaster=document.getElementById('fc_toaster');
        toaster.textContent=msg;
        toaster.classList.add(className);
        toaster.classList.remove('d-none');
        setTimeout(timer, 2000);
    }

    const deleteRow=(e)=>{
        axios.post(route, {}).then((data)=>{
            console.log(data)
            if(data.data.hasOwnProperty('success')){
                $('#confirmation_modal').modal('hide');//too complicated to use without jQ
                rowToBeDeleted.remove();
                addToaster('alert-success', 'Row deleted successfully')
            }else if(data.data.hasOwnProperty('errors')){
                $('#confirmation_modal').modal('hide');//too complicated to use without jQ
                addToaster('alert-danger', data.data.errors)
            }
        });
    }

    const getDeleteRowAndRoute=(e)=>{
        route =e.target.hasAttribute('data-route') ? e.target.getAttribute('data-route') : null;
        rowToBeDeleted=e.target.closest('tr');
        //console.log(deleteRoute, rowToBeDeleted);


        new Listener('click', 'confirm_modal_button', 'id', deleteRow);
    }



    new Listener('click', 'fc_delete_modal', 'class', getDeleteRowAndRoute);

</script>

@endsection

