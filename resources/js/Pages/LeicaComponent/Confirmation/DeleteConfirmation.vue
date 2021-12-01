<template>
<!--  <div class="card card&#45;&#45;narrowest card&#45;&#45;center delete-user">
    <div class="card__inner">
                <span class="icon icon&#45;&#45;red">
                    <Icons icon="trash-large" />
                </span>
      <h2 class="title">

&lt;!&ndash;      {{title}}
        &ndash;&gt;

      </h2>
      <div class="card__content card__content&#45;&#45;max-width">
        <p>

&lt;!&ndash;          {{message}}
          &ndash;&gt;
        </p>
      </div>
      <div class="buttons-group" id="show-modal">
        <a :href="route('user.index')" class="button">
          Cancel
        </a>
        <a :href="route('user.delete', {id: id})" class="button button&#45;&#45;red">
                        <span class="button__icon">
                            <Icons icon="trash" />
                        </span>
          Delete
        </a>
      </div>
    </div>
  </div>-->
  <div v-if="!modalActive">
    <danger-button class="button button--small button--red" @click="showModal()">
      Delete User
    </danger-button>
  </div>
  <transition name="fade">
    <div class="modal" ref="my-modal" v-if="modalActive" v-bind:class="{'is-active': modalActive}">
      <div class="modal__inner">
        <div class="card card--narrowest card--center">
          <div class="card__inner">
                            <span class="icon icon--red">
                                <Icons icon="trash-large" />
                            </span>
            <h2 class="title">
              Delete User
            </h2>
            <div class="card__content card__content--max-width">
              <p>
                {{ message }}
              </p>
            </div>
            <div class="buttons-group">
              <a :href="route(`${cancelPath}`)" class="button" @click="hideModal">
                Cancel
              </a>
              <a :href="`${deletePath}${itemId}`" class="button button&#45;&#45;red" @click="hideModal()">
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
import Icons from "../../../Components/Icons";
import DangerButton from "../../../Jetstream/DangerButton";
export default {
  name: "DeleteConfirmation.vue",
  components: {
    DangerButton,
    Icons,
  },
  props: {
    itemId: String,
    title: String,
    message: String,
    deletePath: String,
    cancelPath: String,
    modalActive: Boolean
  },
  data() {
    return {
      modalActive: false
    }
  },
  methods: {
    showModal() {
      this.modalActive = true
      //this.$refs['my-modal'].show()

    },
    hideModal() {
      this.modalActive = false
    }

    /*show(opts = {}) {
      this.title = opts.title
      this.message = opts.message
      this.okButton = opts.okButton
      if (opts.cancelButton) {
        this.cancelButton = opts.cancelButton
      }
      // Once we set our config, we tell the popup modal to open
      this.$refs.popup.open()
      // Return promise so the caller can get results
      return new Promise((resolve, reject) => {
        this.resolvePromise = resolve
        this.rejectPromise = reject
      })
    },

    _confirm() {
      return
    },

    _cancel() {
      this.$refs.popup.close()
      this.resolvePromise(false)
      // Or you can throw an error
      // this.rejectPromise(new Error('User cancelled the dialogue'))
    },*/
  },
}
</script>

<style scoped>

</style>
