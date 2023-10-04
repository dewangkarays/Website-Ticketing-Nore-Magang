@extends('layout')

@section('css')
<style type="text/css">
    .status-title {
        font-size: 16px;
        font-weight: 600;
    }

    .scrollable-container {
        overflow-x: auto;
        white-space: nowrap;
        max-width: 100%;
    }

    .status-columns {
        display: grid;
        grid-template-columns: repeat(5, 400px);
        gap: 10px;
    }

    .list {
		padding-left: 0px;
	}

    .list-group-item {
        min-height: 30px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: normal;
        word-wrap: break-word;        
    }

    .list-group-item-clickable {
        border: 1px solid #ccc;
        padding: 15px;
        margin: 10px;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .list-group-item-clickable:hover {
        background-color: #f0f0f0;
    }

    .full-width {
        width: 100%;
        border-top: 1px solid #ccc;
    }

    .activity-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .profile-circle {
        width: 30px;
        height: 30px;
        background-color: #007bff;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: bold;
        margin-right: 10px;
    }

    .activity-log {
        max-height: 775px;
        overflow-y: auto;
    }
</style>
@endsection

@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><span class="font-weight-semibold">Home</span> - Status Patchlist</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>
    </div>
</div>

<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row justify-content-between">
                <div class="col">
                    <div class="card-body">
                        <div class="scrollable-container">
                            <div class="status-columns">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header status-title">Hold</div>
                                        <ul class="list" id="hold-list"></ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header status-title">Queue</div>
                                        <ul class="list" id="queue-list"></ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header status-title">In Progress</div>
                                        <ul class="list" id="in-progress-list"></ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header status-title">Done Test Server</div>
                                        <ul class="list" id="done-test-server-list"></ul>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header status-title">Production</div>
                                        <ul class="list" id="production-list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="patchModal" tabindex="-1" role="dialog" aria-labelledby="patchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header mb-4">
                <h5 class="modal-title font-weight-semibold" id="patchModalLabel">Detail Patchlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="/patchlist/updateStatus">
                        @csrf
                            <div class="form-group">
                                <label for="namaKlien">Nama Klien:</label>
                                <input type="text" class="form-control" id="namaKlien" readonly>
                            </div>
                            <div class="form-group">
                                <label for="namaProyek">Nama Proyek:</label>
                                <input type="text" class="form-control" id="namaProyek" readonly>
                            </div>
                            <div class="form-group">
                                <label for="patchName">Nama Patch:</label>
                                <textarea class="form-control" id="patchName" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label for="prioritas">Prioritas:</label>
                                <input type="text" class="form-control" id="prioritas" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggalRequest">Tanggal Request:</label>
                                <input type="text" class="form-control" id="tanggalRequest" readonly>
                            </div>
                            <div class="form-group">
                                <label for="kesulitan">Kesulitan:</label>
                                <input type="text" class="form-control" id="kesulitan" readonly>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select id="status" class="form-control" name="newStatus"> <!-- Pastikan Anda memberikan atribut "name" -->
                                    @foreach(config('custom.status') as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tanggalPatch">Tanggal Patch:</label>
                                <input type="text" class="form-control" id="tanggalPatch" readonly>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan:</label>
                                <textarea class="form-control" id="keterangan" readonly></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="activity-log">
                            <h5 style="margin-left: 15px;">Aktivitas:</h5>
                            <ul id="activity-log">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali <i class="icon-undo2 mr-2"></i></button>
                <button type="submit" class="btn btn-primary" id="saveButton">Simpan <i class="icon-floppy-disk ml-2"></i></button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('global_assets/js/plugins/notifications/pnotify.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/notifications/bootbox.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/forms/selects/select2.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/spin.min.js')}}"></script>
<script src="{{asset('global_assets/js/plugins/buttons/ladda.min.js')}}"></script>

<script src="{{asset('assets/js/app.js')}}"></script>
<script src="{{asset('global_assets/js/demo_pages/components_modals.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>

