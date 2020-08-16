@extends('user.layouts.master')
@section('title', __('Dashboard'))
@section('style')
    <style>
        .dashboard-content {
            max-width: 100% !important;
        }
    </style>
@endsection

@section('content')

    <div class="container">
        <div class="alert alert-danger" style="display:none" id="error-message">
            <ul></ul>
        </div>
        <div class="alert alert-success" style="display:none" id="success-message">
            <ul></ul>
        </div>
    </div>

    <!-- Education List -->
    <div class="card">
        <div class="card-header">Education BackGround
            <button type="button" id="addEducation"><i class="fa fa-plus" aria-hidden="true" ></i></button>
        </div>
        <div class="card-body" id="education-div">

        </div>
    </div>

    <!-- Modal -->
        <div class="modal fade" id="education-edit-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-degree">Degree</label>
                            <input type="text" name="degree" id="edit-degree" value="" class="form-control">
                            <label for="edit-session">Session</label>
                            <input type="number" name="session" id="edit-session" value="" class="form-control">
                            <label for="edit-institution">Institution</label>
                            <input type="text" name="institution" id="edit-institution" value="" class="form-control">

                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="education-edit-form-submit" data-dismiss="modal">Save changes</button>
                </div>


            </div>
        </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            educationData();

            $('#addEducation').on('click',function () {
                educationFormDom();
            })

            function educationData() {
                $.ajax({
                    url: '{{route('web.user.education.data')}}',
                    method:'GET',
                }).done(function (data) {
                    console.log();
                    educationDataDom(data.data);
                }).fail(function (error) {
                    console.log(error)
                });
            }

            function educationDataDom(education) {
                let html = '';
                for(let i=0; i<education.length; i++) {
                    html += '<li>'+
                        '<div class="row">'+
                        '<div class="col-md-4 " id="degree">'+education[i].degree+'</div>'+
                        '<div class="col-md-2">'+
                        '<button type="button" data-id="'+education[i].id+'" data-degree="'+education[i].degree+'" data-session="'+education[i].session+'" data-institution="'+education[i].institution+'" id="education-edit-button" class="btn edit_modal" data-toggle="modal" data-target="#education-edit-form"  rel="modal:open"><i class="fa fa-edit"></i></button>'+
                        '<button data-id="'+education[i].id+'" id="education-delete"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<hr>';
                }
                $('#education-div').html(html);
            }

            function educationFormDom() {
                let html='<label>Degree</label>'+
                    '<br>'+
                    '<input type="text" name="degree" id="degree" value="">'+
                    '<br>'+
                    '<label>Session</label>'+
                    '<br>'+
                    '<input type="number" name="session" id="session" value="">'+
                    '<br>'+
                    '<label>Institution</label>'+
                    '<br>'+
                    '<input type="text" name="institution" id="institution" value="">'+
                    '<br>'+
                    '<button type="submit" id="education-store">Save</button>';
                $('#education-div').html(html);
            }

            $('#education-div').on('click','#education-store',function () {
                let degree = $('#education-div').find('#degree').val();
                let session = $('#education-div').find('#session').val();
                let institution = $('#education-div').find('#institution').val();
                saveEducation(degree, session, institution);
            })

            function saveEducation(degree, session, institution) {
                $.ajax({
                    url: '{{route('web.user.education.store')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'POST',
                    data: {
                        'degree': degree,
                        'session': session,
                        'institution': institution,
                    },
                }).done(function (data) {
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    educationData();
                }).fail(function (error) {
                    console.log();
                });
            }

            let editEducationId;

            $("#education-div").on('click','#education-edit-button',function () {
                editEducationId = $(this).data('id');
                let degree = $(this).data('degree');
                let session = $(this).data('session');
                let institution = $(this).data('institution');
                setEducationFormData(degree, session, institution);
            });

            function setEducationFormData(degree, session, institution) {
                $("#education-edit-form").find("#edit-degree").val(degree);
                $("#education-edit-form").find("#edit-session").val(session);
                $("#education-edit-form").find("#edit-institution").val(institution);
            }

            $("#education-edit-form-submit").on('click',function () {
                let degree = $('#edit-degree').val();
                let session = $('#edit-session').val();
                let institution = $('#edit-institution').val();
                updateEducation(degree, session, institution);
            })

            function updateEducation(degree, session, institution) {
                $.ajax({
                    url: '{{route('web.user.education.update')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'PATCH',
                    data: {
                        'id': editEducationId,
                        'degree': degree,
                        'session': session,
                        'institution': institution
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    educationData();
                }).fail(function (error) {
                    console.log(error);
                });
            }
            $("#education-div").on('click','#education-delete',function () {
                let id = $(this).data('id');
                deleteEducation(id);
            })
            function deleteEducation(id) {
                $.ajax({
                    url: '{{route('web.user.education.delete')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'DELETE',
                    data: {
                        'id': id
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    educationData();
                }).fail(function (error) {
                    console.log(error);
                });
            }

            function printErrorMsg (msg) {
                $("#error-message").find("ul").html('');
                $("#error-message").css('display', 'block');
                $("#error-message").find("ul").append('<li>' + msg + '</li>');
            }

            function printSuccessMsg (msg) {
                $("#success-message").find("ul").html('');
                $("#success-message").css('display', 'block');
                $("#success-message").find("ul").append('<li>' + msg + '</li>');
            }
        })
    </script>
@endsection
