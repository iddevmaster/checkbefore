@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title fw-bold ">{{$branch_name->branch_name}} </h5>
                        <hr>
                        <div class="row row-cols-auto mt-3">
                            @foreach ($form_branch as $row)                                
                            
                            <div class="col mt-2">
                                <a href="{{route('admin_report_std',['branch'=>$row->agent_id,'form'=>$row->form_id])}}" class="btn btn-outline-success">
                                    {{$row->form_name}}
                                </a>
                            </div>
                            
                            @endforeach
                           
                           
                        </div>

                        <h5 class="card-title fw-bold mt-4">รายชื่อนักเรียนเข้าใช้ระบบ</h5>
                        <hr>



                        <table class="table table-responsive cell-border" id="dataTables">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>ชื่อ</th>
                                    <th>ประเภท</th>
                                    <th>วันที่เข้าใช้</th>
                                   
                                </tr>
                            </thead>
                            <tbody>

                               @foreach ($user_list as $item)     
                                <tr>
                                    <td> {{ $loop->iteration }}</td>
                                    <td> {{$item->fullname}} </td>
                                    <td>
                                        @if ($item->type_form == 'car')
                                        รถยนต์
                                        @elseif($item->type_form == 'motobike')
                                            รถจักรยานยนต์
                                            @elseif($item->type_form == 'trailer')
                                            รถ ท2
                                        @endif


                                    </td>
                                    <td>
                                        {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
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
