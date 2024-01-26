<script type="text/javascript">
   function check_required(form_id = "") {
      var process_required = true;

      var check_field = ".required-field";
      if (form_id != "") {
         check_field = "#" + form_id + " .required-field";
      } else {
         check_field = ".required-field";
      }

      $(check_field).each(function() {
         var value = $(this).val();
         if ($(this).hasClass("selectric")) {
            if (value === null) {
               $(".selectric-required-field > .selectric").addClass("red-border");
               process_required = false;
               $(this).bind('change', function() {
                  $(this).parents().eq(1).children('.selectric').removeClass("red-border");
               });
            }
         } else if ($(this).hasClass("select2")) {
            if (value === null) {
               $(this).parents().eq(0).find('.select2-selection--single').addClass("red-border");
               process_required = false;
               $(this).bind('change', function() {
                  $(this).parents().eq(0).find('.select2-selection--single').removeClass("red-border");
               });
            }
         } else {
            if (value == "") {
               $(this).addClass("is-invalid");
               process_required = false;

               $(this).bind('keyup change', function() {
                  $(this).removeClass("is-invalid");
               });
            } else {
               $(this).removeClass("is-invalid");
            }
         }
      });
      return process_required;
   }


   $('#form_submit').on('submit', function(e) {
      e.preventDefault();

      var form_id = $(this).attr("id");
      var formData = new FormData($('#form_submit')[0]);
        // Cek apakah input dengan nama 'image_file' ada dan memiliki file terpilih
      var imageInput = $('#customFile')[0];
      if (imageInput && imageInput.files.length > 0) {
         formData.append('image_file', imageInput.files[0]);
      }
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
                  url: $('#form_submit').attr('action'),
                  type: $('#form_submit').attr('method'),
                  data: formData,
                  contentType: false,
                   processData: false,
                  // data: $('#form_submit').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit")[0].reset();
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });
   
   $('#form_submit_accmethod_debit').on('submit', function(e) {
      e.preventDefault();

      var form_id = $(this).attr("id");
      var formData = new FormData($('#form_submit_accmethod_debit')[0]);
        // Cek apakah input dengan nama 'image_file' ada dan memiliki file terpilih
      var imageInput = $('#customFile')[0];
      if (imageInput && imageInput.files.length > 0) {
         formData.append('image_file', imageInput.files[0]);
      }
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
                  url: $('#form_submit_accmethod_debit').attr('action'),
                  type: $('#form_submit_accmethod_debit').attr('method'),
                  data: formData,
                  contentType: false,
                   processData: false,
                  // data: $('#form_submit_accmethod_debit').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_accmethod_debit")[0].reset();
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_cancel').on('submit', function(e) {
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
                  url: $('#form_submit_cancel').attr('action'),
                  type: $('#form_submit_cancel').attr('method'),
                  data: $('#form_submit_cancel').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_cancel")[0].reset();
                        reset_all_select();
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);

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
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_reject').on('submit', function(e) {
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
                  url: $('#form_submit_reject').attr('action'),
                  type: $('#form_submit_reject').attr('method'),
                  data: $('#form_submit_reject').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_reject")[0].reset();
                        reset_all_select();
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);

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
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_accept').on('submit', function(e) {
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
                  url: $('#form_submit_accept').attr('action'),
                  type: $('#form_submit_accept').attr('method'),
                  data: $('#form_submit_accept').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_accept")[0].reset();
                        reset_all_select();
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);

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
                        tb_applicant.ajax.reload(null, false);
                        tb_accessor.ajax.reload(null, false);
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_pdf').on('submit', function(e) {
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
                  url: $('#form_submit_pdf').attr('action'),
                  type: $('#form_submit_pdf').attr('method'),
                  data: $('#form_submit_pdf').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_pdf")[0].reset();
                        reset_all_select();
                        tb.ajax.reload(null, false);
                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#modal_pdf").modal('hide');
                        //  location.href = response.link;
                        window.open(
                           response.link,
                           '_blank' // <- This is what makes it open in a new window.
                        );
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_kwitansi').on('submit', function(e) {
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
                  url: $('#form_submit_kwitansi').attr('action'),
                  type: $('#form_submit_kwitansi').attr('method'),
                  data: $('#form_submit_kwitansi').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        $("#form_submit_kwitansi")[0].reset();
                        reset_all_select();
                        tb.ajax.reload(null, false);
                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        //  location.href = response.link;
                        window.open(
                           response.link,
                           '_blank' // <- This is what makes it open in a new window.
                        );
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_edit').on('submit', function(e) {
      e.preventDefault();

      var form_id = $(this).attr("id");
      var formData = new FormData($('#form_submit_edit')[0]);
      // Menambahkan data tambahan jika diperlukan
      var imageInput = $('#customFile')[0];
      if (imageInput && imageInput.files.length > 0) {
         formData.append('image_file', imageInput.files[0]);
      }
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
                  url: $('#form_submit_edit').attr('action'),
                  type: $('#form_submit_edit').attr('method'),
                  data: formData,
                  contentType: false,
                   processData: false,
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal_edit").modal('hide');
                        $("#form_submit_edit")[0].reset();
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
                     var errorMessage = "Mohon maaf masih ada data yang tidak sesuai";

                     // Khusus jika error di transaksi apabila coacode null
                     var responseObj = JSON.parse(jqXHR.responseText);
                     if (responseObj.message.includes("SQLSTATE[23000]: Integrity constraint violation")) {
                        var startIndex = responseObj.message.indexOf("SQLSTATE[23000]: Integrity constraint violation");
                        var endIndex = responseObj.message.indexOf("(SQL:");
                        // potong string yang sesuai dengan pesan dari object respon
                        var specificErrorMessage = responseObj.message.substring(startIndex, endIndex).trim();
                        if (specificErrorMessage == "SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'fc_coacode' cannot be null") {
                           swal(errorMessage, {
                              icon: 'error',
                           });
                        } else {
                           swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                              icon: 'error',
                           });
                        }
                     } else {
                        swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                           icon: 'error',
                        });
                     }

                  }
               });
            }
         });
   });

   $('#form_submit_cprr').on('submit', function(e) {
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
            text: 'Apakah anda yakin akan mengupdate data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((save) => {
            if (save) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: $('#form_submit_cprr').attr('action'),
                  type: $('#form_submit_cprr').attr('method'),
                  data: $('#form_submit_cprr').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal_edit").modal('hide');
                        $("#form_submit")[0].reset();
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_submit_custom').on('submit', function(e) {
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
                  url: $('#form_submit_custom').attr('action'),
                  type: $('#form_submit_custom').attr('method'),
                  data: $('#form_submit_custom').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        //  $("#modal").modal('hide');
                        $("#form_submit_custom")[0].reset();
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_cancel').on('submit', function(e) {
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
            text: 'Apakah anda yakin akan cancel data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((save) => {
            if (save) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: $('#form_cancel').attr('action'),
                  type: $('#form_cancel').attr('method'),
                  data: $('#form_cancel').serialize(),
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        //  $("#modal").modal('hide');
                        $("#form_cancel")[0].reset();
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
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   });

   $('#form_upload').submit(function(e) {
      e.preventDefault();

      swal({
            title: 'Yakin?',
            text: 'Apakah anda yakin akan menyimpan data ini?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: $('#form_upload').attr('action'),
                  type: $('#form_upload').attr('method'),
                  enctype: 'multipart/form-data',
                  data: new FormData($('#form_upload')[0]),
                  cache: false,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     if (response.status == 200) {
                        $("#form_upload")[0].reset();
                        $("#path_file_text").text("");
                        $("#modal").modal('hide');
                        swal(response.message, {
                           icon: 'success',
                        });
                        tb.ajax.reload(null, false);
                     } else if (response.status == 201) {
                        $("#modal").modal('hide');
                        iziToast.success({
                           title: 'Success!',
                           message: response.message,
                           position: 'topRight'
                        });
                        window.location.href = response.link;
                     } else if (response.status == 203) {
                        $("#modal").modal('hide');
                        iziToast.success({
                           title: 'Success!',
                           message: response.message,
                           position: 'topRight'
                        });
                        tb.ajax.reload(null, false);
                     } else {
                        iziToast.error({
                           title: 'Error!',
                           message: response.message,
                           position: 'topRight'
                        });
                        // swal(response.message, { icon: 'error', });
                     }
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   })

   function hanyaAngka(e, decimal) {
      var key;
      var keychar;
      if (window.event) {
         key = window.event.keyCode;
      } else if (e) {
         key = e.which;
      } else {
         return true;
      }
      keychar = String.fromCharCode(key);
      if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
         return true;
      } else if ((("0123456789").indexOf(keychar) > -1)) {
         return true;
      } else if (decimal && (keychar == ".")) {
         return true;
      } else {
         return false;
      }
   }

   function get_path_file() {
      var fullPath = $("#file_excel").val();
      var filename = fullPath.replace(/^.*[\\\/]/, '');
      $("#path_file_text").text(filename);
   }

   function edit_action(url, modal_text) {
      save_method = 'edit';
      $("#modal").modal('show');
      $(".modal-title").text(modal_text);
      $("#modal_loading").modal('show');
      $.ajax({
         url: url,
         type: "GET",
         dataType: "JSON",
         success: function(response) {
            Object.keys(response).forEach(function(key) {
               var elem_name = $('[name=' + key + ']');
               if (elem_name.hasClass('selectric')) {
                  elem_name.val(response[key]).change().selectric('refresh');
               } else if (elem_name.hasClass('select2')) {
                  elem_name.select2("trigger", "select", {
                     data: {
                        id: response[key]
                     }
                  });
               } else if (elem_name.hasClass('selectgroup-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('my-ckeditor')) {
                  CKEDITOR.instances[key].setData(response[key]);
               } else if (elem_name.hasClass('summernote')) {
                  elem_name.summernote('code', response[key]);
               } else if (elem_name.hasClass('custom-control-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('time-format')) {
                  elem_name.val(response[key].substr(0, 5));
               } else if (elem_name.hasClass('format-rp')) {
                  var nominal = response[key].toString();
                  elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
               } else {
                  elem_name.val(response[key]);
               }
            });
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 600);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 500);
            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
               icon: 'error',
            });
         }
      });
   }

   function edit_action2(url, modal_text) {
      save_method = 'edit';
      $("#modal_edit").modal('show');
      $(".modal-title").text(modal_text);
      $("#modal_loading").modal('show');
      $.ajax({
         url: url,
         type: "GET",
         dataType: "JSON",
         success: function(response) {
            Object.keys(response).forEach(function(key) {
               // console.log(response);
               var elem_name = $('[name=' + key + ']');
               if (elem_name.hasClass('selectric')) {
                  elem_name.val(response[key]).change().selectric('refresh');
               } else if (elem_name.hasClass('select2')) {
                  elem_name.select2("trigger", "select", {
                     data: {
                        id: response[key]
                     }
                  });
               } else if (elem_name.hasClass('selectgroup-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('my-ckeditor')) {
                  CKEDITOR.instances[key].setData(response[key]);
               } else if (elem_name.hasClass('summernote')) {
                  elem_name.summernote('code', response[key]);
               } else if (elem_name.hasClass('custom-control-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('time-format')) {
                  elem_name.val(response[key].substr(0, 5));
               } else if (elem_name.hasClass('format-rp')) {
                  var nominal = response[key].toString();
                  elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
               } else {
                  elem_name.val(response[key]);
               }
            });
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 600);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 500);
            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
               icon: 'error',
            });
         }
      });
   }

   function edit_action_sales_customer(url, modal_text) {
      save_method = 'edit';
      $("#modal_edit").modal('show');
      $(".modal-title").text(modal_text);
      $("#modal_loading").modal('show');
      $.ajax({
         url: url,
         type: "GET",
         dataType: "JSON",
         success: function(response) {
            // tampilkan input value #fc_salescode dari salesname
            // $('#fc_salescode').val(salesname);
            // console.log(response);
            Object.keys(response).forEach(function(key) {
               var elem_name = $('[name=' + key + ']');
               if (elem_name.hasClass('selectric')) {
                  elem_name.val(response[key]).change().selectric('refresh');
               } else if (elem_name.hasClass('select2')) {
                  console.log(response[key]);
                  elem_name.select2("trigger", "select", {
                     data: {
                        id: response[key]
                     }
                  });
               } else if (elem_name.hasClass('selectgroup-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('my-ckeditor')) {
                  CKEDITOR.instances[key].setData(response[key]);
               } else if (elem_name.hasClass('summernote')) {
                  elem_name.summernote('code', response[key]);
               } else if (elem_name.hasClass('custom-control-input')) {
                  $("input[name=" + key + "][value=" + response[key] + "]").prop('checked', true);
               } else if (elem_name.hasClass('time-format')) {
                  elem_name.val(response[key].substr(0, 5));
               } else if (elem_name.hasClass('format-rp')) {
                  var nominal = response[key].toString();
                  elem_name.val(nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1."));
               } else {
                  elem_name.val(response[key]);
               }
            });
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 600);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            setTimeout(function() {
               $('#modal_loading').modal('hide');
            }, 500);
            swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
               icon: 'error',
            });
         }
      });
   }


   function delete_action(url, nama) {
      swal({
            title: 'Apakah anda yakin?',
            text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: url,
                  type: "DELETE",
                  dataType: "JSON",
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     //  tb.ajax.reload(null, false);
                     //  console.log(response.status);
                     if (response.status == 200) {
                        // console.log(tb_debit);
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        if (typeof tb !== 'undefined') {
                           tb.ajax.reload(null, false);
                        }

                        if (typeof tb_so !== 'undefined') {
                           tb_so.ajax.reload(null, false);
                        }
                        if (typeof tbAddOn !== 'undefined') {
                           tbAddOn.ajax.reload(null, false);
                        }
                        if (typeof tb_lain !== 'undefined') {
                           tb_lain.ajax.reload(null, false);
                        }

                        if (typeof tb_debit !== 'undefined') {
                           tb_debit.ajax.reload(null, false);
                        }

                        if (typeof tb_kredit !== 'undefined') {
                           tb_kredit.ajax.reload(null, false);
                        }
                        //  location.href = location.href;
                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                        location.href = response.link;
                     } else {
                        swal(response.message, {
                           icon: 'error',
                        });
                     }

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   }

   function delete_action_dtl(url, nama) {
      swal({
            title: 'Apakah anda yakin?',
            text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: url,
                  type: "DELETE",
                  dataType: "JSON",
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     //  tb.ajax.reload(null, false);
                     //  console.log(response.status);
                     if (response.status == 200) {
                        // console.log(response);
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                        location.href = location.href;
                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                        location.href = location.href;
                     } else {
                        swal(response.message, {
                           icon: 'error',
                        });
                     }

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   }

   function delete_action_replace(url, nama) {
      swal({
            title: 'Apakah anda yakin?',
            text: 'Apakah anda yakin akan menghapus data ' + nama + "?",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
         })
         .then((willDelete) => {
            if (willDelete) {
               $("#modal_loading").modal('show');
               $.ajax({
                  url: url,
                  type: "DELETE",
                  dataType: "JSON",
                  success: function(response) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     //  tb.ajax.reload(null, false);
                     //  console.log(response.status);
                     if (response.status == 200) {
                        // console.log(response);
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                        $("#kekurangan").load(location.href + " #kekurangan");
                     } else if (response.status == 201) {
                        swal(response.message, {
                           icon: 'success',
                        });
                        $("#modal").modal('hide');
                        tb.ajax.reload(null, false);
                        location.href = response.link;
                     } else {
                        swal(response.message, {
                           icon: 'error',
                        });
                     }

                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     setTimeout(function() {
                        $('#modal_loading').modal('hide');
                     }, 500);
                     swal("Oops! Terjadi kesalahan segera hubungi tim IT (" + jqXHR.responseText + ")", {
                        icon: 'error',
                     });
                  }
               });
            }
         });
   }

   function reload() {
      tb.ajax.reload(null, false);

   }

   function b64toBlob(dataURI) {
      var byteString = atob(dataURI.split(',')[1]);
      var ab = new ArrayBuffer(byteString.length);
      var ia = new Uint8Array(ab);

      for (var i = 0; i < byteString.length; i++) {
         ia[i] = byteString.charCodeAt(i);
      }
      return new Blob([ab], {
         type: 'application/pdf'
      });
   }

   function reset_all_select() {
      $('.select2').each(function() {
         var name = $(this).attr("name");
         $('[name="' + name + '"]').select2().trigger('change');
      });

      $('.selectric').each(function() {
         var name = $(this).attr("name");
         $('[name="' + name + '"]').selectric();
      });
   }

   //return onkeyupRupiah(this.id);
   function onkeyupRupiah(id) {
      var rupiah = document.getElementById(id);
      rupiah.addEventListener('keyup', function(e) {
         rupiah.value = fungsiRupiah(this.value);
      });
   }

   //return onkeyupUppercase(this.id);
   function onkeyupUppercase(id) {
      var uppercase = document.getElementById(id);
      uppercase.addEventListener('keyup', function(e) {
         uppercase.value = this.value.toUpperCase();
      });
   }

   //return onkeyupLowercase(this.id);
   function onkeyupLowercase(id) {
      var lowercase = document.getElementById(id);
      lowercase.addEventListener('keyup', function(e) {
         lowercase.value = this.value.toLowerCase();
      });
   }

   //return onKeypressAngka(event,false);
   function onKeypressAngka(e, decimal) {
      var key;
      var keychar;
      if (window.event) {
         key = window.event.keyCode;
      } else if (e) {
         key = e.which;
      } else {
         return true;
      }
      keychar = String.fromCharCode(key);
      if ((key == null) || (key == 0) || (key == 8) || (key == 9) || (key == 13) || (key == 27)) {
         return true;
      } else if ((("0123456789").indexOf(keychar) > -1)) {
         return true;
      } else if (decimal && (keychar == ".")) {
         return true;
      } else {
         return false;
      }
   }

   function convertRupiah(angka) {
      var nominal = angka.toString();
      return nominal.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1.");
   }

   function fungsiRupiah(angka) {
      var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
         split = number_string.split(','),
         sisa = split[0].length % 3,
         rupiah = split[0].substr(0, sisa),
         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

      // tambahkan titik jika yang di input sudah menjadi angka ribuan
      if (ribuan) {
         separator = sisa ? '.' : '';
         rupiah += separator + ribuan.join('.');
      }
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return rupiah;
   }

   function fungsiRupiahSystem(angka) {
      let rupiah = angka.toLocaleString('id-ID', {
         style: 'currency',
         currency: 'IDR',
         minimumFractionDigits: 2,
      });

      return rupiah;
   }



   function convertToAngka(rupiah) {
      return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10).toString();
   }

   function base64ToPdfDownload(base64Pdf, filenamePdf) {
      const linkSource = base64Pdf;
      const downloadLink = document.createElement("a");
      const fileName = filenamePdf;
      downloadLink.href = linkSource;
      downloadLink.download = fileName;
      downloadLink.click();
   }

   function b64toBlob(dataURI) {
      var byteString = atob(dataURI.split(',')[1]);
      var ab = new ArrayBuffer(byteString.length);
      var ia = new Uint8Array(ab);

      for (var i = 0; i < byteString.length; i++) {
         ia[i] = byteString.charCodeAt(i);
      }
      return new Blob([ab], {
         type: 'application/pdf'
      });
   }


   function separator(id, char, every) {
      var elemId = document.getElementById(id);
      var value = elemId.value;
      var regrep = new RegExp(char, "g");
      var rep = value.replace(regrep, '');

      if (rep.length > 0) {
         var regex = new RegExp(".{1," + every + "}", "g");
         var fixValue = rep.match(regex).join(char);
         elemId.value = fixValue;
      }
   }
</script>