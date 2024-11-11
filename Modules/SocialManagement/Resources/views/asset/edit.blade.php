<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editAssetModalLabel">@lang('socialmanagement::lang.edit_asset')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="edit_asset_form" method="POST" action="{{ route('social.update', $social->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="asset_id">@lang('socialmanagement::lang.asset_id'):</label>
                    <input type="text" class="form-control" id="asset_id" name="asset_id" value="{{ $social->asset_id }}" required>
                </div>
                <div class="form-group">
                    <label for="name">@lang('socialmanagement::lang.asset_name'):</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $social->name }}" required>
                </div>
                <div class="form-group">
                    <label for="social_category_id">@lang('socialmanagement::lang.asset_category'):</label>
                    <select class="form-control" id="social_category_id" name="social_category_id">
                        @foreach ($asset_categories as $id => $category)
                            <option value="{{ $id }}" {{ $social->social_category_id == $id ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">@lang('socialmanagement::lang.email'):</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $social->email }}" required>
                </div>
                <div class="form-group">
                    <label for="password">@lang('socialmanagement::lang.password'):</label>
                    <input type="text" class="form-control" id="password" name="password" value="{{ $social->password }}" required>
                </div>
                <div class="form-group">
                    <label for="link">@lang('socialmanagement::lang.link'):</label>
                    <input type="url" class="form-control" id="link" name="link" value="{{ $social->link }}">
                </div>
                <div class="form-group">
                    <label for="assign_to">@lang('socialmanagement::lang.assign_to'):</label>
                    <select class="form-control" id="assign_to" name="assign_to">
                        @foreach ($users as $id => $user)
                            <option value="{{ $id }}" {{ $social->assign_to == $id ? 'selected' : '' }}>
                                {{ $user }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">@lang('lang_v1.description'):</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ $social->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </form>
        </div>
    </div>
</div>
