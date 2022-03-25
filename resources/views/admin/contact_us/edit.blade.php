@extends('layouts.admin')
@section('title', 'contact us')


@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title">Update status</h3>
            </div>
            <div class="card-body ">
                <p>Customer name: {{$contact->name}}</p>
                <p>Customer email: {{$contact->email}}</p>
                <p>Message subject: {{$contact->subject}}</p>
                <p>Message:</p>
                <p class="border p-2">{{$contact->message}}</p>
                <br>
                <h3>Update status</h3>
                 @include('partials.errors_msg')

                <form action="{{route('admin.contact.us.update', ['id'=>$contact->id])}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label >Update status</label>
                                <select class="form-control" name="status">
                                    <option value="pending" @if($contact->status==="pending") selected @endif>Pending</option>
                                    <option value="email_sent" @if($contact->status==="email_sent") selected @endif>Email sent</option>
                                    <option value="closed" @if($contact->status==="closed") selected @endif>Closed</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label >Update solution</label>
                                <select class="form-control" name="solution">
                                    <option value="pending" @if($contact->solution==="pending") selected @endif>Pending</option>
                                    <option value="discarded" @if($contact->solution==="discarded") selected @endif>Discarded</option>
                                    <option value="answered" @if($contact->solution==="answered") selected @endif>Answered via email</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-primary" role="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection


