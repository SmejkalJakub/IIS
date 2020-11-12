<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tests</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container">
    <div class="row">
        <div class="col">
            @if(Session::has('message'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session('message') }}
                </div>
            @endif

            @if(Session::has('delete-message'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session('delete-message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Test: {{$test->name}}

                        @if (!(Auth::user() == null || !Auth::user()->hasRole('profesor')))
                            <a href="{{ route('tests.edit', $test->id) }}"
                                class="btn btn-lg btn-primary align-middle float-right">Edit</a>
                        @endif
                        <a href="{{ route('sign_on_test.create', $test->id) }}"
                           class="btn btn-sm btn-primary">Sign on</a>
                    </h1>
                </div>


                <article>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-10 mx-auto">
                                <div>
                                    <h3>
                                        Description
                                    </h3>
                                    <h4>
                                        {{ $test->description }}
                                    </h4>
                                </div>

                                <div>
                                    <h3>
                                        Available from
                                    </h3>
                                    <h4>
                                        {{$test->available_from }}
                                    </h4>
                                </div>
                                <div>
                                    <h3>
                                        Available to
                                    </h3>
                                    <h4>
                                        {{$test->available_to}}
                                    </h4>
                                </div>
                                <div>
                                    <h3>
                                        Max duration
                                    </h3>
                                    <h4>
                                        {{$test->max_duration}}
                                    </h4>
                                </div>


                                <div class="card">
                                    <div class="card-header">
                                        <h2>
                                            Questions of category
                                        </h2>
                                    </div>
                                    <div class="card-body">
                                        <table style="text-align:center"
                                               class="sortable searchable table table-bordered mb-0">
                                            <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Category name</th>
                                                <th scope="col">Points per question</th>
                                                <th scope="col">Number of questions</th>
                                                <th scope="col">Total points from category</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <?php
                                            $total_max_test_points = 0;
                                            ?>
                                            @foreach($test_categories as $test_category)
                                                <tr>
                                                    <td>
                                                        {{ $test_category->id }}</a>

                                                    </td>

                                                    <td>
                                                        <?php
                                                        $cat = \App\Models\Category::where('id', '=', $test_category->category_id)->first();

                                                        $total_max_test_points = $total_max_test_points + ($cat->max_points * $test_category->number_of_questions);
                                                        ?>
                                                        {{ $cat->name }}
                                                    </td>
                                                    <td>
                                                        {{$cat->max_points}}
                                                    </td>
                                                    <td>
                                                        {{$test_category->number_of_questions}}
                                                    </td>
                                                    <td>
                                                        {{$cat->max_points * $test_category->number_of_questions}}
                                                    </td>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div>
                                    <h3>
                                        Maximum points per test
                                    </h3>
                                    <h2>
                                        {{$total_max_test_points}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <a href="{{ route('tests') }}"
                   class="btn btn-sm btn-primary">Back</a>

            </div>
        </div>
    </div>

</body>
</html>

