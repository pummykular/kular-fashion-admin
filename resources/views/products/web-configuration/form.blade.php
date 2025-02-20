
<div class="card">
    <div class="card-body">
        <!-- Product Images -->
        <h4 class="card-title mb-3">Product Images</h4>

        <div class="row">
            <div class="col-md-4">
                <label for="colorForImages">Select Color</label>
                <select name="color" id="colorForImages" class="form-control">
                    <option value="">Select Color</option>

                    @foreach ($product->colors as $color)
                        <option value="{{ $color->id }}"> {{ $color->colorDetail->name }} </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="colorForImages">Choose Images</label>
                <input type="file" class="form-control" id="productImages" name="images[]" accept="image/*" multiple="multiple" />
            </div>
        </div>
        <div id="imagePreview" class="row mt-2"></div>

        <div class="container">
            <div class="row">
                @foreach ($product->webImage as $image)
                    <div class="col-sm-3">
                        <img src="{{ asset($image->path) }}" alt="Product Images"
                            class="img-thumbnail" width="100px" height="100px">
                        <button type="button" class="btn btn-danger delete-btn mt-4"
                        data-source="image" data-endpoint="{{ route('product.destroy.image', $image->id)}}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Product Description -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Product Description</h4>
        <textarea name="product_desc" id="product_desc" class="editor" rows="2">{{ $product->webInfo->description ?? '' }}</textarea>
    </div>
</div>

<!-- Product Specification -->
<div class="card">
    <div class="card-body" id="product-specification">
        <h4 class="card-title">Product Specifications</h4>
        <div class="row" id="specification-container">
            @if (isset($product->webSpecification) && count($product->webSpecification) > 0)
                @foreach ($product->webSpecification as $specificationIndex => $specification)
                    <div class="col-md-6 specification-item mb-3" id="spec-0">
                        <div class="row">
                            <div class="col-md-5">
                                <x-form-input name="specifications[{{ $specificationIndex }}][key]"
                                    value="{{ $specification->key }}" label="Key"
                                    placeholder="Key" class="form-control" required="true" />
                            </div>

                            <div class="col-md-5">
                                <x-form-input
                                    name="specifications[{{ $specificationIndex }}][value]"
                                    value="{{ $specification->value }}" label="Value"
                                    placeholder="Value" class="form-control" required="true" />
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-danger delete-specification mt-4"
                                    data-spec-id="spec-0"><i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <button id="add-specification" class="btn btn-secondary mt-3">Add Specification</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Status & Visibility</h4>
        <div class="row">
            <div class="col-sm-4">
               <select name="visibilty" id="visibilty" class="form-control">
                <option value="0" @selected($product->webInfo->status ?? '' === '0')>Inactive</option>
                <option value="1" @selected($product->webInfo->status ?? '' === '1')>Active</option>
                <option value="2" @selected($product->webInfo->status ?? '' === '2')>Hide When Out Of Stock</option>
               </select>
            </div>
        </div>
    </div>
</div>

<!-- SEO -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">SEO</h4>
        <div class="row">
            <div class="col-sm-4">
                <div class="mb-3">
                    <x-form-input name="meta_title" label="Meta title" required="true"
                        value="{{ $product->webInfo->meta_title ?? '' }}"
                        placeholder="Meta title" />
                </div>
                <div class="mb-3">
                    <x-form-input name="meta_keywords" label="Meta Keywords"
                        value="{{ $product->webInfo->meta_keywords ?? '' }}"
                        placeholder="Meta Keywords" required="true" />
                </div>
            </div>
            <div class="col-sm-6">
                <div class="mb-3">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description" rows="5"
                        placeholder="Meta Description">{{ $product->webInfo->meta_description ?? '' }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary waves-effect waves-light">Save Changes</button>