<script>
    const prioritas = {
        '-2': '-2',
        '-1': '-1',
        '0': '0',
        '1': '1',
        '2': '2',
        '3': '3',
    }

    const statuss = {
        '0': 'Hold',
        '1': 'Queue',
        '2': 'In Progress',
        '3': 'Done Test Server',
        '4': 'Production',
    }

    const kesulitan = {
        '0': 'Sangat Tinggi',
        '1': 'Tinggi',
        '2': 'Sedang',
        '3': 'Rendah',
    }

    var selectedPatchData = null;

    $(document).ready(async function() {
        async function loadStatusData(status, elementId) {
            try {
                const response = await $.ajax({
                    url: '/api/patchlist/getDataByStatus',
                    type: 'GET',
                    data: { status: status }
                });

                var list = $('#' + elementId);
                list.empty();

                if (response && response.patches && Array.isArray(response.patches)) {
                    response.patches.forEach(function(patch) {
                        var listItem = $('<li class="list-group-item list-group-item-clickable">' + patch + '</li>');
                        listItem.click(function() {
                            var patchName = $(this).text();

                            $.ajax({
                                url: '/api/patchlist/getDetailDataByName',
                                type: 'GET',
                                data: { patchName: patchName },
                                success: function(detailData) {
                                    $('#patchName').val(patchName || '-');
                                    $('#namaKlien').val(detailData.namaKlien || '-');
                                    $('#namaProyek').val(detailData.namaProyek || '-');
                                    $('#prioritas').val(prioritas[detailData.prioritas] || '-');
                                    var formattedDate = '-';
                                    if (detailData.tanggalRequest) {
                                        var createdDate = new Date(detailData.tanggalRequest);
                                        if (!isNaN(createdDate.getTime())) {
                                            var year = createdDate.getFullYear();
                                            var month = (createdDate.getMonth() + 1).toString().padStart(2, '0');
                                            var day = createdDate.getDate().toString().padStart(2, '0');
                                            formattedDate = year + '-' + month + '-' + day;
                                        }
                                    }
                                    $('#tanggalRequest').val(formattedDate);
                                    $('#kesulitan').val(kesulitan[detailData.kesulitan] || '-');
                                    $('#patchModal').on('shown.bs.modal', function () {
                                        $('#status').val(detailData.status);
                                    });
                                    $('#tanggalPatch').val(detailData.tanggal_patch || '-');
                                    $('#keterangan').val(detailData.keterangan || '-');
                                    $('#patchModal').modal('show');
                                },
                                error: function(error) {
                                    console.error('Error:', error);
                                }
                            });
                        });
                        list.append(listItem);
                    });
                } else {
                    console.error('Data tidak valid atau tidak berisi nama patch.');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
        loadStatusData('0', 'hold-list');
        loadStatusData('1', 'queue-list');
        loadStatusData('2', 'in-progress-list');
        loadStatusData('3', 'done-test-server-list');
        loadStatusData('4', 'production-list');


        function loadActivityLog(patchName) {
            $('#activity-log').empty();
            $.ajax({
                url: '/api/activity-log/getActivityLogByPatchName',
                type: 'GET',
                data: { patchName: patchName },
                success: function (activityLogs) {
                    activityLogs.sort(function(a, b) {
                        return new Date(b.created_at) - new Date(a.created_at);
                    });
                    if (activityLogs && Array.isArray(activityLogs)) {
                        activityLogs.forEach(function (activityLog) {
                            var activityLogItem = $('<li class="activity-item"></li>');
                            $.ajax({
                                url: '/api/user/getUserName',
                                type: 'GET',
                                data: { userId: activityLog.user_id },
                                success: function (response) {
                                    var userName = response.userName;
                                    var userInitials = getInitials(userName);
                                    var profileCircle = $('<div class="profile-circle">' + userInitials + '</div>');
                                    var activityDetails = $('<div class="activity-details"></div>');

                                    if (activityLog.activity_type === 'create') {
                                        activityDetails.append(userName + ' menambahkan patchlist');
                                    } else if (activityLog.activity_type === 'edit') {
                                        activityDetails.append(userName + ' mengedit patchlist');
                                    }
                                    activityDetails.append('<br>' + activityLog.created_at);
                                    activityLogItem.append(profileCircle);
                                    activityLogItem.append(activityDetails);

                                    $('#activity-log').append(activityLogItem);
                                },
                                error: function (error) {
                                    console.error('Error:', error);
                                }
                            });
                        });
                    } else {
                        // ...
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }

        function getInitials(name) {
            const words = name.split(' ');
            if (words.length === 1) {
                return words[0].substring(0, 2).toUpperCase();
            }
            return words[0].substring(0, 1).toUpperCase() + words[1].substring(0, 1).toUpperCase();
        }

        $('#patchModal').on('show.bs.modal', function(event) {
            var patchName = $('#patchName').val();
            loadActivityLog(patchName);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#saveButton').on('click', function() {
            var newStatus = $('#status').val();
            var patchName = $('#patchName').val();

            $.ajax({
                url: '/patchlist/updateStatus',
                type: 'POST',
                data: {
                    patchName: patchName,
                    newStatus: newStatus,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#patchModal').modal('hide');
                    updatePatchlist(patchName, newStatus);
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

        function updatePatchlist(patchName, newStatus) {
            var patchlistItem = $('li.list-group-item-clickable:contains("' + patchName + '")');
            var targetColumn = $('.status-columns .col .card-header:contains("' + statuss[newStatus] + '")').siblings('ul.list');
            patchlistItem.detach();
            patchlistItem.appendTo(targetColumn);
        }

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        @if(session('error'))
            new PNotify({
                title: 'Error',
                text: '{{ session('error') }}',
                icon: 'icon-blocked',
                type: 'error'
            });
        @endif
        @if(session('success'))
            new PNotify({
                title: 'Success',
                text: '{{ session('success') }}',
                icon: 'icon-checkmark3',
                type: 'success'
            });
        @endif
    });
</script>

@endsection
