@extends('layouts.app')
@section('content')
    <!-- Student Modal -->
    <div class="modal fade" id="AddStudentModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" enctype="multipart/form-data" id="AddStudentForm">
                    <div class="modal-body">
                        <ul id="editform_errList"> </ul>
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" class="name form-control" name="name">
                        </div>
                        <div class="col-sm-6">
                            <label for="photo">Photo </label>
                            <input type="file" name="photo" class="photo form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="email" class="email form-control" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Phone</label>
                            <input type="number" class="phone form-control" name="phone">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Course</label>
                            <input type="text" class="course form-control" name="course">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary add_student">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Student Modal -->


    <!-- Edit Student Modal -->
    <div class="modal fade" id="EditStudentModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form  enctype="multipart/form-data" id="EditStudentForm">
                    @method('put')
                    {{-- @csrf --}}
                 
                    <div class="modal-body">
                        <ul id="updateform_errList"></ul>
                        <input type="hidden" id="edit_stu_id">
                        <div class="form-group mb-3">
                            <label for="">Name</label>
                            <input type="text" id="edit_name" name="name" class="name form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="photo">Photo </label>
                            <input type="file" id="edit_photo" name="photo" class="photo form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Email</label>
                            <input type="email" id="edit_email" name="email" class="email form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Phone</label>
                            <input type="number" id="edit_phone" name="phone" class="phone form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Course</label>
                            <input type="text" id="edit_course" name="course" class="course form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary update_student">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Edit Student Modal -->
    <!-- Delete Student Modal -->
    <div class="modal fade" id="DeleteStudentModel" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="display: none">
                    <input type="text" id="delete_stu_id">
                    <h5 class="modal-title" id="exampleModalLabel"> Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="model-body">
                    <h4>Are You sure ? want to delete this data ?</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_student_btn">Yes Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Student Modal -->
    <div class="container py-5">
        <div class="row">
            <div class="colo-md-12">
                <div id="success_message">

                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Student Data

                            <button type="button" class="btn btn-primary float-end btn-sm" data-bs-toggle="modal"
                                data-bs-target="#AddStudentModel">
                                Add Student
                            </button>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            fetchstudent();

            // Fetching Student jQ
            function fetchstudent() {
                $.ajax({
                    type: "get",
                    url: "fetch-students",

                    dataType: "json",
                    success: function(response) {
                        //    console.log(response.students); 
                        $('tbody').html("");
                        $.each(response.students, function(key, item) {
                            $('tbody').append(
                                '<tr>\
                                                                        <td>' + item.id +
                                '</td>\
                                                                        <td class="text-right"><img class="drag-handle" src="upload/' + item.photo + '" height="50" width="50" alt=""></td>\
                                                                        <td>' + item.name + '</td>\
                                                                        <td>' + item.email + '</td>\
                                                                        <td>' + item.phone + '</td>\
                                                                        <td>' + item.course + '</td>\
                                                                        <td><button type="button" value="' + item.id + '" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                                                        <td><button type="button" value="' + item.id + '"class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                                                                        </tr>'
                            );
                        });
                    }
                });
            }

            // Edit Student jQ

            $(document).on('click', '.edit_student', function(e) {
                e.preventDefault();
                var stu_id = $(this).val();
                // console.log(stu_id);
                $('#EditStudentModel').modal('show');
                $.ajax({
                    type: "get",
                    url: "edit-student/" + stu_id,
                    success: function(response) {
                        // console.log(response);
                        if (response.status == 404) {

                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        } else {
                            $('#EditStudentModel').modal('show');
                            $('#edit_stu_id').val(response.student.id);
                            $('#edit_name').val(response.student.name);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            // $('#edit_photo').val(response.student.photo);
                            $('#edit_course').val(response.student.course);
                        }
                    }
                });
            });
            $(document).on('submit', '#EditStudentForm', function(e) {
                e.preventDefault();
                var stu_id = $('#edit_stu_id').val();
                // console.log(stu_id);
                let formData = new FormData($('#EditStudentForm')[0]);
         
                // var data = {
                //     'name': $('#edit_name').val(),
                //     'email': $('#edit_email').val(),
                //     'phone': $('#edit_phone').val(),
                //     'course': $('#edit_course').val(),
                // }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    // var stu_id = $('#edit_stu_id').val();
                    type: "post",
                    url: "/update-student/" + stu_id,
                    data: formData,
                    // dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // console.log(response)
                        if (response.status == 400) {
                            $('#updateform_errList').html("");
                            $('#updateform_errList').addClass('alert alert-danger');

                            $.each(response.erros, function(key, err_values) {
                                $('#updateform_errList').append(
                                    '<li>' + err_values + '</li>');
                            });
                        } else if (response.status == 404) {
                            $('#updateform_errList').html("");
                            $('#success_message').addClass('alert alert-danger')
                            $('#success_message').text(response.message)
                        } else {
                            $('#updateform_errList').html("");
                            $('#success_message').html("");
                            $('#success_message').addClass('alert alert-success')
                            $('#success_message').text(response.message)
                            $('#EditStudentModel').modal('hide')
                            fetchstudent();
                        }
                    }

                });

            });
            

            // Adding Student jQ

            $(document).on('submit', '#AddStudentForm', function(e) {
                e.preventDefault();
                let formData = new FormData($('#AddStudentForm')[0]);


                // var data = {
                //     'name': $('.name').val(),
                //     'email': $('.email').val(),
                //     'phone': $('.phone').val(),
                //     'photo': $('.photo').val(),
                //     'course': $('.course').val(),
                // }
                // console.log(data);  
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "put",
                    url: "/students",
                    data: formData,
                    // dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        if (response.status == 400) {
                            $('#saveform_errList').html("");
                            $('#saveform_errList').addClass('alert alert-danger');

                            $.each(response.erros, function(key, err_values) {
                                $('#saveform_errList').append(
                                    '<li>' + err_values + '</li>');
                            });

                        } else {
                            $('#saveform_errList').html("");
                            $('#success_message').addClass('alert alert-success')
                            $('#success_message').text(response.message)
                            $('#AddStudentModel').modal('hide')
                            $('#AddStudentModel').find('input').val("");
                            fetchstudent();

                        }
                    }

                });

            });
            // Delete Student jQ
            $(document).on('click', '.delete_student', function(e) {
                e.preventDefault();
                var stu_id = $(this).val();
                // alert(stu_id)
                $('#delete_stu_id').val(stu_id);
                $('#DeleteStudentModel').modal('show');

            });

            $(document).on('click', '.delete_student_btn', function(e) {
                e.preventDefault();
                var stu_id = $('#delete_stu_id').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "delete-student/"  +stu_id,
                    success: function(response) {
                        // console.log(response);

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#DeleteStudentModel').modal('hide');
                        fetchstudent();
                    }
                });



            });
        });
    </script>
@endsection
