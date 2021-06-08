@extends('layouts.main')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $title }}</h1>
    </div>
    @if (Session::has('success'))
        <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            {{ Session('success') }}
        </div>
    @endif
    <div class="row mb-1">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="m-0 font-weight-bold text-primary">
                        @if ($data['subtitle'] == 'Grup Baru')
                            <i class="fas fa-plus-square"></i>
                        @elseif($data['subtitle'] == 'Edit Grup')
                            <i class="fas fa-edit"></i>
                        @endif
                        &nbsp;
                        {{ $data['subtitle'] }}
                    </h5>
                </div>
                <div class="car-body p-3">
                    <form action="{{ url($data['route']) }}" method="POST">
                        @csrf
                        @if ($data['method']) @method("PUT") @endif
                        <div class="form-group">
                            <label for="">Nama Group</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ isset($data['group_name']) ? $data['group_name'] : old('name') }}">
                            @error('name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3">
                    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-layer-group"></i> &nbsp; Data Group</h5>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush table-striped table-hover" id="dataTableHover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th width="80%">Nama Group</th>
                                <th width="15%">###</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $index => $group)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>
                                        @if ($group->id != 1)
                                            <form class="form-inline" method="post"
                                                action="{{ route('group.destroy', $group->id) }}">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                                <a href="{{ route('group.edit', $group->id) }}"
                                                    class="badge badge-info">edit</a>&nbsp;
                                                <a href="#" class="badge badge-danger btn-delete"
                                                    title="{{ $group->name }}" data-toggle="modal"
                                                    data-target="#modal-alert">hapus</a>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('partials.modal-alert')
@endsection

@push('scripts')
    <script>
        // Page level custom scripts
        $(document).ready(function() {

            $('#dataTableHover').DataTable(); // ID From dataTable with Hover

            $('#jenis').on('change', function() {
                var id = $('#jenis').val();
                window.location.href = '{{ url('product') }}/' + id;
            });

            $('body').on('click', '.btn-delete', function(event) {
                event.preventDefault();
                var me = $(this);
                var title = $(this).attr('title');
                $(".modal-alert-body").html("Yakin akan menghapus grup <b>" + title + "</b> ?")
                $("#btn-confirm").click(function() {
                    me.closest("form").submit();
                });
            });
        });

    </script>
@endpush
