@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        {{-- Other dashboard content --}}

        {{-- CALENDAR START --}}
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-dark rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Calendar</h6>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#fullCalendarModal">Show All</a>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
        {{-- CALENDAR END --}}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="fullCalendarModal" tabindex="-1" aria-labelledby="fullCalendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullCalendarModalLabel">Full Calendar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="full-calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tempus Dominus Initialization for Full Calendar in Modal -->
    <script>
        $(function () {
            $('#calendar').datetimepicker({
                inline: true,
                format: 'L',
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
            });

            $('#fullCalendarModal').on('shown.bs.modal', function () {
                $('#full-calendar').datetimepicker({
                    inline: true,
                    format: 'L',
                    icons: {
                        time: 'far fa-clock',
                        date: 'far fa-calendar',
                        up: 'fas fa-arrow-up',
                        down: 'fas fa-arrow-down',
                        previous: 'fas fa-chevron-left',
                        next: 'fas fa-chevron-right',
                        today: 'far fa-calendar-check',
                        clear: 'far fa-trash-alt',
                        close: 'far fa-times-circle'
                    }
                });
            });
        });
    </script>
@endsection
















































{{-- @extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="bg-dark rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Full Calendar</h6>
            </div>
            <div id="full-calendar"></div>
        </div>
    </div>

    <!-- Tempus Dominus Initialization for Full Calendar -->
    <script>
        $(function () {
            $('#full-calendar').datetimepicker({
                inline: true,
                format: 'L',
                icons: {
                    time: 'far fa-clock',
                    date: 'far fa-calendar',
                    up: 'fas fa-arrow-up',
                    down: 'fas fa-arrow-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'far fa-calendar-check',
                    clear: 'far fa-trash-alt',
                    close: 'far fa-times-circle'
                }
            });
        });
    </script>
@endsection --}}
