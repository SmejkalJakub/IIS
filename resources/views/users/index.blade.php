<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Users'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'users'])

<div class="container bg-white rounded mt-5 p-4">
    <h2 class="mb-3 text-center" style="color: #373737">Users</h2>
    <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>

    <div class="table-responsive">
        <table class="table table-hover mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>E-mail</th>
                <th>Role</th>
                <th></th>
            </tr>
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
    </div>

    <script>
        $(".delete").on("submit", function () {
            return confirm("Are you sure?");
        });
    </script>
</div>

</body>
</html>

