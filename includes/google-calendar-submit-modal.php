<div class="modal fade" id="googleCalendarSubmitModal" tabindex="-1" role="dialog" aria-labelledby="googleCalendarModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="google-calendar-form" class="form-horizontal" role="form" action="#">
				<input type="hidden" id="update" name="update" value="0">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="google-calendar-title" id="googleCalendarModalLabel">Link Google Calendar</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="title" class="col-sm-3 control-label">URL</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="url" name="url" placeholder="Enter url">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
	</div>
</div>