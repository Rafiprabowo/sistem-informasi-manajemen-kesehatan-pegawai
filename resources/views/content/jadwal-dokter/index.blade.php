@extends('template')

@if($user->role === "dokter")
    @section('aside')
        @include('partials.aside.dokter')
    @endsection
    @section('content-header')
        @include('partials.content-header.jadwal-dokter.index')
    @endsection
@section('content')
    <div class="col-md-8">
    <div class="card">
        <div class="card-body">
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    </div>
                    <div>
                        {{session('success')}}
                    </div>
                    <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                </div>
            @endif
            <div id="table-default" class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-tbody">
                    @if($user->doctor->schedules)
                        @foreach($user->doctor->schedules as $index => $schedule)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$schedule->available_time}}</td>
                                <td>
                                    @if($schedule->is_available)
                                        Jadwal tersedia
                                    @else
                                    Jadwal tidak tersedia
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
@endsection
@endif
