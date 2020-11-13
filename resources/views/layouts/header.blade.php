<div class="pt-2 pl-3 pb-1 pr-3 bg-white">
    <div class="row">
        <div class="col">
            <h1 class="text-capitalize text-success">easy tests</h1>
        </div>
        @if(Auth::user() != null)
            <div class="col-auto align-self-center">
                <button class="btn btn-success font-weight-bold float-right rounded">Log out</button>
            </div>
        @endif
    </div>
</div>
