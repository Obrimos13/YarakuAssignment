@extends('books.layout')

@section('content')


    <div class="card mt-5">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
                <div class="d-grid gap-2 d-md-flex justify-content-md-left">
                    <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>


            <div  class="d-grid gap-2 d-md-flex justify-content-md-left">


            </div>
            <br>

        </div>
    </div>
