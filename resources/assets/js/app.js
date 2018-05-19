$(document).ready(function() {
    var products = $('.datatables').DataTable({
        "columns": [
            { "visible": false },
            null,
            null,
            null,
            null,
            null,
        ],
        "stateSave": true,
        "processing": true,
        "serverSide": true,
        "ajax": "/product",
        "ordering": false,
        "info": false,
        "searching": false,
        "lengthChange": false,
        "paging": false,
    });

    $(document).on('submit', '#product-form', function(e) {
        e.preventDefault();

        $.ajax({
            'data': {
                '_token': $("input[name='_token']").val(),
                'name': $("input[name='name']").val(),
                'quantity': $("input[name='quantity']").val(),
                'price': $("input[name='price']").val(),
            },
            'url': '/product',
            'method': 'POST'
        }).done(function(data, status, error) {
            $("input[name='name']").val('');
            $("input[name='quantity']").val('');
            $("input[name='price']").val('');
            products.draw(false);
        });
    });

    $(document).on('click', '#update_form', function(e) {
        e.preventDefault();
        $.ajax({
            'data': {
                '_token': $("#productModal input[name='_token']").val(),
                'id': $("#productModal input[name='id']").val(),
                'name': $("#productModal input[name='name']").val(),
                'quantity': $("#productModal input[name='quantity']").val(),
                'price': $("#productModal input[name='price']").val(),
            },
            'url': '/product/edit',
            'method': 'POST'
        }).done(function(data, status, error) {
            $('#productModal').modal('hide');
        });
    })

    $('.datatables tbody').on( 'click', 'tr', function () {
        var product = products.row( this ).data();
        if (product[0] != '')
        {
            $('#productModal').data('product', product);
            $('#productModal').modal('show')
        }
    });
    $('#productModal').on('show.bs.modal', function (event) {
        var data = $(this).data('product') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('#id').val(data[0])
        modal.find('#name').val(data[1])
        modal.find('#quantity').val(data[2])
        modal.find('#price').val(data[3])
    })

    $('#productModal').on('hidden.bs.modal', function (event) {
        products.draw(false);
    });
    products.column(0).visible(false);
});
