<template>
    <div class="bg-gray-300">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product Name</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody class="text-cyan-900 text-center">
                <tr v-for="(data,index) in listData" :key="data.id" class="bg-cyan-300">
                    <td class="py-3 px-6">{{ index+1 }}</td>
                    <td class="py-3 px-6">{{ data.name }}</td>
                    <td class="py-3 px-6">{{ data.status }}</td>
                    <td class="py-3 px-6">{{ data.created_at }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>

export default {
    data () {
        return {
            'listData': null,
            'totalRecords': null,
            'returnedRecords': null
        }
    },
    methods: {
        async getProductList() {
            const response = await fetch('api/products');
            if (response.status >= 200 && response.status <= 299) {
                const jsonResponse = await response.json();
                if (jsonResponse.code === 1 && jsonResponse.message === 'success') {
                    this.listData = jsonResponse.data.records;
                    this.totalRecords = jsonResponse.data.total_records;
                    this.returnedRecords = jsonResponse.data.returned_records;
                }
            } else {
                console.log(response.status, response.statusText)
            }
        }
    },
    created: function () {
        this.getProductList()
    }
}

</script>
