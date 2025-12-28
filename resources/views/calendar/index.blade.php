<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                {{ __('Room Booking Calendar') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-full px-4 mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-900 sm:rounded-lg">
                <div class="p-6">
                    <div class="min-w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
        <style>
            #calendar {
                min-height: 600px;
            }
            .fc-event {
                cursor: pointer;
                padding: 2px 4px;
            }
        </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Tampilkan bulan untuk melihat tanggal
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events),
                eventDidMount: function(info) {
                    // Beri warna berdasarkan status
                    if (info.event.extendedProps.status) {
                        const status = info.event.extendedProps.status.toLowerCase();
                        if (status === 'pending') {
                            info.el.style.backgroundColor = '#9e8403';
                            info.el.style.borderColor = '#9e8403';
                        } else if (status === 'approved') {
                            info.el.style.backgroundColor = '#0b855c';
                            info.el.style.borderColor = '#0b855c';
                        } else if (status === 'rejected' || status === 'cancelled') {
                            info.el.style.backgroundColor = '#a12f2f';
                            info.el.style.borderColor = '#a12f2f';
                        }
                    }

                    // Tambahkan tooltip dengan detail
                    let tooltipContent = info.event.title;
                    if (info.event.extendedProps.purpose) {
                        tooltipContent += '\nPurpose: ' + info.event.extendedProps.purpose;
                    }
                    if (info.event.extendedProps.booking_date) {
                        tooltipContent += '\nDate: ' + info.event.extendedProps.booking_date;
                    }
                    info.el.title = tooltipContent;
                },
                eventClick: function(info) {
                    // Tampilkan modal atau alert dengan detail
                    alert(
                        'Room: ' + info.event.extendedProps.room + '\n' +
                        'User: ' + info.event.extendedProps.user + '\n' +
                        'Status: ' + info.event.extendedProps.status + '\n' +
                        'Purpose: ' + info.event.extendedProps.purpose + '\n' +
                        'Booking Date: ' + info.event.extendedProps.booking_date
                    );
                }
            });
            calendar.render();
        });
    </script>
@endpush
</x-app-layout>
