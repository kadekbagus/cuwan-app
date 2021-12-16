<template>
    <div>
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
            'listData': null
        }
    },
    methods: {
        async getProductList() {
            const res = await fetch('api/products')
            const re = await res.json()
            this.listData = re.data.records;
            console.log(this.listData)
        }
    },
    created: function () {
        this.getProductList()
    }
}

</script>
