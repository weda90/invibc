@extends('layouts.app')
 
@section('content')
	Halaman Master Company.
	{{ dump(url('/')) }}
	{{ dump(route('master.material')) }}
	{{ dump(Request::segments()) }}
	{{ dump(Request::url()) }}
	{{ dump(Request::is('master/*')) }}
	{{ dump(Request::is('master/material')) }}
	{{ dump(route::current()) }}
	{{ dump(Request::session()) }}
@endsection