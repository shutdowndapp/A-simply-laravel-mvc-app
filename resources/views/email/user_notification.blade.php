@extends('layouts.master')

@section('content')
    <h1> 3Q for creating a Quote {{ $name }} </h1>
    <p> please register here <a href="{{ route('mail_callback',['author_name' => $name]) }}">link</a> </p>
@endsection