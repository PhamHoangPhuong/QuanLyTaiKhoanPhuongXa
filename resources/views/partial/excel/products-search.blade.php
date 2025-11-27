<form action="{{ route('index') }}" method="GET" enctype="multipart/form-data">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card p-3 shadow-sm">
                <!-- phần input chia đều 7 cột -->
                <div class="row gx-2 gy-2 align-items-end mb-3">
                    <div class="col">
                        <label for="product_id" class="form-label mb-0">Product_Id</label>
                        <input type="text" name="product_id" id="product_id" class="form-control" value="{{ request('product_id') }}">
                    </div>

                    <div class="col">
                        <label for="name" class="form-label mb-0">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search by name">
                    </div>

                    <div class="col">
                        <label for="color" class="form-label mb-0">Color</label>
                        <input type="text" name="color" id="color" class="form-control" value="{{ request('color') }}" placeholder="Color">
                    </div>

                    <div class="col">
                        <label for="cost" class="form-label mb-0">Min Cost</label>
                        <input type="number" name="cost" id="cost" class="form-control" value="{{ request('cost') }}">
                    </div>

                    <div class="col">
                        <label for="price" class="form-label mb-0">Max Price</label>
                        <input type="number" name="price" id="price" class="form-control" value="{{ request('price') }}">
                    </div>

                    <div class="col">
                        <label for="subcategory_id" class="form-label mb-0">Subcategory_Id</label>
                        <select class="form-control" id="subcategory" name="subcategory_id"> 
                            <option value="">-- Select Subcategory --</option>
                            <!-- $subcategories = DB::table('product_subcategory')->get(); -->
                            @isset($subcategories)
                                @foreach($subcategories as $subcategory)
                                    <!-- Cần ID thì mới truyền vào được (VD: <option value="1">Smartphones</option>) -->
                                    <option value="{{ $subcategory->subcategory_id }}">
                                        {{ $subcategory->subcategory_id }} - {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="col">
                        <label for="model_id" class="form-label mb-0">Model_Id</label>
                        <select class="form-control" id="model" name="model_id">
                            <option value="">-- Select Model --</option>
                            @isset($models)
                                @foreach($models as $model)
                                    <option value="{{ $model->model_id }}">
                                        {{ $model->model_id }} - {{ $model->name }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                </div>

                <!-- nút Search giữ nguyên ở dưới -->
                <div class="row">
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
