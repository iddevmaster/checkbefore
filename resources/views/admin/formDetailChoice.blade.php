@extends('layouts.app')

@section('content')
    @php
        $i = '1';
    @endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @foreach ($categoryName as $row)
                        <div class="card-header">หมวดหมู่ :: {{ $row->category_name }}</div>
                    @endforeach


                    <div class="card-body">
                        <p><a href="{{ route('admin_AddChoice', ['id' => request()->id]) }}"
                                class="btn btn-sm btn-info">เพิ่มข้อตรวจ</a></p>

                        <table class="table table-bordered table-hover">
                            <thead>
                                <th>ที่</th>
                                <th>ข้อตรวจ</th>
                                <th></th>
                            </thead>
                            <tbody>
                                @foreach ($category_choice as $item)
                                    <tr>
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>{{ $item->form_choice }}</td>
                                        <td>
                                           
                                                <a href="{{ route('admin_ChoiceEdit', ['id' => $item->id]) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="las la-pen"></i>
                                                </a>

                                                <a href="{{ route('admin_ChoiceDelete', ['id' => $item->id , 'cid'=>$item->category_id]) }}" class="btn btn-sm btn-danger" onclick="return confirm('ยืนยันการลบหรือไม่?')">
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
@endsection

