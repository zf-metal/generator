<?php

return [
    'zf-metal-datagrid.options' => array(
        'recordsPerPage' => 10,
        'templates' => array(
            'ZfMetal_Generator' => array(
                'form_view' => 'zf-metal/datagrid/form/form-ajax-2col',
                'grid_view' => 'zf-metal/datagrid/grid/grid-ajax',
                'detail_view' => 'zf-metal/datagrid/detail/detail-ajax',
                'pagination_view' => 'zf-metal/datagrid/pagination/pagination-ajax'
            )
        ),
    ),
];
