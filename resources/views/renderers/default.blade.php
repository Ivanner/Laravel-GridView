@php
/**
* @var \Woo\GridView\GridView $grid
**/
    $paginator = $grid->getPagination();
    $thisStart = 1 + ($paginator->currentPage() - 1) * $paginator->perPage();
    $thisEnd = $paginator->currentPage() * $paginator->perPage()
@endphp

<div class="grid-view-container">
    <grid-view
        inline-template
        id="grid-{{ $grid->getId() }}"
        :origin-filters='@json($filters)'
        sort-column="{{ $grid->getRequest()->sortColumn }}"
        sort-order="{{ $grid->getRequest()->sortOrder }}"
        ajax-update={{ $grid->ajaxUpdate }}
        target-url="{{ $grid->targetUrl }}"
    >
        <div>
            @include('woo_gridview::grid-form')
            @if ($paginator->hasPages() && $grid->enablePagination)
                <div class="summary">Displaying {{$thisStart}}-{{$thisEnd}} of {{$paginator->total()}} results.</div>
            @endif
            <table {!! $grid->compileTableHtmlOptions() !!}>
                <thead>
                @if ($grid->showFilters && $grid->filterPosition == \Woo\GridView\GridView::FILTER_POS_HEADER)
                    <tr>
                        @foreach ($grid->columns as $column)
                            <th>
                                @if ($column->filter)
                                    {!! $column->filter->render($grid) !!}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                @endif
                    <tr>
                        @foreach ($grid->columns as $column)
                            <th {!! $column->compileHeaderHtmlOptions() !!}>
                                @if ($column->getSortableName() !== false && $column->sortable)
                                    <a href="#" v-on:click.prevent="sort('{{ $column->getSortableName() }}')">{{ $column->title }}</a>
                                @else
                                    {{ $column->title }}
                                @endif

                                @if ($column->sortable)
                                    @if ($grid->getRequest()->sortColumn == $column->value)
                                        <span class="sort-{{ strtolower($grid->getRequest()->sortOrder) }}"></span>
                                    @endif
                                @endif
                            </th>
                        @endforeach
                    </tr>
                    @if ($grid->showFilters && $grid->filterPosition == \Woo\GridView\GridView::FILTER_POS_BODY)
                        <tr>
                            @foreach ($grid->columns as $column)
                                <th>
                                    @if ($column->filter)
                                        {!! $column->filter->render($grid) !!}
                                    @endif
                                </th>
                            @endforeach
                        </tr>
                    @endif
                </thead>
                <tbody>
                @forelse ($paginator->items() as $row)
                    <tr>
                        @foreach ($grid->columns as $column)
                            <td {!! $column->compileContentHtmlOptions(['model' => $row]) !!}>
                                {!! $column->renderValue($row) !!}
                            </td>
                        @endforeach
                    </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($grid->columns) }}" class="text-center">
                                No data to display
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                @if ($grid->showFilters && $grid->filterPosition == \Woo\GridView\GridView::FILTER_POS_FOOTER)
                    <tr>
                        @foreach ($grid->columns as $column)
                            <th>
                                @if ($column->filter)
                                    {!! $column->filter->render($grid) !!}
                                @endif
                            </th>
                        @endforeach
                    </tr>
                @endif
                </tfoot>
                @if ($grid->rowsPerPage != 0 && $grid->enablePagination)
                    <caption>
                        {!! $paginator->render('woo_gridview::grid-pagination', ['gridId' => $grid->getId()]) !!}
                    </caption>
                @endif
            </table>
        </div>
    </grid-view>
</div>

@if ($grid->standaloneVue)
<script src="{{ asset('vendor/grid-view/grid-view.bundle.js')  }}"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
@endif
