<script type="text/javascript">
    startTimer('{{$divId}}', 0)

    function startTimer(element, time) {

        timeNow = new Date();
        timeNow.setHours(timeNow.getHours() - 1);

        testEnd = Date.parse('{{$instance->test->available_to}}');
        testEndDate = new Date(testEnd);
        testEndDate.setHours(testEndDate.getHours() - 1);

        instanceStart = Date.parse('{{$instance->created_at}}');
        instanceStartDate = new Date(instanceStart);

        durationString = '{{$instance->test->max_duration}}';
        durationArray = durationString.split(":");

        hours = parseInt(durationArray[0]);
        minutes = parseInt(durationArray[1]) + (hours * 60);
        seconds = minutes * 60;

        timeToEnd = ((testEndDate.getTime()) - (instanceStartDate.getTime())) / 1000;

        if(timeToEnd < seconds)
        {
            seconds = timeToEnd;
        }
        timeElapsed = Math.floor(((timeNow.getTime()) - (instanceStartDate.getTime())) / 1000);

        seconds = seconds - timeElapsed;

        if(seconds <= 0)
        {
            window.location.href = "{{ route('test.finish', [$instance->id])}}";
        }

        var hours = Math.floor(seconds / 3600);
        var minutes = Math.floor((seconds % 3600) / 60);
        var seconds = (seconds % 3600) % 60;

        if (hours < 10) {
            hours = '0' + hours;
        }

        if (minutes < 10) {
            minutes = '0' + minutes;
        }

        if (seconds < 10) {
            seconds = '0' + seconds;
        }

        var e = document.getElementById(element);

        if (e) {
            e.innerHTML = hours + ':' + minutes + ':' + seconds;
        }

        setTimeout(
            function(x) {
                return function() { startTimer(element, x+1); }
            }(time),
            1000
        );
    }
</script>
