<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Offers') }}
        </h2>
    </x-slot>

    <div class="mt-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900 row">
            <div class="mb-3">
                @include('subscription.addPackage')
            </div>

            <div class="mb-3">
                @include('subscription.addCustomer')
            </div>
            
            <hr class="mb-4">
            @foreach ($packages as $package)
            <div class="col-12 mb-3 ml-3 block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold text-gray-900 dark:text-white">{{ $package['package_name'] }}</h5>
                {{-- <div class="card-title">{{ $package['package_name'] }}</div> --}}
                <h3 class="p-2">${{ $package['price'] }} <small>{{  $package['validity_duration'] == 1? 'Per Month' : 'Annually'  }} {{ $package['type'] }} </small></h3>
                <div class="p-2">Open for {{ $package['number_of_students'] }}<small> Students</small></div>
                <div class="{{ $package['is_active'] == 1 ? 'p-2 bg-green-300' : 'p-2 bg-rose-300' }}">{{ $package['is_active'] == 1 ? 'Active' : 'Not Active' }}</div>
                <div class="data">
                    <input class="d-none" id="package_id" value="{{ $package['stripe_price_id'] }}">
                <label for="#quantity_to_buy">Quantity to buy</label><input type="number" id="quantity_to_buy" value="1">
                <button type='button' id='subscribe-button'
                    class='subscribe-button w-100 mt-3 p-2 bg-green-500 hover:bg-green-700 text-white font-bold py2 px4 rounded {{ $package['is_active'] == 1 ? '' : 'disabled:opacity-50' }}' {{ $package['is_active'] == 1 ? '' : 'disabled' }}>Subscribe</button>
                </div>
                    {{-- TODO add a subscription here  --}}
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script>
    $('.subscribe-button').on('click', function(e) {
            console.log($('#package_id').text())
            priceId = $(this).closest('.data').find('#package_id').val()
            quantityToBuy = $(this).closest('.data').find('#quantity_to_buy').val()
            $.ajax({
            url: "/stripe",
            type: "POST",
            data:{_token:'{{ csrf_token() }}', priceId, quantityToBuy},
            success: function(response) {
                window.location.replace(response);
            },
            error: function(response) {
                console.log("Error", response.responseJSON);
            }
        });
    });
</script>