<!DOCTYPE html>
<html lang="en">
@include('layouts.head', ['title' => 'Tests'])
<body style="background-color: #B6B6B6">

@include('layouts.header')
@include('layouts.navbar', ['activeBar' => 'tests'])

<div class="container-full-width">
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

<div class="container bg-white rounded mt-5 p-4">
    <div class="mb-3 row">
        <div class="col-sm-2">
            <a role="button" class="btn btn-secondary" href="{{route('tests..', ['professor', 'myTests'])}}">Back</a>
        </div>
        <div class="col-sm-8">
            <h2 class="text-center mb-4" style="color: #373737">Edit test</h2>
        </div>
        <div class="col-sm-2">
            {!! Form::open(['route' => ['tests.update', $test->id], 'method' => 'put']) !!}
            {!! Form::submit('Save', ['class' => 'btn btn-success float-right']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <div class="input-group @if($errors->has('name')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Name</label>
                </div>
                {!! Form::text('name', $test->name, ['class' => 'form-control', 'placeholder' => 'Enter name', 'maxlength'=>128]) !!}
            </div>
            @if ($errors->has('name'))
                <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
        <div class="col-sm-4">
            <div class="input-group @if($errors->has('max_duration')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Max duration</label>
                </div>
                {{ Form::input('time', 'max_duration', $test->max_duration, ['id' => 'max_duration', 'class' => 'form-control']) }}
            </div>
            @if ($errors->has('max_duration'))
                <span class="help-block">{!! $errors->first('max_duration') !!}</span>
            @endif
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="input-group @if($errors->has('available_from')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Available from</label>
                </div>
                {{ Form::input('dateTime-local', 'available_from', date('Y-m-d\TH:i', strtotime($test->available_from)), ['id' => 'available_from', 'class' => 'form-control']) }}
            </div>
            @if ($errors->has('available_from'))
                <span class="help-block">{!! $errors->first('available_from') !!}</span>
            @endif
        </div>
        <div class="col-sm-6">
            <div class="input-group @if($errors->has('available_to')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Available to</label>
                </div>
                {{ Form::input('dateTime-local', 'available_to', date('Y-m-d\TH:i', strtotime($test->available_to)), ['id' => 'available_to', 'class' => 'form-control']) }}
            </div>
            @if ($errors->has('available_to'))
                <span class="help-block">{!! $errors->first('available_to') !!}</span>
            @endif
        </div>
    </div>

    <div class="form-group mt-3 @if($errors->has('description')) has-error @endif">
        <label class="font-weight-bold" style="color: #373737">Description</label>
        {!! Form::textarea('description', $test->description, ['class' => 'form-control', 'placeholder' => 'Type description', 'maxlength'=>1024]) !!}
        @if ($errors->has('description'))
            <span class="help-block">{!! $errors->first('description') !!}</span>@endif
    </div>

    <h3><span style="color: #373737">Maximum points:</span> <span class="{{$test->max_points == 0 ? 'text-secondary' : 'text-success'}}">{{$test->max_points}}</span></h3>

    <div class="border rounded mt-4 p-3">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <h3 class="text-center mb-3" style="color: #373737">Categories</h3>
            </div>
            <div class="col-sm-2">
                <a href="{{ route('test.category.create',  $test->id )}}" class="btn btn-success float-right">Add</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mt-4">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Number of questions</th>
                    <th>Points per question</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @foreach($test_categories as $test_category)
                    <tr>
                        <td>

                            {{ $test_category->name }}
                        </td>
                        <td>
                            {{$test_category->pivot->number_of_questions}}
                        </td>
                        <td>
                            {{$test_category->max_points}}
                        </td>
                        <td>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('test.category.edit',  [$test->id, $test_category->id]) }}" class="btn btn-sm btn-success mr-2">Edit</a>

                                {!! Form::open(['route' => ['test.category.destroy', [$test->id, $test_category->id]], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-sm btn-danger', 'onclick' => 'return confirm(\'Are you sure you want to delete this category from test?\')']) !!}
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {!! Form::close() !!}
</div>

</body>
</html>
