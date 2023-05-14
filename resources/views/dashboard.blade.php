@extends('layouts.app')

@section('content')
    <div class="mt-5 d-flex">
        <div class="next-match-container">
            <h3>Next Match:</h3>
            @if(isset($nextMatch))
                <div class="next-match-card">
                    <section class="next-match-date">
                        <time datetime="{{ $nextMatch->date. ' '. $nextMatch->time }}">
                            <span>{{ $nextMatch->date->day }}</span>
                            <span>{{ $nextMatch->date->monthName }}</span>
                            <span>{{ $nextMatch->time }}</span>
                        </time>
                    </section>
                    <section class="card-cont">
                        <h5 class="card-title text-center fw-bold">{{ $nextMatch->homeTeam->name }}</h5>
                        <h5 class="card-title text-center fw-semibold my-2">VS</h5>
                        <h5 class="card-title text-center fw-bold">{{ $nextMatch->awayTeam->name }}</h5>
                    </section>
                </div>
            @endif
        </div>
        <div class="card w-100 p-3">
            <div id="calendar" class="w-100"></div>
        </div>

    </div>

    <div class="mt-2 match-statistics">
        <div class="card p-3 col-6">
            <canvas id="matchStatisticsChart"></canvas>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js" referrerpolicy="no-referrer"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function dayHeaderFormatUsingMoment(info) {
                return moment(info.date.marker).format("ddd, DD/MM/YYYY");
            }

            let calendarEl = document.getElementById('calendar');
            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                height: '500px',
                timeZone: 'UTC',
                dayHeaderFormat: dayHeaderFormatUsingMoment,
                slotMinTime: '8:00:00',
                slotMaxTime: '23:00:00',
                expandRows: true,
                allDaySlot: false,
                events: @json($matches),
                eventClassNames: function (arg) {
                    console.log(arg);
                    if (arg.isFuture) {
                        return [ 'future-event' ]
                    } else {
                        return [ 'past-event' ]
                    }
                }
            });

            calendar.render();

            /* Initialise the match statistics chart */
            let matchStatistics =  {{ Js::from($matchStatistics) }};
            console.log(matchStatistics)
            const data = {
                labels: ['Match Statistics'],
                datasets: [{
                    label: 'Home Matches',
                    backgroundColor: '#72A0C1',
                    data: [matchStatistics.home_matches],
                },
                {
                    label: 'Home Victories',
                    backgroundColor: '#018749',
                    data: [matchStatistics.home_victories],
                },
                {
                    label: 'Away Matches',
                    backgroundColor: '#72A0C1',
                    data: [matchStatistics.home_matches],
                },
                {
                    label: 'Away Victories',
                    backgroundColor: '#018749',
                    data: [matchStatistics.home_victories],
                }
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    maintainAspectRatio: false,
                }
            };

            new Chart(
                document.getElementById('matchStatisticsChart'),
                config
            );
        });
    </script>
@endpush
