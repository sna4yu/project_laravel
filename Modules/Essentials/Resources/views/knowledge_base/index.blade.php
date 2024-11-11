@extends('layouts.app')

@section('title', __('essentials::lang.knowledge_base'))

@section('content')
@include('essentials::layouts.nav_essentials')
<section class="content">
    <div class="box box-solid">
        <div class="box-header">
            <h4 class="box-title">@lang('essentials::lang.knowledge_base')</h4>
            <div class="box-tools pull-right">
                <a href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create']) }}" class="tw-dw-btn tw-bg-gradient-to-r tw-from-indigo-600 tw-to-blue-500 tw-font-bold tw-text-white tw-border-none tw-rounded-full pull-right">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                         class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M12 5l0 14"/>
                        <path d="M5 12l14 0"/>
                    </svg> @lang('Add')
                </a>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <thead>
                   <tr>
    <th style="width: 5%;">@lang('essentials::lang.actions')</th>
    <th style="width: 30%;">@lang('essentials::lang.title')</th>
    <th style="width: 65%;">@lang('essentials::lang.content')</th>
</tr>

                </thead>
                <tbody>
                    @php $kbCount = 1; @endphp
                    @foreach($knowledge_bases as $kb)
                        <!-- Knowledge Base Row -->
                        <tr class="kb-row" data-id="{{ $kb->id }}">
                          <td style="text-align: left;">
                               <div class="dropdown">
<button class="btn dropdown-toggle" type="button" id="actionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #007bff; background: transparent; color: #007bff;">
    @lang('Details')
</button>

    <div class="dropdown-menu" aria-labelledby="actionsDropdown">
    <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create']) }}?parent={{ $kb->id }}" title="@lang('essentials::lang.add_section')">
            <i class="fas fa-plus" style="color: #007bff;"></i> @lang('essentials::lang.add_section')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$kb->id]) }}" title="@lang('messages.view')">
            <i class="fas fa-eye" style="color: #17a2b8;"></i> @lang('messages.view')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$kb->id]) }}" title="@lang('messages.edit')">
            <i class="fas fa-edit" style="color: #007bff;"></i> @lang('messages.edit')
        </a>
        <a class="dropdown-item delete-kb" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$kb->id]) }}" title="@lang('messages.delete')">
            <i class="fas fa-trash" style="color: #dc3545;"></i> @lang('messages.delete')
        </a>
    </div>
</div>

                                 <td style="text-align: left; cursor: pointer;" onclick="toggleSections({{ $kb->id }})"><strong>{{ $kbCount }}. {{ $kb->title }}</strong></td>
                                 
                            </td>
                        </tr>

                        <!-- Sections under Knowledge Base -->
                        @php $sectionCount = 1; @endphp
                        @foreach($kb->children as $section)
                        <tr class="section-row section-{{ $kb->id }}" data-id="{{ $section->id }}" style="display: none;">
                            
                            <td style="text-align: left;">
                                <div class="dropdown">
    <button class="btn dropdown-toggle" type="button" id="actionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #007bff; background: transparent; color: #007bff;">
    @lang('Details')
</button>

    <div class="dropdown-menu" aria-labelledby="actionsDropdown{{ $section->id }}">
    	<a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create']) }}?parent={{ $section->id }}" title="@lang('essentials::lang.add_article')">
            <i class="fas fa-plus" style="color: #28a745;"></i> @lang('essentials::lang.add_article')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create']) }}?parent={{ $kb->id }}" title="@lang('essentials::lang.add_section')">
            <i class="fas fa-plus" style="color: #007bff;"></i> @lang('essentials::lang.add_section')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$section->id]) }}" title="@lang('messages.view')">
            <i class="fas fa-eye" style="color: #17a2b8;"></i> @lang('messages.view')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$section->id]) }}" title="@lang('messages.edit')">
            <i class="fas fa-edit" style="color: #007bff;"></i> @lang('messages.edit')
        </a>
        <a class="dropdown-item delete-kb" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$section->id]) }}" title="@lang('messages.delete')">
            <i class="fas fa-trash" style="color: #dc3545;"></i> @lang('messages.delete')
        </a>
    </div>
</div>

                                <td style="padding-left: 20px; text-align: left; cursor: pointer;" onclick="toggleArticles({{ $section->id }})">{{ $kbCount }}-{{ $sectionCount }}.{{ $section->title }}</td>
                            
                         
                            </td>
                        </tr>

                        <!-- Articles under Section -->
                        @php $articleCount = 1; @endphp
                        @foreach($section->children as $article)
                        <tr class="article-row article-{{ $section->id }}" style="display: none;"> 
                            <td style="text-align: left;">
                                <div class="dropdown">
    <button class="btn dropdown-toggle" type="button" id="actionsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border: 1px solid #007bff; background: transparent; color: #007bff;">
    @lang('Details')
</button>

    <div class="dropdown-menu" aria-labelledby="actionsDropdown{{ $article->id }}">
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'create']) }}?parent={{ $section->id }}" title="@lang('essentials::lang.add_article')">
            <i class="fas fa-plus" style="color: #28a745;"></i> @lang('essentials::lang.add_article')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'show'], [$article->id]) }}" title="@lang('messages.view')">
            <i class="fas fa-eye" style="color: #17a2b8;"></i> @lang('messages.view')
        </a>
        <a class="dropdown-item" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'edit'], [$article->id]) }}" title="@lang('messages.edit')">
            <i class="fas fa-edit" style="color: #007bff;"></i> @lang('messages.edit')
        </a>
        <a class="dropdown-item delete-kb" href="{{ action([\Modules\Essentials\Http\Controllers\KnowledgeBaseController::class, 'destroy'], [$article->id]) }}" title="@lang('messages.delete')">
            <i class="fas fa-trash" style="color: #dc3545;"></i> @lang('messages.delete')
        </a>
    </div>
</div>

                                <td style="padding-left: 40px; text-align: left;">{{ $kbCount }}-{{ $sectionCount }}-{{ $articleCount }}.{{ $article->title }}</td>
                         <td style="padding-left: 40px;">
    @if(!empty(trim(strip_tags($article->content))))
      {!! $article->content !!}
    @endif
</td>
                            
                            </td>
                        </tr>
                        @php $articleCount++; @endphp
                        @endforeach
                        @php $sectionCount++; @endphp
                    @endforeach
                    @php $kbCount++; @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
    function toggleSections(kbId) {
        $(`.section-${kbId}`).toggle(); // Toggle visibility of sections for the clicked Knowledge Base item
        $(`.section-${kbId} .article-row`).hide(); // Hide all articles within the sections by default
    }

    function toggleArticles(sectionId) {
        $(`.article-${sectionId}`).toggle(); // Toggle visibility of articles for the clicked Section item
    }

    $(document).ready(function () {
        $('.delete-kb').click(function (e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            }).then(willDelete => {
                if (willDelete) {
                    var href = $(this).attr('href');
                    var data = $(this).serialize();

                    $.ajax({
                        method: 'DELETE',
                        url: href,
                        dataType: 'json',
                        data: data,
                        success: function (result) {
                            if (result.success === true) {
                                toastr.success(result.msg);
                            } else {
                                toastr.error(result.msg);
                            }

                            location.reload();
                        },
                    });
                }
            });
        });
    });
</script>
@endsection