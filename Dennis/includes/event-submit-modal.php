<div class="modal fade" id="eventSubmitModal" tabindex="-1" role="dialog" aria-labelledby="eventSubmitModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="event-form" class="form-horizontal" role="form" action="#">
				<input type="hidden" id="update" name="update" value="0">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="event-modal-title" id="eventSubmitModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="title" class="col-sm-3 control-label">Title</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
						</div>
					</div>
					<div class="form-group">
						<label for="start" class="col-sm-3 control-label">Start Date</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="start" name="start" placeholder="Enter date">
						</div>
					</div>
					<div class="form-group">
						<label for="end" class="col-sm-3 control-label">End Date</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="end" name="end" placeholder="Enter date">
						</div>
					</div>
					<div class="form-group">
						<label for="url" class="col-sm-3 control-label">URL</label>
						<div class="col-sm-8">
							<input type="url" class="form-control" id="url" name="url" placeholder="Enter url">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<div class="checkbox">
								<label>
									<input id="allDay" name="allDay" type="checkbox"> All day event?
								</label>
							</div>
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