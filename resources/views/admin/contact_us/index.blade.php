@extends('layouts.admin')
@section('title', 'contact us')


@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-warning">
            <div class="card-header ">
                <h3 class="card-title">Messages form contact us page</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Short</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Status</th>

                        <th>Solution</th>
                        <th>Update</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{$contact->id}}</td>
                            <td>{{$contact->name}}</td>
                            <td>{{$contact->email}}</td>
                            <td>{{$contact->subject}}</td>
                            <td>{{$contact->shortenMessage()}}</td>
                            <td>{{$contact->created_at->format('d.m.Y H:i')}}</td>
                            <td>@if($contact->created_at != $contact->updated_at){{$contact->updated_at->format('d.m.Y H:i')}}@else - @endif</td>
                            <td>{{$contact->status}}</td>
                            <td>{{$contact->solution}}</td>
                            <td><a class="btn btn-warning" href="{{route('admin.contact.us.edit', ['id'=>$contact->id])}}">Edit </a></td>
                        </tr>
                    @empty
                        <tr><td>There are no messages</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
        <ul class="pagination pagination-sm">

            {{ $contacts->links() }}
        </ul>
    </div>

@endsection


