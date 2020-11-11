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


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div>
                    <div>
                        <h3>
                            Name
                        </h3>
                        <h4>
                            {{ $question->name }}
                        </h4>
                    </div>
                    <div>
                        <h3>
                            Task
                        </h3>
                        <h4>
                            {{$question->task}}
                        </h4>
                    </div>
                    <div>
                        <h3>
                            Image
                        </h3>
                    </div>

                    <div>
                        <img
                            src="{{'http://localhost/' . $question->image}}"
                            onerror="this.onerror=null;this.src='https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTOYeuoelhM2iWeIjc--_YW3ZlqrFaIHOCqyQ&usqp=CAU';"
                            style="max-height: 150px; max-width: 150px">
                    </div>


                    <div>
                        <h3>
                            Type
                        </h3>
                        <h4>
                            @if($question->type_of_answer == 1)
                                open
                            @else
                                abcd
                            @endif
                        </h4>
                    </div>
                    <div>
                        <h3>
                            Right answer
                        </h3>
                        <h4>
                            {{$question->right_answer}}
                        </h4>
                    </div>
                    @if($question->type_of_answer == 0)
                        <div>
                            <h3>
                                Option 1
                            </h3>
                            <h4>
                                {{$question->option_1}}
                            </h4>
                        </div>
                        <div>
                            <h3>
                                Option 2
                            </h3>
                            <h4>
                                {{$question->option_2}}
                            </h4>
                        </div>
                        <div>
                            <h3>
                                Option 3
                            </h3>
                            <h4>
                                {{$question->option_3}}
                            </h4>
                        </div>
                        <div>
                            <h3>
                                Option 4
                            </h3>
                            <h4>
                                {{$question->option_4}}
                            </h4>
                        </div>

                    @endif
                    <a href="{{ route('categories.show', $category->id) }}"
                       class="btn btn-sm btn-primary">Back</a>
                    <a href="{{ route('categories.questions.edit', [$category->id, $question->id]) }}"
                       class="btn btn-sm btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<script type="text/javascript">

    function PreviewImage(orderOfImage, uploadPreviewOrder) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById(orderOfImage).files[0]);

        oFReader.onload = function (oFREvent) {
            document.getElementById(uploadPreviewOrder).src = oFREvent.target.result;
        };
    }

</script>

