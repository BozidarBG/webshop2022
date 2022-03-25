@extends('layouts.admin')
@section('title', 'create employee')


@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-warning">
            <div class="card-header ">
                <h3 class="card-title">Employees</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Roles</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    @forelse($employees as $employee)
                        <tr>
                            <td>{{$employee->id}}</td>
                            <td>{{$employee->name}}</td>
                            <td>
                                @foreach($employee->roles as $role)
                                    <p>{{$role->name}}</p>
                                @endforeach
                            </td>
                            <td><a class="fc_edit btn btn-warning" href="{{route('admin.employees.edit', [$employee])}}">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td>There are no employees</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
    </div>

@endsection


