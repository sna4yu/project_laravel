<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">@lang('socialmanagement::lang.add_category')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="category_add_form" method="POST" action="{{ route('social-categories.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">@lang('lang_v1.name'):</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">@lang('lang_v1.description'):</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </form>
        </div>
    </div>
</div>
