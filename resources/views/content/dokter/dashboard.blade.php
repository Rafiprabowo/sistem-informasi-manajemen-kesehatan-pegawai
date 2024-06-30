@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
<div>
    <h2>Notifikasi Appointment</h2>
    <ul>
        @forelse($unreadNotifications as $notification)
            <li>
                <strong>{{ $notification->data["employee_name"] }}</strong>
                pada tanggal <strong>{{ $notification->data["appointment_date"] }}</strong>
                dari <strong>{{ $notification->data["appointment_start_time"] }}</strong>
                sampai <strong>{{ $notification->data["appointment_end_time"] }}</strong>
                (<a href="{{ route('notifications.markAsRead', $notification->id) }}">Tandai sebagai dibaca</a>)
            </li>
        @empty
            <li>Tidak ada notifikasi belum dibaca</li>
        @endforelse
    </ul>
</div>
<div class="row row-deck row-cards">
    <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Appointment Pending</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalAppointmentsPending}}
                    </div>
                  </div>
                </div>
              </div>
     <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Appointment belum didiagnosa</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalAppointmentsBelumDidiagnosa}}
                    </div>
                  </div>
                </div>
              </div>

    <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Medical Check Up</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$totalMedicalCheckups}}
                    </div>
                  </div>
                </div>
              </div>
    <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <h2>Jadwal Reserved</h2>
                    </div>
                    <div class="h1 mb-3">
                        {{$schedulesReserved}}
                    </div>
                  </div>
                </div>
              </div>

</div>
@endsection
