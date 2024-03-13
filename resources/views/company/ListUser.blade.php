@extends('layouts.companyapp')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">บัญชีผู้ใช้ 
                        @if (request()->type == 'leader')
                        :: เจ้าหน้าที่/หัวหน้าฝ่าย
                        @elseif (request()->type == 'user')
                        :: ผู้ใช้ทั่วไป
                        @endif
                </div>
                    <div class="card-body">
<p>
    <a class="btn btn-outline-success" href="{{route('company_newuser',['type'=>request()->type])}}" role="button">เพิ่มบัญชีใหม่</a>
</p>

                        <table class="table table-responsive">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th>Username</th>
                                <th scope="col">ชื่อ-นามสกุล</th>
                                <th scope="col">ตั้งค่า</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($listuser as $item)
                              <tr>
                                <th scope="row">1</th>
                                <td>{{$item->email}}</td>
                                <td>{{$item->name}}</td>
                                <td> 
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{route('company_edituser',['id'=>$item->user_id])}}" class="btn btn-outline-primary">แก้ไข</a>
                                        <a href="#" class="btn btn-outline-danger">ลบ</a>
                                    </div>                                   
                                </td>                             
                              </tr>
                              @endforeach
                              
                             
                            </tbody>
                          </table>

                      

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
