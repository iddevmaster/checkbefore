@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">

                        @foreach ($dashboard as $item)
                            @if ($item->vid_company != '')
                                <div class="alert alert-success h5" role="alert"> วิดิทัศน์แนะนำบริษัท </div>
                                <div class="ratio ratio-16x9">
                                    {!! $item->vid_company !!}
                                </div>
                            @endif
                            <br>



                            <ul class="list-group list-group-light">

                                <a data-bs-toggle="modal" data-bs-target="#vid_um">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/play.png') }}" alt=""
                                                style="width: 45px; height: 45px" class="rounded-circle" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">วิดิทัศน์การใช้งานระบบ </p>
                                            </div>
                                        </div>
                                        <i class="las la-angle-right"></i>
                                    </li>
                                </a>

                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_bc"
                                    style="text-decoration:none">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/brochure.png') }}" alt=""
                                                style="width: 45px; height: 45px" class="rounded-circle" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">คู่มือการเรียน</p>
                                            </div>
                                        </div>
                                        <i class="las la-angle-right"></i>
                                    </li>
                                </a>

                                <a href="#" data-bs-toggle="modal" data-bs-target="#modal_um" style="text-decoration:none">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/user-guide.png') }}" class="rounded-circle"
                                                alt="" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">คู่มือการใช้ระบบ</p>
                                            </div>
                                        </div>
                                        <i class="las la-angle-right"></i>
                                    </li>
                                </a>

                                <a href="{{ route('user_FormChk') }}" style="text-decoration:none">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">

                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('images/checked.png') }}" class="rounded-circle"
                                                alt="" style="width: 45px; height: 45px" />
                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">แบบฟอร์มตรวจเช็คประจำวัน</p>

                                            </div>
                                        </div>
                                        <i class="las la-angle-right"></i>
                                    </li>
                                </a>

                            </ul>



                    </div>
                </div>
            </div>
        </div>

        @if ($item->vid_um != '')
            <!-- Modal video-->
            <div class="modal fade modal-lg" id="vid_um" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">วิดิทัศน์การใช้งานระบบ</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! $item->vid_um !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Modal brochure-->
        <div class="modal fade modal-lg" id="modal_bc" tabindex="-1" aria-labelledby="modal_bc" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_bc">คู่มือการเรียน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="{{ asset($item->file_brochure) }}" class="img-thumbnail" alt="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal um-->
        <div class="modal fade modal-lg" id="modal_um" tabindex="-1" aria-labelledby="modal_um" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal_um">คู่มือการเรียน</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <iframe src="{{asset($item->file_um)}}" width="100%"
                            height="600"></iframe>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    @endsection
