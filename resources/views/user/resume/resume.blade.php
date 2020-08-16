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
        <div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>

    <!-- WorkExperience List -->
    <div class="card">
        <div class="card-header">Resume
            <Form  method="POST" action="{{route('web.user.resume.store')}}" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="">
                <label>File</label>
                <input type="file" name="file" id="file" value="">
                <button type="submit" id="resume-store">Save</button>
            </Form>
        </div>
        <div class="card-body" id="resume-div">

        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function () {
            resumeData();

            function resumeData() {
                $.ajax({
                    url: '{{route('web.user.resume.data')}}',
                    method:'GET',
                }).done(function (data) {
                    console.log();
                    resumeDataDom(data.data);
                }).fail(function (error) {
                    console.log(error)
                });
            }

            function resumeDataDom(resume) {
                let html = '';
                for(let i=0; i<resume.length; i++) {
                    html += '<li>'+
                        '<div class="row">'+
                        '<div class="col-md-6 " id="title">'+resume[i].title+'</div>'+
                        '<div class="col-md-4">'+
                        '<button data-id="'+resume[i].id+'" data-file_name="'+resume[i].file_name+'" id="resume-delete">Delete<i class="fa fa-trash"></i></button>'+
                        '<button  data-file_name="'+resume[i].file_name+'" id="resume-download">Download<i class="fa fa-download"></i></button>'+
                        '</div>'+
                        '</div>'+
                        '</li>'+
                        '<hr>';
                }
                $('#resume-div').html(html);
            }

            $("#resume-div").on('click','#resume-delete',function () {
                let id = $(this).data('id');
                let file_name = $(this).data('file_name');
                deleteResume(id, file_name);
            })

            function deleteResume(id, file_name) {
                $.ajax({
                    url: '{{route('web.user.resume.delete')}}',
                    headers: {
                        'X-CSRF-TOKEN':"{{csrf_token()}}",
                        'accept': "application/json"
                    },
                    method: 'DELETE',
                    data: {
                        'id': id,
                        'file_name' : file_name
                    },
                }).done(function (data) {
                    console.log();
                    if(data.success === true){
                        printSuccessMsg(data.message);
                    }
                    else{
                        printErrorMsg(data.message);
                    }
                    resumeData();
                }).fail(function (error) {
                    console.log(error);
                });
            }
            $("#resume-div").on('click','#resume-download',function () {
                let file_name = $(this).data('file_name');

            })
            function downloadResume(fileName) {

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
