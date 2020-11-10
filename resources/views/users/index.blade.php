<!DOCTYPE html>
<html lang="en">
<head>
  <title>Users</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

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
                            type : 'get',
                            url : '{{URL::to('search')}}',
                            data:{'search':$value},
                            success:function(data) {
                                $('tbody').html(data);
                            }
                    });
                }
            </script>
            <script type="text/javascript">
                $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
            </script>
        </tbody>

        </table>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Are you sure?");
        });
    </script>
</div>
</html>

