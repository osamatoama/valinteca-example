@extends('layouts.app')


@section('content')
    <div class="container">
        <form class="mt-3" method="post" action="{{route('pdf.demo.stream')}}">
            {{csrf_field()}}
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">عنوان المقال</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="title" placeholder="عنوان المقال" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">الملخص</label>
                <div class="col-sm-10">
                    <textarea name="abstract" placeholder="الملخص" class="form-control" required> </textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">البحث</label>
                <div class="col-sm-10">
                    <textarea rows="10" name="search" placeholder="البحث" class="form-control" required> </textarea>
                </div>
            </div>
            <input type="submit" value="اضافة" class="btn btn-success">
        </form>
    </div>
@endsection
