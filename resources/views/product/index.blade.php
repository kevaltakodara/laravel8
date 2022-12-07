@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        Product List
                    </div>
                    <div>
                        <a class="btn btn-success" href="{{url('/product/create')}}"> Add Product</a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table id="dataTable">
                        <thead>
                            <tr>
                                <td>Image</td>
                                <td>Product Name</td>
                                <td>Price</td>
                                <td>Min QTY</td>
                                <td>Max QTY</td>
                                <td>Status</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footscript')
<script>
    $(document).ready(function(){

        // DataTable
        $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            method: 'post',
            ajax: "{{url('/product/fetch')}}",
            "columnDefs": [ 
                {
                    "targets": [0, 4],
                    "orderable": false
                },
                {
                    "targets": [1, 2, 3, 4],
                    "className": "text-center",
                }
            ],
            columns: [
                { data: 'image'},
                { data: 'product_name' },
                { data: 'price' },
                { data: 'min_qty' },
                { data: 'max_qty' },
                { data: 'status' },
                { data: 'action'},
            ]
        });

        });
</script>
@endsection