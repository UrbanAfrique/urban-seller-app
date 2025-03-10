@if(count($paginationModel)>0)
    <tfoot>
    <tr>
        <td colspan="8" class="w3-center">
            {{ $paginationModel->links('components.proxy-pagination',[
                'route'=>'/a/seller/products'
                ]) }}
        </td>
    </tr>
    </tfoot>
@endif
