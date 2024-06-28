@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <h2>Doctor Schedules</h2>
    <a href="{{ route('doctor-schedules.create') }}" class="btn btn-primary mb-3">
        Add Schedule
    </a>
    @if($schedules->isEmpty())
        <p>No schedules found.</p>
    @else
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jadwal Dokter</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Dokter</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }}</td>
                                    <td>{{ $schedule->doctor->user->first_name }} {{ $schedule->doctor->user->last_name }}. {{ $schedule->doctor->speciality->name ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                    <td>
                                        <span class="badge {{ $schedule->status === 'available' ? 'bg-success' : ($schedule->status === 'reserved' ? 'bg-warning' : 'bg-danger') }}">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                    <td class="text-sm-center">
                                        <span class="dropdown">
                                            <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="{{ route('doctor-schedules.edit', $schedule->id) }}">
                                                    Edit
                                                </a>
                                                <form class="dropdown-item" action="{{ route('doctor-schedules.destroy', $schedule->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex align-items-center">
                    <!-- Pagination Links -->
                    <div class="pagination-container">
                        {{ $schedules->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
