@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tax Settings</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create tax'))
                            <a href="{{ route('tax-settings.create') }}" class="btn btn-primary">Add New Tax</a>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <table id="dataTable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="p-1">#</th>
                                        <th class="p-1">Taxes (in %)</th>
                                        <th class="p-1">Status</th>
                                        @canany(['edit tax', 'delete tax'])
                                        <th class="p-1">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taxes as $key => $tax)
                                        <tr>
                                            <td class="p-1">{{ ++$key }}</td>
                                            <td class="p-1">{{ $tax->tax }}</td>
                                            <td class="p-1">
                                                <input type="checkbox" id="{{ $tax->id }}" class="update-status" data-id="{{ $tax->id }}" switch="success" data-on="Active" data-off="Inactive" {{ $tax->status === 0 ? 'checked' : '' }} data-endpoint="{{ route('tax-status') }}" />
                                                <label class="mb-0" for="{{ $tax->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit tax', 'delete tax'])
                                            <td class="p-1">
                                                @if(Auth::user()->can('edit tax'))
                                                <a href="{{ route('tax-settings.edit', $tax->id)}}" class="btn btn-primary btn-sm edit py-0 px-1"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete tax'))
                                                <button data-source="tax" data-endpoint="{{ route('tax-settings.destroy', $tax->id)}}"
                                                    class="delete-btn btn btn-danger btn-sm edit py-0 px-1">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @endif
                                            </td>
                                            @endcanany
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
    <x-include-plugins :plugins="['dataTable']"></x-include-plugins>
    
    <script>
        $(function() {
            $('#dataTable').DataTable();

            $('.update-status').change(function() {
                var status = $(this).prop('checked') ? '0' : '1';
                var id = $(this).data('id');
                let statusUpdateApiEndpoint = $(this).data('endpoint');
                const toggleButton = $(this);
                swal({
                    title: "Are you sure?",
                    text: `You really want to change this?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: statusUpdateApiEndpoint,
                            data: {
                                'status': status,
                                'id': id,
                                '_token': '{{ csrf_token() }}' 
                            },
                            success: function(response) {
                                if(response.success){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        type: "success",
                                        showConfirmButton: false
                                    }) 
    
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating status:', error);
                            }
                        });
                    } else {
                        console.log('sasd');
                        toggleButton.prop('checked', !toggleButton.prop('checked')); 
                    }
                });
            });
        });
    </script>
@endsection