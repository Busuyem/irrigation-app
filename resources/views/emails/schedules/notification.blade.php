@component('mail::message')

The schedule just got created for the zone {{ $schedule->zone['name'] }};
<p>Start time: {{ $schedule['start_time'] }}</p>
<p>End time: {{ $schedule['duration'] }} days</p>




@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
