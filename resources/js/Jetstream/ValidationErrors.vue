<template>
    <div v-if="hasErrors">
      <div class="card__inner">
        <div class="font-medium" style="color: red"></div>

        <ul class="mt-3 list-disc list-inside" style="color: red">
          <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
      </div>
      </div>
</template>

<script>
    export default {
        computed: {
            errors() {
                return this.$page.props.errors
            },

            hasErrors() {
                return Object.keys(this.errors).length > 0;
            },
        }
    }
</script>
