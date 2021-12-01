<template>
  <app-layout title="Kee Uploads" :auth-user="user">
    <template #header>
      <h2>
        Upload Kees
      </h2>
      <p>
        Upload KEEs
      </p>
    </template>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Import Kee
        </h2>
        <div class="card__heading-button">
            <div class="buttons-group">
                <div class="cancel-heading">
                    <a :href="route('user.index')" class="button button--margin">
                        Cancel
                    </a>
                </div>
                <form class="form" @submit.prevent="upload" method="POST" enctype="multipart/form-data">
                    <button type="submit" class="button">
                        Save
                    </button>
                </form>
            </div>
        </div>
      </div>
      <form>
        <div class="form-split">
          <div class="form-split__item">
            <div class="form__item">
              <label for="kee_uploads" class="form__upload">
                <input type="file" id="kee_uploads" name="kee_uploads" @change="selectFile($event)">
                Upload Kees
              </label>
            </div>
          </div>
        </div>
      </form>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "../../Layouts/AppLayout";
import {reactive} from "vue";
import {Inertia} from "@inertiajs/inertia";
export default {
  name: "KeeUpload.vue",
  components: {
    AppLayout
  },
  props: {
    user: Object
  },
  methods: {
     selectFile(event) {
  this.form.kee_uploads = event.target.files[0];
}
  },
  setup () {
    const form = reactive({
      kee_uploads: null,
    })

    function upload() {
      Inertia.post(route('keeupload.store'), form)
    }

  return { form, upload }

  },
}
</script>

<style scoped>

</style>
