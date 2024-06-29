@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <h2>Tambah Jadwal Dokter</h2>
    <div class="div">
        <a href="{{route('doctor-schedules.index')}}" class="btn btn-secondary mb-3">Kembali</a>
    </div>
    <form class="card" action="{{route('doctor-schedules.store')}}" method="post">
        @csrf
        <div class="card-body">
            <input type="hidden" name="doctor_id" value="{{$user->doctor->id}}">
            <div class="mb-3">
                <label class="form-label ">Tanggal</label>
                <div>
                    <input type="date" class="form-control" id="date" name="date">
                    <small class="form-hint">Require date</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Waktu Mulai:</label>
                <div>
                    <input type="time" class="form-control" id="start_time" name="start_time">
                    <small class="form-hint">Require Start time</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Waktu Selesai</label>
                <div>
                    <input type="time" class="form-control" id="end_time" name="end_time">
                    <small class="form-hint">Require end time</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection

