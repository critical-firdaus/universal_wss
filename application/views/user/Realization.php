
<!--  content -->
<div class="content-wrapper">
	<div class="row">
		<div class="col-xs-12" style="width: 100%;">
			<div class="box">
				<div class="box-header">
				</div>
				<!-- /.box-header -->
				<div class="box-body">

					<section class="container-fluid" style="overflow-y: auto; overflow-x: scroll;">
						<div class="dropdown">
							
    						<h2 class="text-center"><b>REALIZATION</b></h2>

    						<button class="btn" onclick="add()"><i class="glyphicon glyphicon-plus"></i>Tambah</button>
							<button class="btn btn-custome1" id="btnn2" onclick="reload_table()"><i
									class="glyphicon glyphicon-refresh"></i> REFRESH</button>
						</div> <br />

						<table id="table" class="table  table-hover display nowrap" cellspacing="0"
							width="100%" style="border-radius: 5px 5px 0 0 ;
					        overflow: hidden;
					        box-shadow: 0 0 20px rgba(0,0,0,0.15); ">

							<thead style="color: white;">
								<tr>
									<th>No <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Id Realization <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>WSS Daily Tonnage <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Warehouse Daily Tonnage <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Information <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Date <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Document Realization <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th>Id User <img src="<?php echo base_url('assets/css_wss/sort.png'); ?>" width="10"></th>
									<th style="width:125px;">Action</th>
								</tr>
							</thead>

							<tbody style="text-align: center;">
							</tbody>

							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
								</tr>
							</tfoot>

						</table><br><br>

					</section>
				</div>
				<!-- /.box-body -->
			</div>
		</div>
		<!-- /.col -->
	</div>
</div>
<!-- akhir content -->

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


<script type="text/javascript">
	var save_method; 
	var table;
	var base_url = '<?php echo base_url();?>';
	$(document).ready(function () {
		table = $('#table').DataTable({
			"processing": true, 
			"serverSide": true,
			"order": [], 
			"ajax": {
				"url": "<?php echo site_url('User/ajax_list3')?>",
				"type": "POST"
			},
			"columnDefs": [{
					"targets": [-1],
					"orderable": false, 
				},
				{
					"targets": [-2],
					"orderable": false, 
				},
			],

		});
		$('.datepicker').datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
			todayHighlight: true,
			orientation: "top auto",
			todayBtn: true,
			todayHighlight: true,
		});
		$("input").change(function () {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});
		$("textarea").change(function () {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});
		$("select").change(function () {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});

	});
	function add() {
		save_method = 'add';
		$('#form')[0].reset(); 
		$('.form-group').removeClass('has-error'); 
		$('.help-block').empty(); 
		$('#modal_form').modal('show'); 
		$('.modal-title').text('Add Realization'); 
		$('#Document_Realization-preview').hide();
		$('#label-Document_Realization').text('Upload dokumen');
	}

	function edit(id) {
		save_method = 'update';
		$('#form')[0].reset();
		$('.form-group').removeClass('has-error');
		$('.help-block').empty();
		$.ajax({
			url: "<?php echo site_url('User/ajax_edit3')?>/" + id,
			type: "GET",
			dataType: "JSON",
			success: function (data) {
				$('[name="Id_Realization"]').val(data.Id_Realization);
				$('[name="WSS_Daily_Tonnage"]').val(data.WSS_Daily_Tonnage);
				$('[name="Warehouse_Daily_Tonnage"]').val(data.Warehouse_Daily_Tonnage);
				$('[name="Information"]').val(data.Information);
				$('[name="Date"]').val(data.Date);
				$('[name="Document_Realization"]').val(data.Document_Realization);
				$('[name="Id_User"]').val(data.Id_User);
				$('#modal_form').modal('show'); 
				$('.modal-title').text('Edit Realization');
				$('#Document_Realization-preview').show();

				if (data.Document_Realization) {
					$('#label-Document_Realization').text('Change Document_Realization');
					$('#Document_Realization-preview div').html('<img src="' + base_url + 'upload_realization/' + data.Document_Realization +
						'" class="img-responsive">');
					$('#Document_Realization-preview div').append('<input type="checkbox" name="remove_Document_Realization" value="' + data
						.Document_Realization + '"/> Remove Document_Realization when saving');
				} else {
					$('#label-Document_Realization').text('Upload Document_Realization');
					$('#Document_Realization-preview div').text('(No Document_Realization)');
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error get data from ajax');
			}
		});
	}

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}

	function save() {
		$('#btnSave').text('saving...'); //change button text
		$('#btnSave').attr('disabled', true); //set button disable 
		var url;

		if (save_method == 'add') {
			url = "<?php echo site_url('User/ajax_add3')?>";
		} else {
			url = "<?php echo site_url('User/ajax_update3')?>";
		}
		var formData = new FormData($('#form')[0]);
		$.ajax({
			url: url,
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			dataType: "JSON",
			success: function (data) {

				if (data.status) //if success close modal and reload ajax table
				{
					$('#modal_form').modal('hide');
					reload_table();
				} else {
					for (var i = 0; i < data.inputerror.length; i++) {
						$('[name="' + data.inputerror[i] + '"]').parent().parent().addClass(
						'has-error'); //select parent twice to select div form-group class and add has-error class
						$('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[
						i]); //select span help-block class set text error string
					}
				}
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 


			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('Error adding / update data');
				$('#btnSave').text('save'); //change button text
				$('#btnSave').attr('disabled', false); //set button enable 

			}
		});
	}

	function delete_realization(id) {
		if (confirm('Are you sure delete this data?')) {
			// ajax delete data to database
			$.ajax({
				url: "<?php echo site_url('User/ajax_delete3')?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function (data) {
					//if success reload ajax table
					$('#modal_form').modal('hide');
					reload_table();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});

		}
	}

