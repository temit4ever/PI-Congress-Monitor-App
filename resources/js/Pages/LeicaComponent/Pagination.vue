<template>
    <ul class="pagination" v-if="lastPage && lastPage != 1">
        <li class="pagination__item">
            <Link v-if="currentPage != 1" :href="`${firstPageUrl}`" class="pagination__link pagination__first">
                First
            </Link>
            <span v-else class="pagination__link pagination__first" disabled>
            First
            </span>
        </li>
        <li class="pagination__item">
            <Link v-if="currentPage != 1"  :href="`${prevPageUrl}`" class="pagination__link pagination__prev">
                Previous
            </Link>
            <span v-else :href="`${prevPageUrl}`" class="pagination__link pagination__prev" disabled>
                Previous
            </span>
        </li>
        <li class="pagination__item pagination__item--current">
            <span>{{currentPage}}</span>/ {{lastPage}}
        </li>
        <li class="pagination__item">
            <Link v-if="currentPage != lastPage" :href="`${nextPageUrl}`" class="pagination__link pagination__next">
                Next
            </Link>
            <span v-else class="pagination__link pagination__next" disabled>
                Next
            </span>
        </li>
        <li class="pagination__item">
            <Link v-if="currentPage != lastPage" :href="`${lastPageUrl}`" class="pagination__link pagination__last">
                Last
            </Link>
            <span v-else class="pagination__link pagination__last" disabled>
            Last
            </span>
        </li>
    </ul>
</template>

<script>
export default {
  name: "Pagination.vue",
  props: {
   currentPage: String,
   firstPageUrl: String,
   from: String,
   lastPage: String,
   lastPageUrl: String,
   perPage: String,
    to: String,
    total: String,
    path: String,
    nextPageUrl: String,
    prevPageUrl: String,
  }
}
</script>

<style scoped>

</style>
