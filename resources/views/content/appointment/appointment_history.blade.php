@extends('template')
@if($user->role === "dokter")
   @include('content.appointment.dokter.appointment_history')
@elseif($user->role === "pegawai")
    @include('content.appointment.pegawai.appointment_history')
@endif
