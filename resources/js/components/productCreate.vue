
<template>
<div>

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
                <button v-on:click="createProduct()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Save
                </button>
                </div>
            </div>


  <div v-for="(find) in finds" :key="find.id">
    <input v-model="find.value">
    <input v-model="find.price">
  </div>
  <button @click="addFind">
    New Find
  </button>


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

export default {
    data () {
        return {
            name: '',
            description: '',
            status: '',
            price: '',
            discount: '',
            quantity: '',
            finds: [],
            apiUrl: this.appConfig.$api_url,
        }
    },
    methods: {
        buildQueryString () {
            let details = {
                'name': this.name,
                'description': this.description,
                'status': this.status,
                'price': this.price,
                'discount': this.discount,
                'quantity': this.quantity,
                'find': this.finds
            }

            let formBody = [];
            for (let property in details) {
                let encodedKey = encodeURIComponent(property);
                let encodedValue = encodeURIComponent(details[property]);
                formBody.push(encodedKey + "=" + encodedValue);
            }
            formBody = formBody.join("&");

            return formBody;
        },
        createProduct () {
            let formBody = this.buildQueryString();
            console.log(formBody);
            this.postData(`${this.apiUrl}/api/product/store`, formBody)
            .then(data => {
                if (data.code === 14) {
                    console.log(data.message);
                }
                //console.log(data);
                this.clearForm();
            });
        },
        async postData(url = '', formBody) {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                mode: 'same-origin', // no-cors, *cors, same-origin
                cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
                credentials: 'same-origin', // include, *same-origin, omit
                headers: {
                //'Content-Type': 'application/json'
                'Content-Type': 'application/x-www-form-urlencoded',
                },
                //redirect: 'follow', // manual, *follow, error
                //referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
                body: formBody//JSON.stringify(data) // body data type must match "Content-Type" header
            });
            return response.json(); // parses JSON response into native JavaScript objects
        },
        clearForm: function (e) {
            this.name = '',
            this.description = '',
            this.status = '',
            this.price = '',
            this.discount = ''
        },
        addFind: function () {
            this.finds.push({ value: '', price: '' });
        },
    }
}
</script>


<style scoped>

</style>