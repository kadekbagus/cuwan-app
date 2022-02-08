<template>
    <div class="bg-gray-100">

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-5">
        <div class="border-t border-gray-200" />
        </div>
    </div>

    <div class="mt-10 sm:mt-0">
        <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Product Information</h3>
            <p class="mt-1 text-sm text-gray-600">
                product info such as price, discount, variants, etc.
            </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">

            <div class="shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                    <label for="first-name" class="block text-sm font-medium text-gray-700">Products Name</label>
                    <input v-model="name" type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="col-span-6">
                    <label for="street-address" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea v-model="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                    <label for="last-name" class="block text-sm font-medium text-gray-700">Price</label>
                    <input v-model="price" type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                    <label for="email-address" class="block text-sm font-medium text-gray-700">Discount</label>
                    <input v-model="discount" type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                    <label for="email-address" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input v-model="quantity" type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                    <label for="country" class="block text-sm font-medium text-gray-700">Status</label>
                    <select v-model="status" id="country" name="country" autocomplete="country-name" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    </div>
                </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button v-on:click="updateProduct()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
                </div>
            </div>


        </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
            <div class="border-t border-gray-200" />
            </div>
        </div>

    </div>

</template>

<script>

export default ({
    setup() {
        
    },
    data () {
        return { 
            name: '',
            description: '',
            status: '',
            price: '',
            discount: '',
            quantity: '',
            'apiUrl':this.appConfig.$api_url,
        }
    },
    props: {
        id: { type: String, required: true }
    },
    methods: {
        async getProductDetail() {
            const response = await fetch(`${this.apiUrl}/api/product/${this.id}`);
            if (response.status >= 200 && response.status <= 299) {
                const jsonResponse = await response.json();
                if (jsonResponse.code === 1 && jsonResponse.message === 'success') {
                    this.name = jsonResponse.data.name;
                    this.description = jsonResponse.data.description;
                    this.status = jsonResponse.data.status;
                    this.price = jsonResponse.data.price;
                    this.discount = jsonResponse.data.discount;
                    this.quantity = jsonResponse.data.quantity;
                }
            } else {
                console.log(response.status, response.statusText)
            }
        },
    },
    created: function () {
        this.getProductDetail()
    }
})
</script>
