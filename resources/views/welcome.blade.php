<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Datatable server side</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

    {{-- JS --}}
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>

    {{-- Datatable --}}
    <link rel="stylesheet" href="{{ asset('assets/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

</head>

<body class="antialiased">
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Datatable</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="form-label">Search</label>
                            <input type="text" class="form-control" id="cari" placeholder="keywords...">
                        </div>

                        <div class="col-md-6">
                            <label for="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Pilih status</option>
                                <option value="active">Active</option>
                                <option value="nonactive">Nonactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mt-3">
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-outline-secondary" id="btnReset">Reset</button>
                                <button class="btn btn-outline-primary" style="margin-left:10px" id="btnFilter">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-responsive" id="dTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Datatable js --}}
    <script src="{{ asset('assets/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('assets/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('assets/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>


    <script>
        $(document).ready(function () {
            let dTable = $('#dTable').DataTable({
                "responsive": true,
                "theme": 'bootstrap-4',
                "searching": false,
                "language": {
                    "decimal": "",
                    "emptyTable": "Tidak ada data yang ditemukan",
                    "info": "Menampilkan data ke _START_ - _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 dari 0 data",
                    "infoFiltered": "(Difilter dari _MAX_ data)",
                    "infoPostFix": "",
                    "thousands": ".",
                    "lengthMenu": "Menampilkan _MENU_ data",
                    "loadingRecords": "",
                    "processing": "",
                    "search": "Cari:",
                    "zeroRecords": "Tidak ada data yang sesuai",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                },
                "columnDefs": [{
                        "name": "id",
                        "targets": 0,
                        "orderable": true,
                    },
                    {
                        "name": "name",
                        "targets": 1,
                        "orderable": true,
                    },
                    {
                        "name": "email",
                        "targets": 2,
                        "orderable": true,
                    },
                    {
                        "name": "status",
                        "targets": 3,
                        "orderable": true,
                    },
                    {
                        "name": "action",
                        "targets": 4,
                        "orderable": false,
                    },
                ],
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('api.user.datatable') }}",
                    "type": "POST",
                    "data": function (data) {
                        let cari = $('#cari').val()
                        let status = $('#status').val()

                        data.cari = cari,
                        data.status = status
                    }
                }
            })

            // filter
            $('#btnFilter').click((e) => {
                dTable.ajax.reload()
            })

            // reset
            $('#btnReset').click((e) => {
                $('#cari').val('')
                $('#status').val('')

                dTable.ajax.reload()
            })
        })

    </script>
</body>

</html>
