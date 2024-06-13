@extends('template')
@section('aside')
    @include('partials.aside.dokter')
@endsection
@section('content-header')
    @include('partials.content-header.appointment.index')
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
                        <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Phone</th>
                        <th>Appointment time</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($user->doctor->appointments)
                        @foreach($user->doctor->appointments as $index => $appointment)
                            <tr>
                                <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                                <td><span class="text-muted">{{$index + 1}}</span></td>
                                <td><a href="#" class="text-reset" tabindex="-1">{{$appointment->name}}</a></td>
                                <td>{{$appointment->address}}</td>
                                <td>{{$appointment->phone}}</td>
                                <td>{{$appointment->appointment_time}}</td>
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
                                                  <a id="diagnosa" class="dropdown-item" data-id="{{$appointment->id}}">Diagnosa</a>
                                              @elseif($appointment->status === "pending")
                                                  <a id="approve" class="dropdown-item" data-id="{{$appointment->id}}">Approve</a>
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
@endsection

@section('script')
    <script>
        $(document).ready( function (){
            $('#approve').click(function (){
                // get appointment id
                var appointmentId = $(this).data('id')
                $.ajax({
                    url:'/api/approve-appointment/'+appointmentId,
                    type: 'POST',
                    data:{
                        _token:'{{csrf_token()}}'
                    },
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
