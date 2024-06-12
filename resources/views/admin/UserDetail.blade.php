@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @foreach ($userdetail as $row)            
                <div class="card-header">รายละเอียดหน่วยงาน</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            @if ($row->user_logo == '0')
                            <img src="{{ asset('upload/no_img.jpg') }}" width="80px" alt="">
                            @else
                            <img src="{{asset($row->user_logo)}}" class="img-thumbnail" width="80px">
                            @endif
                            
                        </div>
                        <div class="col-md-9">
                            <h5 class="card-title">{{$row->fullname}}</h5>
                            <a href="{{route('admin_AgentEdit',['id'=>request()->id])}}" class="btn btn-sm btn-secondary">แก้ไขข้อมูล</a>
                        </div>
                    
                    
                    </div>
                   <hr>
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{route('admin_CreateAgentUser',['id'=>request()->id])}}" class="btn btn-outline-primary" >สร้างผู้ใช้ในหน่วยงาน </a>
                        <a href="{{route('admin_ConfigDashboard',['id'=>request()->id])}}" class="btn btn-outline-success" >ตั้งค่าระบบ</a>
                        <a href="{{route('admin_ConfigForm',['id'=>request()->id])}}" class="btn btn-outline-dark" >ตั้งค่าฟอร์ม</a>
                      </div>

                      @endforeach

<br>
                      <div class="table-responsive">
                        <table class="table cell-border hover" id="dataTables">
                            <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Username</th>
                                  <th scope="col">ชื่อ-นามสกุล</th>
                                  
                                  <th scope="col">ประเภทผู้ใช้</th>
                                  <th scope="col"></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($user_dep as $item)                                  
                              
                                <tr>
                                  <th scope="row">{{$loop->iteration}}</th>
                                  <td>{{$item->email}}</td>
                                  <td>{{$item->name}}</td>
                                  <td>
                                        @php
                                            $user_role = $item->role;
                                        @endphp
                                        @if ($user_role == 'user')
                                            สมาชิกทั่วไป
                                        @elseif ($user_role == 'leader')
                                            เจ้าหน้าที่
                                        @endif
                                  </td>
                                  <td>
                                    <div class="btn-group btn-group-sm" role="group" >
                                    
                                        <a href="#" class="btn btn-warning"
                                        data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                            data-bs-title="แก้ไขข้อมูล"
                                        ><i class="las la-pen"></i></a>
                                        <a href="#" class="btn btn-danger" onclick="return confirm('ยืนยันการลบหรือไม่?')"
                                        data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-custom-class="custom-tooltip"
                                            data-bs-title="ลบผู้ใช้" >
                                            <i class="las la-trash-alt"></i>
                                        </a>
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
</div>
@endsection
