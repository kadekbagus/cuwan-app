<template>
  <div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  No
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Product Name
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Status
                </th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Created Date
                </th>
                <th scope="col" class="relative px-6 py-3">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="(data,index) in listData" :key="data.id">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">
                        {{ index+1 }}
                      </div>

                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-gray-900">{{ data.name }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                  v-bind:class = "(data.status=='active')?'bg-green-100 text-green-800':'bg-red-100 text-red-800'">
                    {{ data.status }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ formatDate(data.created_at) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <a :href="'/product/edit/' + data.product_id" class="text-indigo-600 hover:text-indigo-900">Edit</a> |
                  <a v-on:click="deleteProduct(data.product_id)" href="#" class="text-indigo-600 hover:text-indigo-900">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
          <div>
            <a v-for="(data,index) in numPage" :key="data.id" href="#" v-on:click="getProductList(5, index*5)">{{ index+1 }}|</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import moment from 'moment'

export default {
    data () {
        return {
            'listData': null,
            'totalRecords': null,
            'returnedRecords': null,
            'numPage': 1,
            'perPage': 5,
            'take': 5,
            'skip': 0,
        }
    },
    methods: {
        async getProductList(take=5, skip=0) {
            const response = await fetch(`api/products?take=${take}&skip=${skip}`);
            if (response.status >= 200 && response.status <= 299) {
                const jsonResponse = await response.json();
                if (jsonResponse.code === 1 && jsonResponse.message === 'success') {
                    this.listData = jsonResponse.data.records;
                    this.totalRecords = jsonResponse.data.total_records;
                    this.returnedRecords = jsonResponse.data.returned_records;
                    this.numPage = Math.ceil(this.totalRecords/this.perPage);
                }
                console.log(this.totalRecords)
                console.log(this.perPage)
                console.log(this.numPage)
            } else {
                console.log(response.status, response.statusText)
            }
        },
        formatDate(input) {
            return moment(String(input)).format('MM/DD/YYYY hh:mm')
        },
        deleteProduct(id) {
          let queryString = `http://localhost:8585/api/product/${id}`;
          console.log(queryString);
          this.postData(queryString, '')
            .then(data => {
                if (data.code === 14) {
                    console.log(data.message);
                }
                console.log(data);
                this.getProductList();
                //this.clearForm();
          });
        },
        async postData(url = '', formBody = '') {
            // Default options are marked with *
            const response = await fetch(url, {
                method: 'DELETE', // *GET, POST, PUT, DELETE, etc.
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
    },
    created: function () {
        this.getProductList()
    }
}

</script>
