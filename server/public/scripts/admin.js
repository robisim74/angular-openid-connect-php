$(function () {
    $("#users-table").DataTable({
        "order": [[0, "asc"]],
        "columnDefs": [
            {
                "targets": [0]
            },
            {
                "targets": [1]
            },
            {
                "targets": [2]
            },
            {
                "targets": [3],
                "orderable": false
            },
            {
                "targets": [4],
                "orderable": false,
                "searchable": false
            },
            {
                "targets": [5],
                "orderable": false,
                "searchable": false
            }
        ],
        "scrollY": '50vh',
        "paging": true,
        "info": true
    });

    // jQuery validation.
    $("#registerForm").validate(
        {
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                }
            },
            highlight: function (element) {
                $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
            },
            errorElement: "div",
            errorClass: 'invalid-feedback'
        }
    );

    $("#editForm").validate(
        {
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-control').removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('is-invalid').addClass('is-valid');
            },
            errorElement: "div",
            errorClass: 'invalid-feedback'
        }
    );

    window.addEventListener('load', function () {
        var registerForm = document.getElementById('registerForm');
        registerForm.addEventListener('submit', function (event) {
            if (registerForm.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            registerForm.classList.add('was-validated');
        }, false);
        var editForm = document.getElementById('editForm');
        editForm.addEventListener('submit', function (event) {
            if (editForm.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            editForm.classList.add('was-validated');
        }, false);
    }, false);

    var element = document.getElementById("menu-admin");
    element.setAttribute("class", "active");
});