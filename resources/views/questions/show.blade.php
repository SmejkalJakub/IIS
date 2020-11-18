<div class="border rounded mt-4 p-3">
    <h3 class="text-center mb-3" style="color: #373737">Questions</h3>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="search" style="max-width: 400px" placeholder="Search" name="search"/>
        </div>
        <div class="col-auto">
            <a href="{{ route('categories.questions.create', $category->id) }}" class="btn btn-block btn-success">Add</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mt-4">
            <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($questions as $question)
                <tr>
                    <td>
                        {{$question->name}}
                    </td>
                    <td>
                        @if($question->type_of_answer == 1)
                            fulltext
                        @else
                            test
                        @endif
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('categories.questions.edit', [$category->id, $question]) }}" class="btn btn-sm btn-success mr-2">Edit</a>

                            {!! Form::open(['route' => ['categories.questions.destroy', $category->id, $question->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this question?\')']) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

