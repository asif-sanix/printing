@extends('admin.layouts.master')
@push('links')
<style type="text/css">
    label.form-check-label {
    height: 100px;
}
</style>
@endpush
@php
$admin = \Auth::guard('admin')->user();
@endphp


@section('main')






<div class="position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg profile-setting-img">
        <img src="{{asset(getAdmin('cover_photo')??'assets/images/profile-bg.jpg')}}" class="profile-wid-img" alt="">
        <div class="overlay-content">
            <div class="text-end p-3">
                <div class="p-0 ms-auto rounded-circle profile-photo-edit">
                    {!! Form::open(['route'=>['admin.profile.cover.photo.update',Auth::guard('admin')->user()->id],'method'=>'put', 'files'=>true, 'id'=>'update_profile_cover_photo']) !!}
                    <input onchange="updateProfileCoverPhoto($(this))" id="profile-foreground-img-file-input" type="file" name="cover_photo" class="profile-foreground-img-file-input">
                     {!! Form::close() !!}
                    <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light">
                        <i class="ri-image-edit-line align-bottom me-1"></i> Change Cover
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xxl-3">
        <div class="card mt-n5">
            <div class="card-body p-4">
                <div class="text-center">
                    <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                        <img src="{{asset(getAdmin('avatar')??'assets/images/users/avatar-1.jpg')}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                        <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                            {!! Form::open(['route'=>['admin.profile.photo.update',Auth::guard('admin')->user()->id],'method'=>'put', 'files'=>true, 'id'=>'update_profile_photo']) !!}
                            <input onchange="updateProfilePhoto($(this))" id="profile-img-file-input" name="avatar" type="file" class="profile-img-file-input">
                            {!! Form::close() !!}
                            <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                <span class="avatar-title rounded-circle bg-light text-body">
                                    <i class="ri-camera-fill"></i>
                                </span>
                            </label>
                        </div>
                    </div>
                    <h5 class="fs-16 mb-1">{{getAdmin('name')}}</h5>
                    <p class="text-muted mb-0">{{getAdmin('role')}}</p>
                </div>
            </div>
        </div>
        <!--end card-->
    </div>
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            <div class="card-header">
                <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#personal_details" role="tab">
                            <i class="bx bxs-user"></i> Personal Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#change_password" role="tab">
                            <i class="bx bxs-key"></i> Change Password
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#setting" role="tab">
                            <i class="mdi mdi-tools"></i> Setting
                        </a>
                    </li>
                 
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personal_details" role="tabpanel">
                            {!! Form::open(['route'=>'admin.profile.update','method'=>'put', 'files'=>true, 'id'=>'updateFrofile']) !!}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                        {!! Form::label('name', 'Name') !!}
                                        {!! Form::text('name', $admin->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    </div>
                                </div>


                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        {!! Form::label('email', 'Email') !!}
                                        {!! Form::email('email', $admin->email, ['class' => 'form-control', 'readonly' => 'readonly', 'placeholder' => 'eg: foo@bar.com']) !!}
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                        {!! Form::label('mobile_no', 'Mobile No.') !!}
                                        {!! Form::text('mobile_no', $admin->mobile, ['class' => 'form-control', 'placeholder' => 'Mobile No.']) !!}
                                        <small class="text-danger">{{ $errors->first('mobile_no') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                                        {!! Form::label('gender', 'Gender') !!}
                                        {!! Form::select('gender', ['male'=>'Male', 'female'=>'Female'], $admin->gender, ['id' => 'gender', 'class' => 'form-control', 'placeholder' => 'Gender']) !!}
                                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                              
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('date_of_birth') ? ' has-error' : '' }}">
                                        {!! Form::label('date_of_birth', 'Date Of Birth') !!}
                                        {!! Form::text('date_of_birth', $admin->date_of_birth, ['class' => 'form-control', 'placeholder' => 'Date Of Birth']) !!}
                                        <small class="text-danger">{{ $errors->first('date_of_birth') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                        {!! Form::label('state', 'State') !!}
                                        {!! Form::text('state', $admin->state, ['class' => 'form-control', 'placeholder' => 'State']) !!}
                                        <small class="text-danger">{{ $errors->first('state') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                        {!! Form::label('city', 'City') !!}
                                        {!! Form::text('city', $admin->city, ['class' => 'form-control', 'placeholder' => 'City']) !!}
                                        <small class="text-danger">{{ $errors->first('city') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-6">
                                    <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
                                        {!! Form::label('zipcode', 'Zipcode') !!}
                                        {!! Form::text('zipcode', $admin->pincode, ['class' => 'form-control', 'placeholder' => 'Zipcode']) !!}
                                        <small class="text-danger">{{ $errors->first('zipcode') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                        {!! Form::label('address', 'Address') !!}
                                        {!! Form::textarea('address', $admin->address, ['class' => 'form-control', 'placeholder' => 'Address','rows'=>3]) !!}
                                        <small class="text-danger">{{ $errors->first('address') }}</small>
                                    </div>
                                    <div class="mb-3 pb-2">
                                        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
                                            {!! Form::label('bio', 'BIO') !!}
                                            {!! Form::textarea('bio', $admin->bio, ['class' => 'form-control', 'placeholder' => 'BIO', 'rows'=>3]) !!}
                                            <small class="text-danger">{{ $errors->first('bio') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        {!! Form::button('Update Details', ['class' => 'btn btn-soft-secondary waves-effect waves-light','onClick'=>'updateDetails($(this))']) !!}
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        {!! Form::close() !!}
                    </div>
                    <!--end tab-pane-->
                    <div class="tab-pane" id="change_password" role="tabpanel">
                        {!! Form::open(['route'=>['admin.update-password',Auth::guard('admin')->user()->id],'method'=>'put', 'files'=>true, 'id'=>'change_password_form']) !!}
                            <div class="row g-2">
                                <div class="col-lg-4">
                                    <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                        {!! Form::label('current_password', 'Current Password') !!}
                                        {!! Form::password('current_password', ['class' => 'form-control', 'placeholder'=>'Current Password']) !!}
                                        <small class="text-danger">{{ $errors->first('current_password') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                                        {!! Form::label('new_password', 'New Password') !!}
                                        {!! Form::password('new_password', ['class' => 'form-control', 'placeholder'=>'New Password']) !!}
                                        <small class="text-danger">{{ $errors->first('new_password') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-4">
                                    <div class="form-group{{ $errors->has('new_password_confirmation') ? ' has-error' : '' }}">
                                        {!! Form::label('new_password_confirmation', 'Confirm Password') !!}
                                        {!! Form::password('new_password_confirmation', ['class' => 'form-control','placeholder'=>'Confirm Password']) !!}
                                        <small class="text-danger">{{ $errors->first('new_password_confirmation') }}</small>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-lg-12">
                                    <div class="text-end">
                                        {!! Form::button('Change Password', ['class' => 'btn btn-soft-secondary waves-effect waves-light','onClick'=>'changePassword($(this))']) !!}
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        {!! Form::close() !!}
                     
                    </div>


                    <div class="tab-pane" id="setting" role="tabpanel">
                        {!! Form::open(['route'=>['admin.update-setting',Auth::guard('admin')->user()->id],'method'=>'put', 'files'=>true, 'id'=>'change_password_form']) !!}
                        
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase fs-12">Color Scheme</h6>
                                    <p class="text-muted">Choose Light or Dark Scheme.</p>
                                </div>
                                <div class="col-md-2 col-sm-6">
                                    <div class="form-check card-radio">
                                        <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-light" value="light">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm" for="layout-mode-light">
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span class="d-flex h-100 flex-column">
                                                        <span class="bg-light d-block p-1"></span>
                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Light</h5>
                                </div>

                                <div class="col-md-2 col-sm-6">
                                    <div class="form-check card-radio dark">
                                        <input class="form-check-input" type="radio" name="data-bs-theme" id="layout-mode-dark" value="dark">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm bg-dark" for="layout-mode-dark">
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span class="bg-white bg-opacity-10 d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 bg-white bg-opacity-10 rounded mb-2"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-white bg-opacity-10"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span class="d-flex h-100 flex-column">
                                                        <span class="bg-white bg-opacity-10 d-block p-1"></span>
                                                        <span class="bg-white bg-opacity-10 d-block p-1 mt-auto"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Dark</h5>
                                </div>
                            </div>


                            <div class="row gy-3 mt-3">
                                <div class="col-md-12">
                                    <h6 class="mt-4 mb-0 fw-semibold text-uppercase fs-12">Layout Width</h6>
                                    <p class="text-muted">Choose Fluid or Boxed layout.</p>
                                </div>
                                <div class="col-md-2 col-sm-6 mt-0">
                                    <div class="form-check card-radio">
                                        <input id="customizer-layout01" name="data-layout" type="radio" value="vertical" class="form-check-input">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm" for="customizer-layout01">
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span class="d-flex h-100 flex-column">
                                                        <span class="bg-light d-block p-1"></span>
                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Vertical</h5>
                                </div>
                                <div class="col-md-2 col-sm-6 mt-0">
                                    <div class="form-check card-radio">
                                        <input id="customizer-layout02" name="data-layout" type="radio" value="horizontal" class="form-check-input">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm" for="customizer-layout02">
                                            <span class="d-flex h-100 flex-column gap-1">
                                                <span class="bg-light d-flex p-1 gap-1 align-items-center">
                                                    <span class="d-block p-1 bg-primary-subtle rounded me-1"></span>
                                                    <span class="d-block p-1 pb-0 px-2 bg-primary-subtle ms-auto"></span>
                                                    <span class="d-block p-1 pb-0 px-2 bg-primary-subtle"></span>
                                                </span>
                                                <span class="bg-light d-block p-1"></span>
                                                <span class="bg-light d-block p-1 mt-auto"></span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Horizontal</h5>
                                </div>
                                <div class="col-md-2 col-sm-6 mt-0">
                                    <div class="form-check card-radio">
                                        <input id="customizer-layout03" name="data-layout" type="radio" value="twocolumn" class="form-check-input">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm" for="customizer-layout03">
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1">
                                                        <span class="d-block p-1 bg-primary-subtle mb-2"></span>
                                                        <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-shrink-0">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span class="d-flex h-100 flex-column">
                                                        <span class="bg-light d-block p-1"></span>
                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Two Column</h5>
                                </div>
                                <!-- end col -->

                                <div class="col-md-2 col-sm-6 mt-0">
                                    <div class="form-check card-radio">
                                        <input id="customizer-layout04" name="data-layout" type="radio" value="semibox" class="form-check-input">
                                        <label class="form-check-label p-0 avatar-md w-100 shadow-sm" for="customizer-layout04">
                                            <span class="d-flex gap-1 h-100">
                                                <span class="flex-shrink-0 p-1">
                                                    <span class="bg-light d-flex h-100 flex-column gap-1 p-1">
                                                        <span class="d-block p-1 px-2 bg-primary-subtle rounded mb-2"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                        <span class="d-block p-1 px-2 pb-0 bg-primary-subtle"></span>
                                                    </span>
                                                </span>
                                                <span class="flex-grow-1">
                                                    <span class="d-flex h-100 flex-column pt-1 pe-2">
                                                        <span class="bg-light d-block p-1"></span>
                                                        <span class="bg-light d-block p-1 mt-auto"></span>
                                                    </span>
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                    <h5 class="fs-13 text-center mt-2">Semi Box</h5>
                                </div>
                                <!-- end col -->
                            </div>

                            <div class="col-lg-12">
                                <div class="text-end">
                                    {!! Form::button('Change Password', ['class' => 'btn btn-soft-secondary waves-effect waves-light','onClick'=>'changePassword($(this))']) !!}
                                </div>
                            </div>
                        
                        {!! Form::close() !!}
                    </div>


               
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

</div>





@endsection




@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/pages/profile-setting.init.js')}}"></script>
<script type="text/javascript">
    
   

     function updateProfileCoverPhoto(element){
        var requestData,otpdata,data;
        formData = new FormData(document.querySelector('#update_profile_cover_photo'));

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url:"{{ route('admin.profile.cover.photo.update',Auth::guard('admin')->user()->id) }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success:function(response){
                console.log(response);
                Toastify({
                    text: response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "success",

                }).showToast();
                //toastr.success(response.message); 
                document.querySelector('#update_profile_cover_photo').reset();
            },
            error:function(error){
                console.log(error);
                Toastify({
                    text: error.responseJSON.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "error",

                }).showToast();
                //toastr.error(error.responseJSON.message); 
                handleErrors(error.responseJSON);

            }
        });
    }



    function updateProfilePhoto(element){
        var requestData,otpdata,data;
        formData = new FormData(document.querySelector('#update_profile_photo'));

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url:"{{ route('admin.profile.photo.update',Auth::guard('admin')->user()->id) }}",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success:function(response){
                console.log(response);
                Toastify({
                    text: response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "success",

                }).showToast();
                //toastr.success(response.message); 
                document.querySelector('#update_profile_photo').reset();
            },
            error:function(error){
                console.log(error);
                Toastify({
                    text: error.responseJSON.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "error",

                }).showToast();
                //toastr.error(error.responseJSON.message); 
                handleErrors(error.responseJSON);

            }
        });
    }


    function changePassword(element){
        var button = new Button(element);
        button.process();
        clearErrors();
        var requestData,otpdata,data;
        formData = new FormData(document.querySelector('#change_password_form'));

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url:'{{ route('admin.update-password',Auth::guard('admin')->user()->id) }}',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success:function(response){
                Toastify({
                    text: response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "success",

                }).showToast();
                //toastr.success(response.message); 
                button.normal();
                document.querySelector('#change_password_form').reset();
            },
            error:function(error){
                Toastify({
                    text: error.responseJSON.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "error",

                }).showToast();
                //toastr.error(error.responseJSON.message); 
                button.normal();
                handleErrors(error.responseJSON);

            }
        });
    }


    function updateDetails(element){
        var button = new Button(element);
        button.process();
        clearErrors();
        var requestData,otpdata,data;
        formData = new FormData(document.querySelector('#updateFrofile'));

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url:'{{ route('admin.profile.update') }}',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success:function(response){
                Toastify({
                    text: response.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "success",

                }).showToast();
                toastr.success(response.message); 
                button.normal();
            },
            error:function(error){
                Toastify({
                    text: error.responseJSON.message,
                    duration: 3000,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    className: "error",

                }).showToast();
                toastr.error(error.responseJSON.message); 
                button.normal();
                handleErrors(error.responseJSON);

            }
        });
    }
</script>
@endpush