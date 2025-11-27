<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
    <div class="container">
        @include('partial.sign')
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <script>
        function hideValidationError(event) {
            let errorSpan = event.target.parentNode.querySelector('span.text-danger');

            if (errorSpan) {
                errorSpan.style.display = 'none'; // hoặc visibility: hidden
            }
        }


        function setupValidationClearEvents() {
            const fields = document.querySelectorAll('input, select');

            fields.forEach(function (field) {
                // Ẩn lỗi khi input thay đổi hoặc focus
                if (field.tagName.toLowerCase() === 'select') {
                    field.addEventListener('change', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                } else {
                    field.addEventListener('input', hideValidationError);
                    field.addEventListener('focus', hideValidationError);  // thêm focus
                }
            });
        }

        document.addEventListener('DOMContentLoaded', setupValidationClearEvents);
    </script>


</body>

</html>