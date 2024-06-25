@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointments</h3>
            </div>
            <div class="table-responsive">
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
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->doctor->appointments)
                        @foreach($user->doctor->appointments as $index => $appointment)
                            <tr>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td>{{$appointment->employee->user->first_name}} {{$appointment->employee->user->last_name}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->date)->format('d-m-Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->start_time)->format('H:i')}}</td>
                                <td>{{\Carbon\Carbon::parse($appointment->end_time)->format('H:i')}}</td>
                                <td>{{$user->first_name}} {{$user->last_name}} {{$user->doctor->speciality->name ?? ''}}</td>
                                <td>{{$appointment->note}}</td>
                                <td>
                                    <span class="badge {{$appointment->status === 'pending' ? 'bg-warning':($appointment->status === 'approved' ? 'bg-success' :($appointment->status === 'rejected' ? 'bg-danger':'bg-secondary'))}} me-1">
                                        {{$appointment->status}}
                                    </span>
                                </td>
                                 <td class="text-end">
                                        <span class="dropdown">
                                          <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                          <div class="dropdown-menu dropdown-menu-end">
                                              @if($appointment->status === "approved")
                                                  <a href="{{route('diagnose.create' , $appointment->id)}}" class="dropdown-item"  >Diagnosa</a>
{{--                                                  <a href="{{route('cancel-appointment', $appointment->id)}}" id="cancel" class="dropdown-item">Cancel</a>--}}
                                              @elseif($appointment->status === "pending")
                                                  <a href="{{route('approve-appointment', $appointment->id)}}" id="approve" class="dropdown-item">Approve</a>
                                              @endif
                                              <a id="delete" class="dropdown-item" data-id="{{$appointment->id}}">Delete</a>
                                          </div>
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
    </div>
@endsection

@section('script')
    <script>
        $(document).ready( function (){
             var token = $("meta[name='csrf-token']").attr("content");
            $('#approve').click(function (){
                $.ajax({
                    url:$(this).attr('href'),
                    type: 'GET',
                    success: function (response){
                        if(response.success){
                            location.reload()
                            alert('Appointment approved successfully!')
                        }else {
                            alert('Failed to approve appointment')
                        }
                    },
                    error:function (xhr){
                        alert('An error occured: ' + xhr.responseText)
                    }
                });
            });
            $('#cancel').click(function (){
                $.ajax({
                    url: $(this).attr('href'),
                    type: 'GET',
                    success: function (response){
                        if(response.success){
                            location.reload()
                            alert('Appointment cancelled successfully!')
                        }else {
                            alert('Failed to cancel appointment')
                        }
                    },
                    error: function (xhr){
                        alert('An error occured: ' + xhr.responseText)
                    }
                })
            })
            $('#delete').click(function(){
                let appointmentId = $(this).data('id')
                if(confirm('Are you sure want to delete this appointment?')){
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
