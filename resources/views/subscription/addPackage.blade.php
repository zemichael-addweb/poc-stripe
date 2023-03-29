<!-- Button trigger modal -->
<button type="button" class="p-2 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
    data-bs-toggle="modal" data-bs-target="#add-package-modal">
    Add Package
</button>

<!-- Modal -->
<div class="modal" id="add-package-modal" tabindex="-1" aria-labelledby="add-package-modal-label" aria-hidden="true"
    tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add-package-modalLabel">Add Package</h5>
                <button type="button" class="p-3 text-gray-500 hover:text-gray-700 font-bold" data-bs-dismiss="modal"
                    aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                {{-- action="{{ route('packages.store') }}" method="POST" --}}
                <form id="package-form" class="mt-3">
                    @csrf
                    <div class="mb-3 form-group">
                        <label for="package_name" class="block text-sm font-medium text-gray-700">Package
                            Name</label><input type="text" name="package_name" id="package_name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea type="number" name="description" id="description" step="0.01" min="0"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('description') }}"></textarea>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" step="0.01" min="0"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('price') }}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="number_of_students" class="block text-sm font-medium text-gray-700">Number of
                            Students</label>
                        <input type="number" name="number_of_students" id="number_of_students" min="0"
                            class=" block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            value="{{ old('number_of_students') }}">
                    </div>
                    <div class="mb-3 form-group">
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <!-- Use radio buttons for type -->
                        <div class="flex">
                            <div class="flex items-center">
                                <input type="radio" name="type" id="type-subscription" value="subscription"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('type')=='subscription' ? 'checked' : '' }} required>
                                <label for="type-subscription"
                                    class=" ml-3 block text-sm font-medium text-gray-700">Subscription</label>
                            </div>
                            <div class="flex items-center ml-4">
                                <input type="radio" name="type" id="type-wallet" value="wallet"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('type')=='wallet' ? 'checked' : '' }} required>
                                <label for="type-wallet"
                                    class=" ml-3 block text-sm font-medium text-gray700">Wallet</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="validity_duration" class="block text-sm font-medium text-gray-700 mb-2">Validity
                            Duration</label>
                        <div class="flex">
                            <div class="flex items-center">
                                <input type="radio" name="validity_duration" id="duration-month" value="1"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('duration')=='month' ? 'checked' : '' }} required>
                                <label for="duration-month"
                                    class=" ml-3 block text-sm font-medium text-gray-700">Monthly</label>
                            </div>
                            <div class="flex items-center ml-4">
                                <input type="radio" name="validity_duration" id="duration-annual" value="12"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('duration')=='annual' ? 'checked' : '' }} required>
                                <label for="duration-annual"
                                    class=" ml-3 block text-sm font-medium text-gray-700">Annual</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="is_active" class="block text-sm font-medium text-gray-700 mb-2">Is Active</label>
                        <div class="flex">
                            <div class="flex items-center">
                                <input type="radio" name="is_active" id="is_active-yes" value="1"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('is_active')=='yes' ? 'checked' : '' }} required>
                                <label for="is_active-yes"
                                    class=" ml-3 block text-sm font-medium text-gray-700">Yes</label>
                            </div>
                            <div class="flex items-center ml-4">
                                <input type="radio" name="is_active" id="is_active-no" value="0"
                                    class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{
                                    old('is_active')=='no' ? 'checked' : '' }} required>
                                <label for="is_active-no"
                                    class=" ml-3 block text-sm font-medium text-gray-700">No</label>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="mb-3 form-group flex items-center">
                        <input type="checkbox" name="is_active" id="is_active" value="1"
                            class=" focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ old('is_active')
                            ? 'checked' : '' }}>
                        <label for="is_active" class="ml-3 block text-sm font-medium text-gray700">Is
                            Active</label>
                    </div> --}}

                    <input type='hidden' name='created_by' value="{{ Auth::id() }}">
                    <input type='hidden' name='updated_by' value="{{ Auth::id() }}">
                    <div class="modal-footer">
                        <button type='button' id='submit-package-form'
                            class='p-2 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded'>Save
                            Package</button>
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
    $('.close-modal').on('click', function(e) {
        $("form :input").val('');
    });

    $('#submit-package-form').on('click', function(e) {
        e.preventDefault();

        let data = $("#package-form").serialize();

        $.ajax({
            url: "/packages",
            type: "POST",
            data: data,
            success: function(response) {
                console.log('Succeess', response.message);
                flasher.success(response.message);
                $('#add-package-modal').modal('hide');
                $("#add-package-modal").removeClass("in");
                $(".modal-backdrop").remove();
                $('body').removeClass('modal-open');
                $('body').css('padding-right', '');
                $("#add-package-modal").hide();
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