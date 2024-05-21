<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="product_catalogue_id" class="form-control setUpSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option {{
                            $key == old('product_catalogue_id', (isset($product->product_catalogue_id)) ? $product->product_catalogue_id : '') ? 'selected' : ''
                            }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
        $catalogue = [];
        if(isset($product)){
        foreach($product->product_catalogues as $key => $val){
        $catalogue[] = $val->id;
        }
        }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.subparent') }}</label>
                    <select multiple name="catalogue[]" class="form-control setUpSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option @if(is_array(old('catalogue', ( isset($catalogue) && count($catalogue)) ? $catalogue : []) ) && isset($product->product_catalogue_id) && $key !== $product->product_catalogue_id && in_array($key, old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@include('backend.dashboard.component.publish', ['model' => ($product) ?? null])
