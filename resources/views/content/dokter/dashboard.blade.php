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
@endsection
