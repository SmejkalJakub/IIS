<div class="container-fullwidth bg-white pl-3 pr-3 pb-1 pt-1">
    <div>
        <div class="row">
            <div class="col align-self-center">
                <h1><span class="text-success">Easy</span><span class="text-secondary">Tests</span></h1>
            </div>
            @if(Auth::user() != null)
                <div class="col-auto align-self-center">
                    <a role="button" class="btn btn-success font-weight-bold float-right rounded" href="{{route('logout')}}">Log out</a>
                </div>
            @endif
        </div>
    </div>
</div>
