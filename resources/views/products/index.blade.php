@dump($products);

@foreach($products as $product)
    <div style="margin-bottom: 40px;">
        <h2>{{ $product->code }} - {{ $product->color }}</h2>
        <img src="{{ $product->image_url }}" width="300">
        <p>{{ $product->description }}</p>
        <h4>Typical Applications:</h4>
        <ul>
            @foreach($product->typicalApplications as $app)
                <li>{{ $app->application }}</li>
            @endforeach
        </ul>

        <h4>Automotive Specs:</h4>
        <ul>
            @foreach($product->automotiveSpecifications as $spec)
                <li>{{ $spec->specification }}</li>
            @endforeach
        </ul>

        <h4>Properties:</h4>
        @foreach(['Physical', 'Mechanical', 'Impact', 'Thermal', 'Other'] as $type)
            <h5>{{ $type }}</h5>
            <ul>
                @foreach($product->properties->where('type', $type) as $prop)
                    <li>{{ $prop->name }} - {{ $prop->value }} {{ $prop->unit }} ({{ $prop->standard }})</li>
                @endforeach
            </ul>
        @endforeach
    </div>
@endforeach
