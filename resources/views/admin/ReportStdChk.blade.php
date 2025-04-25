@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-bold ">{{$branch_name->branch_name}} </h5>
                        
                        <hr>
                  
                      <p class="fs-5 fw-bold text-center">รายงาน {{$form_name->form_name}}</p>


                        <table class="table table-responsive cell-border" id="dataTables">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>วันที่ตรวจ</th>     
                                    <th>ชื่อ</th>
                                    <th>ประเภท</th>
                                                               
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record_data as $data) 
                              <tr>
                                
                                <td>{{ $loop->iteration }} </td>
                                <td> <a href="{{route('admin_std_detail',['round'=>$data->round_chk,'type'=>$data->form_type])}}" class="text-decoration-none"> {{ Carbon\Carbon::parse($data->created_at)->format('d/m/Y') }}</a></td>
                                <td> {{$data->fullname}} </td>
                                <td> {{$data->form_type_name}} </td>
                                
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
