<div class="modal-dialog modal-lg" role="document">
  	<div class="modal-content">
  		<div class="modal-header no-print">
	      	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	      		<span aria-hidden="true">&times;</span>
	      	</button>
	      	<h4 class="modal-title no-print">
	      		@lang('crm::lang.proposal_sent_to', ['name' => $proposal->contact])
	      	</h4>
	    </div>
	    <div class="modal-body" id="printableArea">
	    	<div class="row">
	    		<div class="col-md-6">
					<p class="pull-left">
						<strong>{{__('crm::lang.sent_by')}}:</strong> {{$proposal->sent_by_full_name}}
					</p>
				</div>
        		<div class="col-md-6">
					<p class="pull-right">
						<strong>{{__('receipt.date')}}:</strong> {{@format_datetime($proposal->created_at)}}
					</p>
				</div>
			</div>
			<div class="row mt-10">
        		<div class="col-md-12">
					<p>
						<strong>CC:</strong> {{$proposal->cc}}
					</p>
				</div>
			</div>
			<div class="row mt-10">
        		<div class="col-md-12">
					<p>
						<strong>BCC:</strong> {{$proposal->bcc}}
					</p>
				</div>
			</div>
	    	<div class="row mt-10">
        		<div class="col-md-12">
					<p>
						<strong>{{__('crm::lang.subject')}}:</strong> {{$proposal->subject}}
					</p>
				</div>
			</div>
			<div class="row mt-10">
				<div class="col-md-12">
					<p>
						<strong>{{__('crm::lang.email_body')}}:</strong> {!!$proposal->body!!}
					</p>
				</div>
			</div>
			@if($proposal->media->count() > 0)
				<hr>
				<div class="row">
					<div class="col-md-6">
						<h4>
							{{__('crm::lang.attachments')}}
						</h4>
						@includeIf('crm::proposal_template.partials.attachment', ['medias' => $proposal->media])
					</div>
				</div>
			@endif
	    </div>
	    <div class="modal-footer no-print">
            <!-- Print button -->
	      	<button type="button" class="tw-dw-btn tw-dw-btn-neutral tw-text-white" data-dismiss="modal">@lang('messages.close')</button>
	      	<button type="button" class="tw-dw-btn tw-dw-btn-primary tw-text-white" onclick="printModalContent()">
                @lang('messages.print')
            </button>
	    </div>
  	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<script>
    function printModalContent() {
        var printContent = document.getElementById('printableArea').innerHTML;
        var originalContent = document.body.innerHTML;

        // Temporarily replace the body with the modal content
        document.body.innerHTML = printContent;
        
        // Print the modal content
        window.print();

        // Restore the original body content after printing
        document.body.innerHTML = originalContent;
        
        // Reinitialize modal (optional but recommended)
        location.reload();
    }
</script>