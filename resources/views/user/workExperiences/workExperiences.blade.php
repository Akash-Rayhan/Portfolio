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

    <!-- WorkExperience List -->
    <div class="card">
        <div class="card-header">Work Experiences
            <button type="button" id="addWorkExperience"><i class="fa fa-plus" aria-hidden="true" ></i></button>
        </div>
        <div class="card-body" id="workExperience-div">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="workExperience-edit-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="edit-company_name">Company Name</label>
                        <input type="text" name="edit-company_name" id="edit-company_name" value="" class="form-control">
                        <label for="edit-job_position">Job Position</label>
                        <input type="text" name="edit-job_position" id="edit-job_position" value="" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="workExperience-edit-form-submit" data-dismiss="modal">Save changes</button>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            workExperienceData();

            $('#addWorkExperience').on('click',function () {
                workExperienceFormDom();
            })

            function workExperienceData() {
                $.ajax({
                    url: '{{route('web.user.workExperience.data')}}',
                    method:'GET',
                }).done(function (data) {
                    console.log();
                    workExperienceDataDom(data.data);
                }).fail(function (error) {
                    console.log(error)
                });
            }

            function workExperienceDataDom(workExperience) {
                let html = '';
                for(let i=0; i<workExperience.length; i++) {
                    html += '<li>'+
                        '<div class="row">'+
                        '<div class="col-md-6 " id="company_name">'+workExperience[i].company_name+'</div>'+
                        '<div class="col-md-4">'+
                        '<button type="button" data-id="'+workExperience[i].id+'" data-company_name="'+workExperience[i].company_name+'" data-job_position="'+workExperience[i].job_position+'" id="workExperience-edit-button" class="btn edit_modal" data-toggle="modal" data-target="#workExperience-edit-form"  rel="modal:open"><i class="fa fa-edit"></i></button>'+
                        '<button data-id="'+workExperience[i].id+'" id="workExperience-delete"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<hr>';
                }
                $('#workExperience-div').html(html);
            }

            function workExperienceFormDom() {
                let html='<label>Company Name</label>'+
                    '<br>'+
                    '<input type="text" name="company_name" id="company_name" value="">'+
                    '<br>'+
                    '<label>Job position</label>'+
                    '<br>'+
                    '<input type="text" name="job_position" id="job_position" value="">'+
                    '<br>'+
                    '<button type="submit" id="workExperience-store">Save</button>';
                $('#workExperience-div').html(html);
            }

            $('#workExperience-div').on('click','#workExperience-store',function () {
                let company_name = $('#workExperience-div').find('#company_name').val();
                let job_position = $('#workExperience-div').find('#job_position').val();
                saveWorkExperience(company_name, job_position);
            })

            function saveWorkExperience(company_name, job_position) {
                $.ajax({
                    url: '{{route('web.user.workExperience.store')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'POST',
                    data: {
                        'company_name': company_name,
                        'job_position': job_position,
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    workExperienceData();
                }).fail(function (error) {
                    console.log(error);
                });
            }

            let editWorkExperienceId;

            $("#workExperience-div").on('click','#workExperience-edit-button',function () {
                editWorkExperienceId = $(this).data('id');
                let company_name = $(this).data('company_name');
                let job_position = $(this).data('job_position');
                setProjectFormData(company_name, job_position);
            });

            function setProjectFormData(company_name, job_position) {
                $("#workExperience-edit-form").find("#edit-company_name").val(company_name);
                $("#workExperience-edit-form").find("#edit-job_position").val(job_position);
            }

            $("#workExperience-edit-form-submit").on('click',function () {
                let company_name = $('#edit-company_name').val();
                let job_position = $('#edit-job_position').val();
                updateEducation(company_name, job_position);
            })

            function updateEducation(company_name, job_position) {
                $.ajax({
                    url: '{{route('web.user.workExperience.update')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'PATCH',
                    data: {
                        'id': editWorkExperienceId,
                        'company_name': company_name,
                        'job_position': job_position
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    workExperienceData();
                }).fail(function (error) {
                    console.log(error);
                });
            }
            $("#workExperience-div").on('click','#workExperience-delete',function () {
                let id = $(this).data('id');
                deleteProject(id);
            })
            function deleteProject(id) {
                $.ajax({
                    url: '{{route('web.user.workExperience.delete')}}',
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
                    workExperienceData();
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
