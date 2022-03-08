<template>
    <div>
        <div class="col-12 p-0 m-0">
            <div class="p-inputgroup pt-1 pb-0 my-0">
                <div>
                    <Avatar
                        image="http://127.0.0.1:8000/storage/images/default-prof-pic.png"
                        class="mr-2"
                        size="large"
                        shape="circle"
                    />
                </div>
                <div
                    class="card pb-0 pt-1 px-2 mb-0 mt-1"
                    style="background-color: var(--blue-50)"
                >
                    <div class="grid grid-nogutter">
                        <div class="col-12">
                            <b>
                                {{ reply.user[0].first_name }}
                                {{ reply.user[0].last_name }}
                            </b>
                        </div>
                        <div class="col-12 pb-1">
                            {{ reply.message }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 pl-7 p-0 m-0">
            {{ reply.updated_at }}
        </div>
    </div>
</template>
<script>
export default {
    props: {
        reply: {
            type: Object,
        },
    },
};
</script>
