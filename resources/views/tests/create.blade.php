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
        <div class="col-sm-4">
            <a role="button" class="btn btn-secondary" href="{{route('tests..', ['professor', 'myTests'])}}">Back</a>
        </div>
        <div class="col-sm-4">
            <h2 class="text-center mb-4" style="color: #373737">Create test</h2>
        </div>
        <div class="col-sm-4">
            {!! Form::open(['route' => ['tests-store'], 'method' => 'put']) !!}
            {!! Form::submit('Create', ['class' => 'btn btn-success float-right']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-9">
            <div class="input-group @if($errors->has('name')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Name</label>
                </div>
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter name', 'maxlength'=>128]) !!}
                @if ($errors->has('name'))
                    <span class="help-block">{!! $errors->first('name') !!}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group @if($errors->has('max_duration')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Max duration</label>
                </div>
                {{ Form::input('time', 'max_duration', null, ['id' => 'max_duration', 'class' => 'form-control']) }}
                @if ($errors->has('max_duration'))
                    <span class="help-block">{!! $errors->first('max_duration') !!}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-sm-6">
            <div class="input-group @if($errors->has('available_from')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Available from</label>
                </div>
                {{ Form::input('dateTime-local', 'available_from', date('Y-m-d\TH:i', strtotime(now())), ['id' => 'available_from', 'class' => 'form-control']) }}
                @if ($errors->has('available_from'))
                    <span class="help-block">{!! $errors->first('available_from') !!}</span>
                @endif
            </div>
        </div>
        <div class="col-sm-6">
            <div class="input-group @if($errors->has('available_to')) has-error @endif">
                <div class="input-group-prepend">
                    <label class="input-group-text">Available to</label>
                </div>
                {{ Form::input('dateTime-local', 'available_to', date('Y-m-d\TH:i', strtotime(now())), ['id' => 'available_to', 'class' => 'form-control']) }}
                @if ($errors->has('available_to'))
                    <span class="help-block">{!! $errors->first('available_to') !!}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="form-group mt-3 @if($errors->has('description')) has-error @endif">
        <label class="font-weight-bold" style="color: #373737">Description</label>
        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Type description', 'maxlength'=>1024]) !!}
        @if ($errors->has('description'))
            <span class="help-block">{!! $errors->first('description') !!}</span>@endif
    </div>

    {!! Form::close() !!}
</div>

</body>
</html>


<script>
let create = false;
// Warning before leaving the page (back button, or outgoinglink)
window.onbeforeunload = function () {
   if(!create) {
       create = false;
       return "Do you really want to discard changes?"
   }
};

function setValue() {
   create = true;
}
</script>
