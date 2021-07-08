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
        id="grid-{{ $grid->getId() }}"
        :origin-filters='@json($filters)'
        sort-column="{{ $grid->getRequest()->sortColumn }}"
        sort-order="{{ $grid->getRequest()->sortOrder }}"
        :ajax-update="{{ $grid->ajaxUpdate?"true":"false" }}"
        target-url="{{ $grid->targetUrl }}"
        :enable-pagination="{{ $grid->enablePagination?"true":"false" }}"
    >
        <div>
            <div class="summary" v-if="showPagination">Displaying @{{dataset.pagination.first}}-@{{dataset.pagination.last}} of @{{dataset.pagination.total}} results.</div>
            <table>
                <thead>
                <tr v-if="columns.length">
                    <th v-for="column in columns">
                        {{ column.name }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td :colspan="columns.length" class="text-center">
                        No data to display
                    </td>
                </tr>
                </tbody>
                <caption v-if="showPagination">
                    <ul class="pagination">
                        <li v-for="link in dataset.pagination.links" :key="link.label" v-if="link.url"
                            class="page-item" :class="{disabled: link.disabled, active: link.active}">
                            <a class="page-link"
                               href="#"
                               @click.prevent="fetchData(link.url)"
                               v-html="link.label"
                            >
                            </a>
                        </li>
                    </ul>
                </caption>
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
