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
                  <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
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
                    this.numPage = this.totalRecords%this.perPage
                }
                console.log(this.numPage)
            } else {
                console.log(response.status, response.statusText)
            }
        },
        formatDate(input) {
            return moment(String(input)).format('MM/DD/YYYY hh:mm')
        }
    },
    created: function () {
        this.getProductList()
    }
}

</script>
