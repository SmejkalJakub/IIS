<tbody>
    <?php
        $searchType .= "-search"
    ?>

    <script type="text/javascript">
        $('#search').on('keyup', search);
        $(document).ready(search);

        function search() {
            let $value = $(this).val();
            $.ajax({
                type: 'get',
                url: "{{URL::to($searchType)}}",
                data: {'search': $value, 'role' : '{{$role ?? ''}}', 'filter' : '{{$filter ?? ''}}'},
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
