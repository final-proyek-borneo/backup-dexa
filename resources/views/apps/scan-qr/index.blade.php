@extends('partial.app')
@section('title', 'Scan QR')
@section('css')
    <style>
        #tb_wrapper .row:nth-child(2) {
            overflow-x: auto;
        }

        .d-flex .flex-row-item {
            flex: 1 1 30%;
        }

        .text-secondary {
            color: #969DA4 !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        .btn-secondary {
            background-color: #A5A5A5 !important;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background-color: #0A9447;
            border-color: transparent;
        }

        .nav-tabs .nav-item .nav-link.active {
            font-weight: bold;
            color: #FFFF;
        }

        .nav-tabs .nav-item .nav-link {
            color: #A5A5A5;
        }

        #html5-qrcode-button-camera-start {
            background-color: #FAFBFC;
            border: 1px solid #0A9447;
            color: #0A9447;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            appearance: none;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-button-camera-stop {
            background-color: #FAFBFC;
            border: 1px solid #FF0000;
            color: #FF0000;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            appearance: none;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-select-camera {
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            color: #24292E;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-button-torch-on {
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            color: #24292E;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-button-torch-off {
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            color: #24292E;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-button-torch {
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            color: #24292E;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }

        #html5-qrcode-button-camera-permission {
            background-color: #FAFBFC;
            border: 1px solid rgba(27, 31, 35, 0.15);
            color: #24292E;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            padding: 6px 16px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 6px;
            box-sizing: border-box;
            box-shadow: rgba(27, 31, 35, 0.04) 0 1px 0, rgba(255, 255, 255, 0.25) 0 1px 0 inset;
            font-family: -apple-system, system-ui, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji";
            line-height: 20px;
            margin-bottom: 5px;
            transition: background-color 0.2s cubic-bezier(0.3, 0, 0.5, 1);
        }
    </style>
@endsection

@section('content')
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div id="reader" width="600px"></div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-12 mt-2">
                                <div class="form-group required">
                                    <label>Hasil Scan</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="result" name="fc_barcode"
                                            readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" onclick="click_modal_barcode()" type="button"
                                                id="detail"><i class="fa fa-eye"></i> Detail</button>
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
@endsection

@section('modal')
    <div class="modal fade" role="dialog" id="modal_barcode" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header br">
                    <h5 class="modal-title">Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form_scan" action="/apps/penggunaan-cprr/scan-barang" method="POST" autocomplete="off">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Katalog</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_stockcode" name="fc_stockcode"
                                            readonly>
                                        <input type="text" class="form-control" id="fc_barcode_scan"
                                            name="fc_barcode_scan" hidden>
                                        <input type="text" class="form-control" id="fc_warehousecode"
                                            name="fc_warehousecode" hidden>
                                        <input type="text" class="form-control" id="fc_membercode" name="fc_membercode"
                                            hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Nama Barang</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_namelong" name="fc_namelong"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Batch</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fc_batch" name="fc_batch" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <div class="form-group required">
                                    <label>Expired Date</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="fd_expired" name="fd_expired"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        var audio = new Audio('/assets/audio/scan.mp3');

        function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            // console.log(`Code matched = ${decodedText}`, decodedResult);
            audio.play();
            $('#result').val(decodedText);
            table_detail_barang();
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
        }

        let qrboxFunction = function(viewfinderWidth, viewfinderHeight) {
            let minEdgePercentage = 0.7; // 70%
            let minEdgeSize = Math.min(viewfinderWidth, viewfinderHeight);
            let qrboxSize = Math.floor(minEdgeSize * minEdgePercentage);
            return {
                width: qrboxSize,
                height: qrboxSize
            };
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: qrboxFunction,
                supportedScanTypes: [
                    Html5QrcodeScanType.SCAN_TYPE_CAMERA
                ],
                showTorchButtonIfSupported: true,
                showZoomSliderIfSupported: true,
            }, false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);

        function click_modal_barcode() {
            table_detail_barang();
        }

        function table_detail_barang() {
            var fc_barcode = $('#result').val();
            var fc_barcode_encode = window.btoa(fc_barcode);
            var url = "/apps/scan-qr/detail-barang/" + fc_barcode_encode;

            $.ajax({
                url: url,
                type: "GET",
                beforeSend: function() {
                    // Show the loading modal
                        $('#modal_loading').modal('show');
                },
                success: function(response) {
                    // Close the loading modal
                    if (response.status === 200) {
                        setTimeout(function() {
                            $('#modal_loading').modal('hide');
                        }, 500);

                        $('#fc_barcode_scan').val(response.data.fc_barcode);
                        // Populate the input fields with the received data
                        $('#fc_namelong').val(response.data.stock.fc_namelong);
                        $('#fc_warehousecode').val(response.data.warehouse.fc_warehousecode);
                        $('#fc_membercode').val(response.data.warehouse.fc_membercode);
                        $('#fc_stockcode').val(response.data.fc_stockcode);
                        $('#fc_batch').val(response.data.fc_batch);
                        $('#fd_expired').val(response.data.fd_expired);

                        // Show the modal_barcode modal
                        setTimeout(function(){
                            $('#modal_barcode').modal('show');
                        }, 600);
                    } else {
                        $('#modal_loading').modal('hide');
                        swal(response.message, {
                            icon: 'error',
                        });
                    }

                },
                error: function(xhr, status, error) {
                    // Close the loading modal
                    $('#modal_loading').modal('hide');
                    console.log(xhr.responseText);
                }
            });
        }

        $('#form_scan').on('submit', function(e) {
            e.preventDefault();

            var form_id = $(this).attr("id");
            if (check_required(form_id) === false) {
                swal("Oops! Mohon isi field yang kosong", {
                    icon: 'warning',
                });
                return;
            }

            swal({
                    title: 'Yakin?',
                    text: 'Apakah anda yakin akan menyimpan data ini?',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((save) => {
                    if (save) {
                        $("#modal_loading").modal('show');
                        $.ajax({
                            url: $('#form_scan').attr('action'),
                            type: $('#form_scan').attr('method'),
                            data: $('#form_scan').serialize(),
                            success: function(response) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                if (response.status == 200) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    $("#form_scan")[0].reset();
                                    reset_all_select();
                                    tb.ajax.reload(null, false);
                                } else if (response.status == 201) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    location.href = response.link;
                                } else if (response.status == 203) {
                                    swal(response.message, {
                                        icon: 'success',
                                    });
                                    $("#modal").modal('hide');
                                    tb.ajax.reload(null, false);
                                } else if (response.status == 300) {
                                    swal(response.message, {
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                setTimeout(function() {
                                    $('#modal_loading').modal('hide');
                                }, 500);
                                swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR
                                    .responseText + ")", {
                                        icon: 'error',
                                    });
                            }
                        });
                    }
                });
        });
    </script>
@endsection
