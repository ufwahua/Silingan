<template>
    <div>
        <div class="p-inputgroup mb-2">
            <Avatar
                image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                class="mr-2"
                size="large"
                shape="circle"
            />
            <Textarea class="w-full"> </Textarea>
        </div>
        <div class="p-inputgroup mb-2">
            <Avatar
                image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                class="mr-2"
                size="large"
                shape="circle"
            />
            <div
                class="card w-full p-2"
                style="background-color: var(--blue-50)"
            >
                <div class="grid grid-nogutter">
                    <div class="col-12 p-0 m-0">
                        <b class="p-0 m-0"> Joshua Henry Diamos</b>
                    </div>
                    <div class="col-12 p-0 m-0">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Aliquam doloremque quo explicabo voluptatum
                        ratione sunt ex facere a consequuntur quasi. Impedit eum
                        iste laboriosam ipsam voluptate molestias molestiae in
                        modi?
                    </div>
                </div>
            </div>
        </div>
        <div class="p-inputgroup mb-2">
            <Avatar
                image="https://www.primefaces.org/wp-content/uploads/2020/05/placeholder.png"
                class="mr-2"
                size="large"
                shape="circle"
            />
            <div class="card w-full p-2">
                <div class="grid grid-nogutter">
                    <div class="col-12 p-0 m-0">
                        <b class="p-0 m-0"> Joshua Henry Diamos</b>
                    </div>
                    <div class="col-12 p-0 m-0">
                        Lorem ipsum dolor, sit amet consectetur adipisicing
                        elit. Aliquam doloremque quo explicabo voluptatum
                        ratione sunt ex facere a consequuntur quasi. Impedit eum
                        iste laboriosam ipsam voluptate molestias molestiae in
                        modi?
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        comment: {
            type: Object,
        },
    },
};
</script>
