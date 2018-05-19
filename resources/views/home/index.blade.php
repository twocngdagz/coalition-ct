@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <br/>
            <form class="form-inline" role="form" method="POST" action="">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label class="sr-only" for="name">Product Name</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="name" name="name" placeholder="Product Name">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="quantity">Quantity</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="quantity" name="quantity" placeholder="Quantity">
                </div>
                <div class="form-group">
                    <label class="sr-only" for="price">Price</label>
                    <input type="text" class="form-control mb-2 mr-sm-2" id="price" name="price" placeholder="Price">
                </div>

                <button type="submit" class="btn btn-primary mb-2" id="submit_form">Submit</button>
            </form>
        </div>
    </div>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-12">
            <table class="datatables display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Quantity In Stock</th>
                        <th>Price Per Item</th>
                        <th>DateTime Submitted</th>
                        <th>Total Value Number</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
            <form>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Product Quantity:</label>
                    <input type="text" class="form-control" id="quantity" name="quantity">
                </div>
                <div class="form-group">
                    <label for="recipient-name" class="control-label">Product Price:</label>
                    <input type="text" class="form-control" id="price" name="price">
                </div>
            </form>
            </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="update_form">Update Product</button>
                </div>
            </div>
        </div>
    </div>
@endsection
