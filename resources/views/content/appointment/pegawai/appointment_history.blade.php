@extends('template')
@section('aside')
    @include('partials.aside.pegawai')
@endsection
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointments</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap datatable">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Appointment Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Nama Dokter</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->employee->appointments)
                        @foreach($user->employee->appointments as $index => $appointment)
                            <tr>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->date)->format('d-m-Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->start_time)->format('H:i')}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->end_time)->format('H:i')}}</td>
                                <td>{{$appointment->doctor->user->first_name}} {{$appointment->doctor->user->last_name}}</td>
                                <td>{{$appointment->note}}</td>
                                <td>
                                    <span class="badge {{$appointment->status === 'pending' ? 'bg-warning':($appointment->status === 'approved' ? 'bg-success' :($appointment->status === 'rejected' ? 'bg-danger':'bg-secondary'))}} me-1">
                                        {{$appointment->status}}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>data tidak tersedia</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready( function (){

            $('#delete').click(function(){
                var appointmentId = $(this).data('id')
                if(confirm('Are you sure wanto delete this appointment?')){
                    $.ajax({
                        url:'/api/delete-appointment/'+appointmentId,
                        type:'DELETE',
                        data:{
                            _token:'{{csrf_token()}}'
                        },
                        success:function (response){
                            if(response.success){
                                location.reload()
                                alert('Appopintment deleted successfully!')
                            }else {
                                alert('Failed to delete appointment')
                            }
                        },
                        error: function (xhr){
                            alert('An error occured : ' + xhr.responseText)
                        }

                    })
                }
            })
        });
    </script>
@endsection
