@extends('layouts.leaderapp')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-body">
                        @if ($type == '4')
                            <a class="btn btn-primary mb-2"
                                href="{{ route('printpreview', ['round' => request()->round, 'type' => request()->type]) }}"
                                target="_blank"><i class="las la-print"></i>
                                พิมพ์</a>
                            <div class="text-center">
                                <img src="{{ asset('file/logo-id.png') }}" class="mb-2" width="80px" alt="">
                            </div>
                            <div class="text-center h5 mb-3">

                                @foreach ($formName as $item)
                                    <strong> {{ $item->form_name }} </strong>
                                @endforeach

                            </div>
                            @foreach ($DetailData as $data)
                                <div class="row mb-3">
                                    <div class="col">
                                        <span class="col-form-label"><strong>ชื่อผู้รับการทดสอบ</strong> :
                                            {{ $data->fullname }}</span>
                                    </div>

                                    <div class="col">
                                        <span class="col-form-label"><strong>สาขา : </strong>{{ $data->branch_name }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <span class="col-form-label"><strong>ผู้ดำเนินการทดสอบ </strong> :
                                            {{ Auth::user()->name }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($DetailData as $item)
                                <a class="btn btn-primary mb-2"
                                    href="{{ route('printpreview', ['round' => request()->round, 'type' => request()->type]) }}"
                                    target="_blank"><i class="las la-print"></i> พิมพ์</a>
                                <div class="text-center">
                                    <img src="{{ asset('file/logo-id.png') }}" class="mb-2" width="100px" alt="">
                                </div>
                                <div class="text-center h5 mb-3"> {{ $item->form_name }}</div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <span class="col-form-label"><strong>ชื่อผู้บันทึก</strong> :
                                            {{ Auth::user()->name }}</span>
                                    </div>

                                    <div class="col">
                                        <span class="col-form-label"><strong>ทะเบียนรถ : </strong>{{ $item->car_plate }}
                                            {{ $item->car_province }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col">
                                        <span class="col-form-label"><strong>เลขไมล์</strong> :
                                            {{ number_format($item->car_mileage) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="table-responsive-md">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col col-1">#</th>
                                        <th scope="col col-4">ข้อตรวจ</th>
                                        <th class="text-center col-2">ผลการตรวจ</th>
                                        <th class="text-center col-3">หมายเหตุ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $n = '1';
                                    @endphp

                                    @foreach ($formType as $row)
                                        <tr>
                                            <th colspan="4">
                                                @php
                                                    echo 'หมวดหมู่ ' . $n++;
                                                @endphp
                                                {{ $row->category_name }}</th>
                                        </tr>
                                        @php
                                            $i = '1';
                                            $round_chk = request()->round;
                                            $cate_id = $row->category_id;
                                            $sql2 = DB::table('form_choices')
                                            ->join('chk_records', 'chk_records.choice_id', '=', 'form_choices.id')
                                            ->where('form_choices.category_id', '=', $cate_id)
                                            ->where('chk_records.round_chk','=',$round_chk)
                                            ->get();
                                        @endphp
                                        @foreach ($sql2 as $row2)
                                            <tr>
                                                <td>
                                                    @php
                                                        echo $i++;
                                                    @endphp</td>
                                                <td>{{ $row2->form_choice }}</td>
                                                <td>
                                                    @if (request()->type == '4')
                                                        @if ($row2->user_chk == '1')
                                                            ผ่าน
                                                        @elseif ($row2->user_chk == '0')
                                                            ปรับปรุง
                                                        @endif
                                                    @else
                                                        @if ($row2->user_chk == '1')
                                                            ปกติ
                                                        @elseif ($row2->user_chk == '0')
                                                            ไม่ปกติ
                                                        @elseif ($row2->user_chk == '2')
                                                            ไม่มี
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $row2->choice_remark }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    @foreach ($formchk_date as $item)
                                        <td colspan="4" align="center">วันที่ทดสอบ :
                                            {{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') }}
                                        </td>
                                    @endforeach
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
