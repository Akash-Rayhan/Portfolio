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

    <!-- Achievements List -->
    <div class="card">
        <div class="card-header">Achievements
            <button type="button" id="addAchievement"><i class="fa fa-plus" aria-hidden="true" ></i></button>
        </div>
        <div class="card-body" id="achievement-div">

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="achievement-edit-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="edit-title">Title</label>
                        <input type="text" name="edit-title" id="edit-title" value="" class="form-control">
                        <label for="edit-description">Description</label>
                        <input type="text" name="edit-description" id="edit-description" value="" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="achievement-edit-form-submit" data-dismiss="modal">Save changes</button>
            </div>


        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            achievementData();

            $('#addAchievement').on('click',function () {
                achievementFormDom();
            })

            function achievementData() {
                $.ajax({
                    url: '{{route('web.user.achievement.data')}}',
                    method:'GET',
                }).done(function (data) {
                    console.log();
                    achievementDataDom(data.data);
                }).fail(function (error) {
                    console.log(error)
                });
            }

            function achievementDataDom(achievement) {
                let html = '';
                for(let i=0; i<achievement.length; i++) {
                    html += '<li>'+
                        '<div class="row">'+
                        '<div class="col-md-6 " id="title">'+achievement[i].title+'</div>'+
                        '<div class="col-md-4">'+
                        '<button type="button" data-id="'+achievement[i].id+'" data-title="'+achievement[i].title+'" data-description="'+achievement[i].description+'" id="achievement-edit-button" class="btn edit_modal" data-toggle="modal" data-target="#achievement-edit-form"  rel="modal:open"><i class="fa fa-edit"></i></button>'+
                        '<button data-id="'+achievement[i].id+'" id="achievement-delete"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<hr>';
                }
                $('#achievement-div').html(html);
            }

            function achievementFormDom() {
                let html='<label>Title</label>'+
                    '<br>'+
                    '<input type="text" name="title" id="title" value="">'+
                    '<br>'+
                    '<label>Description</label>'+
                    '<br>'+
                    '<input type="text" name="description" id="description" value="">'+
                    '<br>'+
                    '<button type="submit" id="achievement-store">Save</button>';
                $('#achievement-div').html(html);
            }

            $('#achievement-div').on('click','#achievement-store',function () {
                let title = $('#achievement-div').find('#title').val();
                let description = $('#achievement-div').find('#description').val();
                saveWorkExperience(title, description);
            })

            function saveWorkExperience(title, description) {
                $.ajax({
                    url: '{{route('web.user.achievement.store')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'POST',
                    data: {
                        'title': title,
                        'description': description,
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    achievementData();
                }).fail(function (error) {
                    console.log(error);
                });
            }

            let editAchievementId;

            $("#achievement-div").on('click','#achievement-edit-button',function () {
                editAchievementId = $(this).data('id');
                let title = $(this).data('title');
                let description = $(this).data('description');
                setProjectFormData(title, description);
            });

            function setProjectFormData(title, description) {
                $("#achievement-edit-form").find("#edit-title").val(title);
                $("#achievement-edit-form").find("#edit-description").val(description);
            }

            $("#achievement-edit-form-submit").on('click',function () {
                let title = $('#edit-title').val();
                let description = $('#edit-description').val();
                updateEducation(title, description);
            })

            function updateEducation(title, description) {
                $.ajax({
                    url: '{{route('web.user.achievement.update')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'PATCH',
                    data: {
                        'id': editAchievementId,
                        'title': title,
                        'description': description
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    achievementData();
                }).fail(function (error) {
                    console.log(error);
                });
            }
            $("#achievement-div").on('click','#achievement-delete',function () {
                let id = $(this).data('id');
                deleteProject(id);
            })
            function deleteProject(id) {
                $.ajax({
                    url: '{{route('web.user.achievement.delete')}}',
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
                    achievementData();
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
