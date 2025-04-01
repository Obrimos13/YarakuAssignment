@extends('books.layout')

@section('content')


    <div class="card mt-5">
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif
                <div class="d-grid gap-2 d-md-flex justify-content-md-left">
                    <form action="{{ route('books.download') }}" method="POST" enctype="multipart/form-data">
                        <input type="checkbox" id="title" name="title" value="title">
                        <label for="title">Include Title</label><br>
                        <input type="checkbox" id="author" name="author" value="author">
                        <label for="author">Include Author</label><br>
                        <label for="filetype">Export as:</label>
                        <select name="filetype" id="filetype">
                            <option value="csv">csv</option>
                            <option value="xml">xml</option>
                        </select>
                        <input type="submit" value="Submit">
                    </form>
                    <a class="btn btn-primary btn-sm" href="{{ route('books.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
                </div>



            <div  class="d-grid gap-2 d-md-flex justify-content-md-left">


            </div>
            <br>

        </div>
    </div>
