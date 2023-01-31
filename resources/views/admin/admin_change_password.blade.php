@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        @if (count($errors))
                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger alert-dismissible fade show">{{$error}}</p>
                            @endforeach
                        @endif

                        <h4 class="card-title">Change Password</h4> <br>
                        <form action="{{ route('update.password') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="oldpassword" class="col-sm-2 col-form-label">Old Password</label>
                                <div class="col-sm-10">
                                    <input name="oldpassword" class="form-control" type="password" value="" id="oldpassword">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="newpassword" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input name="newpassword" class="form-control" type="password" value="" id="newpassword">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="confirmpassword" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10">
                                    <input name="confirmpassword" class="form-control" type="password" value="" id="confirmpassword">
                                </div>
                            </div>
                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Change Password">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

@endsection
