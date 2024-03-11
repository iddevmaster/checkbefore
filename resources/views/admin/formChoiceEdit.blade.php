@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">แก้ไขข้อตรวจ</div>

                <div class="card-body">
                   
                    <form action="{{route('admin_ChoiceUpdate',['id'=>request()->id])}}" method="post">
                        @csrf
                        @foreach ($ChoiceEdit as $item)
                        <p>หมวดหมู่ :: {{$item->category_name}}</p>
                        <input type="hidden" name="cate_id" value="{{$item->category_id}}">
                        <div class="mb-3">
                          <label for="choiceEdit" class="form-label">ข้อตรวจ</label>
                          <input type="text" class="form-control" id="choiceEdit" name="choiceEdit"
                          value="{{$item->form_choice}}">                       
                        </div>
                        @endforeach
                        <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                      </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
