<template>
    <transition name="fade">
        <div class="modal" v-if="modalActive === true">
            <div class="modal__inner">
                <div class="card card--narrowest card--center">
                    <div class="card__inner">
                        <span class="icon icon--red">
                            <Icons icon="trash-large" />
                        </span>
                        <h2 class="title">
                            {{ title }}
                        </h2>
                        <div class="card__content card__content--max-width">
                            <p>
                                {{ content }}
                            </p>
                        </div>
                        <div class="buttons-group">
                            <button @click="$emit('hideModal', false)" class="button">
                                Cancel
                            </button>
                            <a :href="route(deleteRoute, {id: id})" class="button button--red">
                                <span class="button__icon">
                                    <Icons icon="trash" />
                                </span>
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
    import Icons from '@/Components/Icons.vue';
    export default {
        components: {
            Icons,
        },
        props: {
            modalActive: String,
            title: String,
            content: String,
            id: String,
            deleteRoute: String
        }
    }
</script>
