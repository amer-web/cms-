<template>
    <div class="list-group list-group-flush ">
    <div class="list-group-item d-flex  align-items-center" v-for="admin in admins" :key="admin.id">
        <div :id="admin.username" class="ml-2">
            <span class="avatar avatar-md brround cover-image" data-image-src="#"><span class="avatar-status bg-success"></span></span>
        </div>
        <div class="">
            <div class="font-weight-semibold text-capitalize ml-1" data-toggle="modal" data-target="#chatmodel">{{admin.username}}</div>
        </div>
        <div class="mr-auto">
            <a href="#" class="btn btn-sm btn-light" data-toggle="modal" data-target="#chatmodel" ><i class="fab fa-facebook-messenger"></i></a>
        </div>
    </div>
    </div>
</template>

<script>
export default {
    data: function (){
        return {
            admins: {}
        }

    },
    created: function (){
        this.getAdmins();
    },
    methods: {
        getAdmins(){
            axios.get('/admins-dash').then((res) => {
                this.admins = res.data;
            });
        }
    }
}
</script>


