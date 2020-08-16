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

    <!-- Project List -->
    <div class="card">
        <div class="card-header">Project Details
            <button type="button" id="addProject"><i class="fa fa-plus" aria-hidden="true" ></i></button>
        </div>
        <div class="card-body" id="project-div">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="project-edit-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="edit-title">Project Name</label>
                        <input type="text" name="title" id="edit-title" value="" class="form-control">
                        <label for="edit-status">Project Status</label>
                        <select name="edit-status" id="edit-status" class="form-control">
                            <option value="{{CURRENT_PROJECTS}}">Current</option>
                            <option value="{{PREVIOUS_PROJECTS}}">Previous</option>
                        </select>
                        <label for="edit-repo_link">Repo Link</label>
                        <input type="text" name="repo_link" id="edit-repo_link" value="" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="project-edit-form-submit" data-dismiss="modal">Save changes</button>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            projectData();

            $('#addProject').on('click',function () {
                projectFormDom();
            })

            function projectData() {
                $.ajax({
                    url: '{{route('web.user.projects.data')}}',
                    method:'GET',
                }).done(function (data) {
                    console.log();
                    projectDataDom(data.data);
                }).fail(function (error) {
                    console.log(error)
                });
            }

            function projectDataDom(project) {
                let html = '';
                for(let i=0; i<project.length; i++) {
                    html += '<li>'+
                        '<div class="row">'+
                        '<div class="col-md-6 " id="title">'+project[i].title+'</div>'+
                        '<div class="col-md-4">'+
                        '<button type="button" data-id="'+project[i].id+'" data-title="'+project[i].title+'" data-repo_link="'+project[i].repo_link+'" data-status="'+project[i].status+'" id="project-edit-button" class="btn edit_modal" data-toggle="modal" data-target="#project-edit-form"  rel="modal:open"><i class="fa fa-edit"></i></button>'+
                        '<button data-id="'+project[i].id+'" id="project-delete"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<hr>';
                }
                $('#project-div').html(html);
            }

            function projectFormDom() {
                let html='<label>Project Name</label>'+
                    '<br>'+
                    '<input type="text" name="title" id="title" value="">'+
                    '<br>'+
                    '<label for="status">Project Status</label>' +
                    '<select name="status" id="status" class="form-control">' +
                    '<option value="{{CURRENT_PROJECTS}}">Current</option>'+
                    '<option value="{{PREVIOUS_PROJECTS}}">Previous</option>'+
                    '</select>'+
                    '<br>'+
                    '<label>Repo Link</label>'+
                    '<br>'+
                    '<input type="text" name="repo_link" id="repo_link" value="">'+
                    '<br>'+
                    '<button type="submit" id="project-store">Save</button>';
                $('#project-div').html(html);
            }

            $('#project-div').on('click','#project-store',function () {
                let title = $('#project-div').find('#title').val();
                let status = document.getElementById("status").value;
                let repo_link = $('#project-div').find('#repo_link').val();
                saveProject(title, status, repo_link);
            })

            function saveProject(title, status, repo_link) {
                $.ajax({
                    url: '{{route('web.user.projects.store')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'POST',
                    data: {
                        'title': title,
                        'status': status,
                        'repo_link': repo_link,
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    projectData();
                }).fail(function (error) {
                    console.log(error);
                });
            }

            let editProjectId;

            $("#project-div").on('click','#project-edit-button',function () {
                editProjectId = $(this).data('id');
                let title = $(this).data('title');
                let status = $(this).data('status');
                let repo_link = $(this).data('repo_link');
                setProjectFormData(title, status, repo_link);
            });

            function setProjectFormData(title, status, repo_link) {
                $("#project-edit-form").find("#edit-title").val(title);
                document.getElementById("edit-status").value = status;
                $("#project-edit-form").find("#edit-repo_link").val(repo_link);
            }

            $("#project-edit-form-submit").on('click',function () {
                let title = $('#edit-title').val();
                let status = document.getElementById("edit-status").value;
                let repo_link = $('#edit-repo_link').val();
                updateEducation(title, status, repo_link);
            })

            function updateEducation(title, status, repo_link) {
                $.ajax({
                    url: '{{route('web.user.projects.update')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'PATCH',
                    data: {
                        'id': editProjectId,
                        'title': title,
                        'status': status,
                        'repo_link': repo_link
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    projectData();
                }).fail(function (error) {
                    console.log(error);
                });
            }
            $("#project-div").on('click','#project-delete',function () {
                let id = $(this).data('id');
                deleteProject(id);
            })
            function deleteProject(id) {
                $.ajax({
                    url: '{{route('web.user.projects.delete')}}',
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
                    projectData();
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
