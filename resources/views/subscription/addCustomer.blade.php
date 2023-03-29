<!-- Button trigger modal -->
<button type="button" class="p-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
    data-bs-toggle="modal" data-bs-target="#add-customer-modal">
    Add Customer
</button>

<!-- Modal -->
<div class="modal" id="add-customer-modal" tabindex="-1" aria-labelledby="add-customer-modal-label" aria-hidden="true"
    tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-customer-modalLabel">Add Customer Information</h5>
                <button type="button" class="p-3 text-gray-500 hover:text-gray-700 font-bold" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                {{-- action="{{ route('customers.store') }}" method="POST" --}}
                <form id="customer-form" method="POST" action="/stripe">
                    @csrf
                    <div class="mb-4 form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}"  
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50 disabled:true">
                    </div>
                    <div class="mb-4 form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}"  
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50 disabled:true">
                    </div>
                    <div class="mb-4 form-group">
                        <label for="address-line1" class="block text-sm font-medium text-gray-700">Address Line 1</label>
                        <input type="text" name="line1" id="line1"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50">
                    </div>
                    <div class="mb-4 form-group">
                        <label for="address-postal-code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                        <input type="text" name="postal_code" id="postal-code"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50">
                    </div>

                    <div class="mb-4 form-group">
                        <label for="address-country" class="block text-sm font-medium text-gray-700 ">Country</label>
                        <input type="text" name="country" id="country"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50">
                    </div>

                    <div class="mb-4 form-group">
                        <label for="address-city" class="block text-sm font-medium text-gray-700 ">City</label>
                        <input type="text" name="city" id="city"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50">
                    </div>

                    <div class="mb-4 form-group">
                        <label for="address-state" class="block text-sm font-medium text-gray-700 ">State</label>
                        <input type="text" name="state" id="state"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm  focus:border-indigo-300  focus:ring  focus:ring-indigo-200  focus:ring-opacity-50">
                            <!-- Other options-->
                    </div>
                    <!-- Stripe token input-->
                    <!-- Submit button-->
                    <input type='hidden' name='created_by' value="{{ Auth::id() }}">
                    <input type='hidden' name='updated_by' value="{{ Auth::id() }}">
                    <input type='hidden' name="id" id="id" value="{{ Auth::id() }}">
                    
                    <div class="modal-footer">
                        <button type='button' id='submit-customer-form'
                            class='p-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>Save
                            Customer Info</button>
                        <button type='button' data-bs-dismiss="modal" aria-label="Close"
                            class='close-modal p-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded'>Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
    crossorigin="anonymous"></script>
<script>
    $('#submit-customer-form').on('click', function(e) {
        e.preventDefault();

        let data = $("#customer-form").serialize();

        $.ajax({
            url: "/customers",
            type: "POST",
            data: data,
            success: function(response) {
                console.log('Succeess', response.message);
                flasher.success(response.message);
                $('#add-customer-modal').modal('hide');
                $("#add-customer-modal").removeClass("in");
                $(".modal-backdrop").remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $("#add-customer-modal").hide();
                $('.invalid-feedback').remove()
                $("form :input").val('')
            },
            error: function(response) {
                console.log("Error", response.responseJSON);
                if (response.responseJSON.errors) {
                    console.log('error', response.responseJSON.message);
                    flasher.error(response.responseJSON.message);
                    for (const key in response.responseJSON.errors) {
                        console.log(response.responseJSON.errors[key]);
                        const element = $(`[name='${key}']`);
                        $(element).closest('.form-group ').find('.invalid-feedback').remove();
                        $(`<span class="invalid-feedback d-flex mb-2" role="alert">
                            <strong>${response.responseJSON.errors[key]}</strong>
                        </span>`).insertAfter($(element).closest('.form-group '));
                    }
                }
            }
        });

        $("form :input").keyup(function() {
            $(this).closest('.form-group ').find('.invalid-feedback').remove();
        });
    });
</script>