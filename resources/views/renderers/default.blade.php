@php
/**
* @var \Woo\GridView\GridView $grid
**/
    $paginator = $grid->getPagination();
    $dataset = [
        'paginator' => [
            'first' => 1 + ($paginator->currentPage() - 1) * $paginator->perPage(),
            'last' => $paginator->currentPage() * $paginator->perPage(),
            'currentPage' => $paginator->currentPage()
        ],
        'columns' => $grid->columns
    ];

@endphp

<div class="grid-view-container"
     id="grid-{{ $grid->getId() }}">
    <grid-view
        :initial-filters='@json($filters)'
        sort-column="{{ $grid->getRequest()->sortColumn }}"
        sort-order="{{ $grid->getRequest()->sortOrder }}"
        :ajax-update="{{ $grid->ajaxUpdate?"true":"false" }}"
        target-url="{{ $grid->targetUrl }}"
        :enable-pagination="{{ $grid->enablePagination?"true":"false" }}",
        :dataset='@json($dataset)'
    >


    </grid-view>
</div>

@if ($grid->standaloneVue)
<script src="{{ asset('vendor/grid-view/grid-view.bundle.js')  }}"></script>
<script>
    window.GridViewShared = @json([]);
    new WooGridView('#grid-{{ $grid->getId() }}');
</script>
@endif