</script>

<!-- modal ane -->
<div class="modal" id="modal_form" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h class="modal-title"></h><!-- c -->
      </div>
      <div class="modal-body form">
        <form action="#" id="form">
        	<div class="form-group">
        	</div>

        	<div class="row">
 
        	<div class="col-md-6">

				<div class="form-group">
				    <label>Id Realization</label>
				    <input type="number" class="form-control" id="Id_Realization" name="Id_Realization" placeholder="Ditentukan Sistem" readonly>
			    </div>
				<div class="form-group">
					<label>WSS Daily Tonnage</label>
					<input type="number" class="form-control" id="WSS_Daily_Tonnage" name="WSS_Daily_Tonnage" placeholder="Masukan WSS_Daily_Tonnage">
				</div>
				<div class="form-group">
					<label>Date</label>
					<input type="Date" class="form-control" id="Date" name="Date" placeholder="Masukan Date">
				</div>


  				<div class="input-group" id="Document_Realization-preview">
					<label>Document Realization</label>
					<div>
						(No dokumen Realization)
						<span class="help-block"></span>
					</div>
				</div>

				<div class="input-group" style="margin-top: 10px;">
					<label id="label-Document_Realization">Upload Document Realization </label>
					<div>
						<input name="Document_Realization" type="file">
						<span class="help-block"></span>
					</div>
				</div>
        	</div>

        	<div class="col-md-6">
        		<div class="form-group">
					<label>Warehouse Daily Tonnage</label>
					<input type="text" class="form-control" id="Warehouse_Daily_Tonnage" name="Warehouse_Daily_Tonnage" placeholder="Masukan Warehouse_Daily_Tonnage">
				</div>	
			    <div class="form-group">
					<label>Information</label>
					<input type="text" class="form-control" id="Information" name="Information" placeholder="Masukan Information">
				</div>
        	</div>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="reset()">Close</button>
        <button type="button" class="btn btn-primary" id="btnSave" onclick="save()">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- #modal ane -->
</section>
</div>
