@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">ผู้ดูแลระบบ</div>

                <div class="card-body">
                   
                              
                    <div class="container text-center">
                        <div class="row">
                            <div class="col-4">                                
                                    <img src="{{ asset('images/logo_one.jpg') }}" width="100px" alt="">
                               </div>
                            <div class="col-8">
                                <h4>ผู้จัดการโรงเรียน</h4>
                            </div>
                        </div>
                    </div>
              

                <div class="accordion accordion-flush mt-4" id="accordionFlushExample">
                   
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/checked.png') }}" alt=""
                                        style="width: 45px; height: 45px" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">รายงานการตรวจเช็ค</p>

                                    </div>
                                </div>
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                                
                                
                                  @foreach ($branch_list as $row)
                                    <li class="list-group-item">
                                      <a href="{{route('admin_report_branch',['id'=>$row->id_branch])}}" class="btn btn-sm btn-outline-success">
                                      {{$row->branch_name}}</a>
                                    </li>
                                    @endforeach
                                
                                </ul>
                            </div>
                        </div>
                    </div>                   
                   
                </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
