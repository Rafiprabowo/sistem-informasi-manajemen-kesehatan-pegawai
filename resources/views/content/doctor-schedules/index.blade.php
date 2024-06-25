@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <h2>Doctor Schedules</h2>
    <a href="{{route('doctor-schedules.create')}}" class="btn btn-primary mb-3">
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
                        <th>Date</th>
                        <th>Doctor</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($schedule->date)->format('d-m-Y')}}</td>
                            <td>{{ $schedule->doctor->user->first_name }} {{ $schedule->doctor->user->last_name}}. {{ $schedule->doctor->speciality->name ?? '' }}</td> <!-- Doctor's name -->
                            <td>{{\Carbon\Carbon::parse($schedule->start_time)->format('H:i')}}</td>
                            <td>{{\Carbon\Carbon::parse($schedule->end_time)->format('H:i')}}</td> <!-- End Time -->
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
                    <p class="m-0 text-muted">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
                    <ul class="pagination m-0 ms-auto">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                          <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                          prev
                        </a>
                      </li>
                      <li class="page-item"><a class="page-link" href="#">1</a></li>
                      <li class="page-item active"><a class="page-link" href="#">2</a></li>
                      <li class="page-item"><a class="page-link" href="#">3</a></li>
                      <li class="page-item"><a class="page-link" href="#">4</a></li>
                      <li class="page-item"><a class="page-link" href="#">5</a></li>
                      <li class="page-item">
                        <a class="page-link" href="#">
                          next <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
    @endif
@endsection
