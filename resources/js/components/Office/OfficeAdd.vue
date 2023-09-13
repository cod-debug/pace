<template>
    <div>
        <div class="container">
            <div class="bg-white shadow-lg p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="fa fa-building"></i> Add Office</h4>
                    <a href="/office" class="btn btn-secondary"><i class="fa fa-table"></i> Office List</a>
                </div>
                <div class="border border-muted my-2"></div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        data: () => ({
            to_add: [
                'name',
                'description'
            ],
        }),
        methods:{
            
        }
    }
</script>