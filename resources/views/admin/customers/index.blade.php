@extends('layouts.admin')
@section('title', 'customers')


@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-warning">
            <div class="card-header ">
                <h3 class="card-title">Customers</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{$customer->id}}</td>
                            <td>{{$customer->name}}</td>
                            <td>{{$customer->email}}</td>
                            <td><a class="btn btn-warning" href="{{route('admin.customers.show', [$customer])}}">View profile</a></td>
                        </tr>
                    @empty
                        <tr><td>There are no customers</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
        <ul class="pagination pagination-sm">

            {{ $customers->links() }}
        </ul>
    </div>

@endsection


