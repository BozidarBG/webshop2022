@extends('layouts.admin')

@section('title', 'profile')

@section('styles')

@endsection

@section('content')
    @include('partials.confirmation_modal')
    @include('partials.success_msg')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>Change your password</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('users.update.password')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Old Password</label>
                            <input type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Old password">
                            @error('old_password')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password (must contain at least one number, one capital letter, one lower case letter and one special character, minimum 8 characters</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your new password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Repeat Password</label>
                            <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Repeat new password">
                        </div>
                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-info">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger">
                <h3>Delete your account</h3>
            </div>
            <div class="card-body">
                <form action="{{route('users.delete.account')}}" method="post" id="delete_account">
                    @csrf
                    <div class="text-center mt-5">
                        This action cannot be undone
                    </div>

                    <div class="text-center mt-5">
                        <button class="btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" role="button" id="cod_button">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        let delete_form=document.getElementById('delete_account');
        delete_form.addEventListener('submit', (e)=>{
            e.preventDefault();
            document.getElementById('confirmation_modal_body').textContent='Are you sure that you want to delete your account? Once confirmed, this action cannot be undone.';
            document.getElementById('confirm_modal_button').addEventListener('click', (e)=>{
                delete_form.submit();
            });
        });


    </script>
@endsection
