@extends('layouts.companyapp')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('file/logo-id.png') }}" class="mb-2" width="280px" alt="">
                        </div>
                        @foreach ($formName as $row)
                            <div class="text-center h5 mb-3"> 
                                {{ $row->form_name }}
                            </div>
                        @endforeach
                        @php
                            $form_id = request()->form_id;
                            $agent_id = Auth::user()->user_id;
                            $sql_car = DB::table('user_details')
                                ->orderBy('id', 'DESC')
                                ->where('user_status', '=', '1')
                                ->where('user_dep', '=', $agent_id)
                                ->get();
                        @endphp

                        <form action="{{ route('user_ChkInsert', ['form_id' => request()->form_id]) }}" method="post"
                            name="form2">
                            @csrf
                       
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-3 col-form-label">ผู้เรียน</label>
                                <div class="col-sm-9">
                                    <select class="form-select form-select js-example" name="car_plate" required>
                                        <option>--เลือกผู้เรียน</option>
                                        @foreach ($sql_car as $data)
                                            <option value="{{ $data->user_id }}">{{ $data->fullname }}
                                               </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                     
                   
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <caption>ตรวจเมื่อ :: {{ Carbon\Carbon::now()->format('d/m/Y H:i') }} </caption>
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">ข้อตรวจ</th>
                                        <th class="text-center" scope="col" style="font-size: 0.7rem">ผลการตรวจ</th>

                                        <th class="text-center" style="font-size: 0.7rem">หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        $i = '0';
                                        $n = '0';
                                        $a = '0';
                                    @endphp
                                    @foreach ($formPreview as $row)
                                        <tr>
                                            <th colspan="5">
                                                หมวดหมู่ {{ $loop->iteration }}
                                                {{ $row->category_name }}</th>

                                        </tr>

                                        @php
                                            $cate_id = $row->category_id;
                                            $sql2 = DB::table('form_choices')
                                                ->where('category_id', '=', $cate_id)
                                                ->get();
                                        @endphp
                                        @foreach ($sql2 as $row2)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>

                                                <td>{{ $row2->form_choice }}
                                                    @if ($row2->choice_img != '0')
                                                        <br>
                                                        <img src="{{ asset($row2->choice_img) }}" width="230px"
                                                            height="80px" alt="">
                                                    @endif
                                                </td>

                                                @if ($row->form_type == '5')
                                                <td>
                                                    <input type="hidden" name="choice[{{ $i++ }}]"
                                                        value="{{ $row2->id }}">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="user_chk[{{ $row2->id }}]" id="user_chk{{ $row2->id }}" value="1" checked>
                                                        <label class="text-success" for="user_chk{{ $row2->id }}">ผ่าน</label>
                                                          </div>
                                                          <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="user_chk[{{ $row2->id }}]" id="user_chk2{{ $row2->id }}" value="0">
                                                            <label class="text-danger" for="user_chk2{{ $row2->id }}">ปรับปรุง</label>
                                                          </div>
                                                </td>
                                                @else
                                                <td class="text-center">
                                                    <input type="hidden" name="choice[{{ $i++ }}]"
                                                        value="{{ $row2->id }}">
                                                    <select name="user_chk[{{ $n++ }}]"
                                                        class="form-select form-control " size="3">
                                                        <option value="1" class="text-success" selected>☑ ปกติ
                                                        </option>
                                                        <option value="0" class="text-danger">☒ ไม่ปกติ</option>
                                                        <option value="2">☐ ไม่มี</option>
                                                    </select>
                                                </td>
                                                @endif
                                              

                                                <td>
                                                    <input class="form-control form-control-sm" type="text"
                                                        name="user_remark[{{ $a++ }}]" placeholder="หมายเหตุ">
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-grid gap-2 col-6 mx-auto">
                            <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".js-example").select2({
                placeholder: "--เลือกทะเบียนรถ",
                allowClear: true
            });
        });
    </script>
@endsection
