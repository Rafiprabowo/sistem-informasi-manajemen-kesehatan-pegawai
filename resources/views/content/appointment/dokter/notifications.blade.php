@extends('template')
@section('content')
    <ul>
        @foreach(\Illuminate\Support\Facades\Auth::user()->notifications as $notification)
            <li>{{$notification->data['appointment_id']}} dikirim pada {{$notification->data['appointment_time']}}</li>
        @endforeach
    </ul>
@endsection
