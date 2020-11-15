<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Users'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container">
    <div class="form-group">
        <label>Search</label>
        <label for="search"></label><input type="text" class="form-controller" id="search" name="search"/>
    </div>
    <div class="card-body">
        <table style="text-align:center" class="sortable searchable table table-bordered mb-0">
            <thead>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col"></th>
            <th scope="col"></th>
            </thead>

            <tbody>
            <script type="text/javascript">
                $('#search').on('keyup', search);
                $(document).ready(search);

                function search() {
                    let $value = $(this).val();
                    $.ajax({
                        type: 'get',
                        url: '{{URL::to('search')}}',
                        data: {'search': $value},
                        success: function (data) {
                            $('tbody').html(data);
                        }
                    });
                }
            </script>
            <script type="text/javascript">
                $.ajaxSetup({headers: {'csrftoken': '{{ csrf_token() }}'}});
            </script>
            </tbody>

        </table>

        <script>
            $(".delete").on("submit", function () {
                return confirm("Are you sure?");
            });
        </script>
    </div>
</div>
</body>
</html>

