<h3 class="mb-4"><span style="color: #373737">Maximum points:</span> <span class="{{($total_max_test_points == 0) ? 'text-secondary' : 'text-success'}}">{{$total_max_test_points}}</span></h3>
<h4 class="mb-4"><span style="color: #373737">Number of tasks:</span> <span class="{{($total_num_of_questions == 0) ? 'text-secondary' : 'text-success'}}">{{$total_num_of_questions}}</span></h4>
<h5><span style="color: #373737">Author:</span> <span class="font-weight-normal">{{$test->creator->first_name}} {{$test->creator->surname}}</span></h5>
<h5><span style="color: #373737">Max duration:</span> <span class="font-weight-normal">{{$test->max_duration}}</span></h5>
<h5><span style="color: #373737">Available from:</span> <span class="font-weight-normal">{{$test->available_from}}</span></h5>
<h5><span style="color: #373737">Available to:</span> <span class="font-weight-normal">{{$test->available_to}}</span></h5>
<h4 class="mt-4" style="color: #373737">Description</h4>
<p>{{$test->description}}</p>
