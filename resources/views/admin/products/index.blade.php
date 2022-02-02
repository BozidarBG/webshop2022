@extends('layouts.admin')
@section('styles')
    <style>

    </style>
@endsection

@section('content')
    @include('partials.succes_msg')
    @include('partials.confirmation_modal')
    <div class="col-12" id="search_form">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Search</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.products.search')}}" method="GET">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="search" name="search" class="form-control @error('name') is-invalid @enderror" placeholder="Search" value="{{old('search')}}">
                                @error('search')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>In field</label>
                                <select class="form-control" name="field">
                                    <option value="name">Name</option>
                                    <option value="acc_code">Accountant Code</option>
                                </select>
                                @error('order_by')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label>Order By</label>
                                <select class="form-control" name="order_by" id="exampleFormControlSelect1">
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                                @error('order_by')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-outline-warning">Search</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div id="fc_toaster" class="position-absolute w-25 alert d-none" style="z-index: 10"></div>

        <!-- Table -->
        <div class="card card-warning">
            <div class="card-header ">
                <h3 class="card-title">Products</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Acc.Code</th>
                        <th>Reg.Price</th>
                        <th>Action</th>
                        <th>Stock</th>
                        <th>Published</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->category->name}}</td>
                            <td>{{$product->acc_code}}</td>
                            <td>{{$product->formatedPrice()}}</td>
                            <td>{{$product->formatedActionPrice()}}</td>
                            <td>{{$product->stock}}</td>
                            <td>{{$product->published ? 'Yes': 'No'}}</td>
                            <td><a href="{{route('admin.products.edit', $product)}}" class="btn btn-small btn-warning">Edit</a></td>
                            @if($page==="Deleted products")
                            <td><button class="fc_restore_modal btn btn-success" data-toggle="modal" data-target="#confirmation_modal" data-route="{{route('admin.products.restore', [$product])}}">Restore</button></td>
                            @else
                            <td><button class="fc_delete_modal btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" data-route="{{route('admin.products.destroy', [$product])}}">Delete</button></td>
                            @endif
                        </tr>
                    @empty
                        <tr><td>There are no products</td></tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
        <ul class="pagination pagination-sm">

            {{ $products->links() }}
        </ul>

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
            //console.log(data)
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

    const restoreRow=(e)=>{
        route =e.target.hasAttribute('data-route') ? e.target.getAttribute('data-route') : null;
        rowToBeDeleted=e.target.closest('tr');
        document.getElementById('confirmation_modal_body').textContent="Are you sure that you want to restore this product?";

        new Listener('click', 'confirm_modal_button', 'id', deleteRow);
    }


    const toggleSearch=(e)=>{
        //console.log(e.target)
        let search=document.getElementById('search_form');
        search.classList.contains('d-none') ? search.classList.remove('d-none') : search.classList.add('d-none');
        
    }
    new Listener('click', 'fc_delete_modal', 'class', getDeleteRowAndRoute);
    new Listener('click', 'fc_restore_modal', 'class', restoreRow); 
    new Listener('click', 'navbar_search', 'id', toggleSearch)

    toggleSearch();
</script>

@endsection

