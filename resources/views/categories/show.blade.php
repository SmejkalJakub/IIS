<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

@include('layouts.navbar', ['activeBar' => 'categories'])

<div class="overlay"></div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>
                        Category: {{$category->name}}
                        <a href="{{ route('categories.edit', $category->id) }}"
                           class="btn btn-sm btn-primary">Edit</a>
                    </h1>
                </div>
                <article>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-md-10 mx-auto">

                                <div>
                                    <h3>
                                        Points per question
                                    </h3>
                                    <h4>
                                        {{$category->max_points}}
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
                                                <th scope="col">Name</th>
                                                <th scope="col">Type of answer</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($questions as $question)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('categories.questions.show', [$category->id, $question->id]) }}">{{ $question->id }}</a>

                                                    </td>
                                                    <td>
                                                        {{$question->name}}
                                                    </td>
                                                    <td>
                                                        @if($question->type_of_answer == 1)
                                                            open
                                                        @else
                                                            abcd
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </article>
                <a href="{{ route('categories') }}"
                   class="btn btn-sm btn-primary">Back</a>
            </div>
        </div>
    </div>

</body>
</html>

