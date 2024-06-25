@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content')
    <h2>Add Doctor Schedule</h2>
    <form class="card" id="createScheduleForm" action="{{route('doctor-schedules.store')}}" method="post">
        @csrf
        <div class="card-body">
            <input type="hidden" name="doctor_id" value="{{$user->doctor->id}}">
            <div class="mb-3">
                <label class="form-label ">Date</label>
                <div>
                    <input type="date" class="form-control" id="date" name="date">
                    <small class="form-hint">Require date</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Start Time:</label>
                <div>
                    <input type="time" class="form-control" id="start_time" name="start_time">
                    <small class="form-hint">Require Start time</small>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">End Time</label>
                <div>
                    <input type="time" class="form-control" id="end_time" name="end_time">
                    <small class="form-hint">Require end time</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function (){
            $('#createScheduleForm').submit(function (event) {
                event.preventDefault();
                $.ajax({
                   url:$(this).attr('action'),
                   type:'POST',
                   data:$(this).serialize(),
                   success: function (response){
                       alert('Doctor schedule saved successfully.')
                       window.location.href="{{route('doctor-schedules.index')}}"
                   },
                   error: function (xhr) {
                       if(xhr.status === 422){
                           let errors = xhr.responseJSON.message;
                           let errorMessages = '';
                           $.each(errors, function (key, value){
                               errorMessages += value[0] + '\n';
                           })
                           alert(errorMessages)
                       }
                    }
               })
            })
        })
    </script>
@endsection
